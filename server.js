const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');

const app = express();
const PORT = 3000;

// Middleware
app.use(cors());
app.use(express.json());

// MySQL Connection Pool
const pool = mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: '',        // <-- Change this to your MySQL password if needed
    database: 'echannelling',
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0
});

const db = pool.promise();

// Test database connection on startup
pool.getConnection((err, connection) => {
    if (err) {
        console.error('❌ MySQL connection failed:', err.message);
        console.error('   Make sure MySQL is running and the echannelling database exists.');
    } else {
        console.log('✅ Connected to MySQL — echannelling database');
        connection.release();
    }
});

// ===== API ROUTES =====

// GET /api/doctors — List all doctors (with optional search & specialization filter)
app.get('/api/doctors', async (req, res) => {
    try {
        const { search, specialization } = req.query;
        let query = 'SELECT * FROM doctors';
        const params = [];
        const conditions = [];

        if (search) {
            conditions.push('dname LIKE ?');
            params.push(`%${search}%`);
        }
        if (specialization) {
            conditions.push('specialization = ?');
            params.push(specialization);
        }
        if (conditions.length > 0) {
            query += ' WHERE ' + conditions.join(' AND ');
        }

        const [rows] = await db.query(query, params);
        res.json(rows);
    } catch (err) {
        console.error('Error fetching doctors:', err.message);
        res.status(500).json({ error: 'Failed to fetch doctors' });
    }
});

// GET /api/doctors/:id — Get a single doctor by ID
app.get('/api/doctors/:id', async (req, res) => {
    try {
        const [rows] = await db.query('SELECT * FROM doctors WHERE did = ?', [req.params.id]);
        if (rows.length === 0) {
            return res.status(404).json({ error: 'Doctor not found' });
        }
        res.json(rows[0]);
    } catch (err) {
        console.error('Error fetching doctor:', err.message);
        res.status(500).json({ error: 'Failed to fetch doctor' });
    }
});

// GET /api/specializations — Get distinct specializations for the filter dropdown
app.get('/api/specializations', async (req, res) => {
    try {
        const [rows] = await db.query('SELECT DISTINCT specialization FROM doctors ORDER BY specialization');
        res.json(rows.map(r => r.specialization));
    } catch (err) {
        console.error('Error fetching specializations:', err.message);
        res.status(500).json({ error: 'Failed to fetch specializations' });
    }
});

// POST /api/appointments — Create a new appointment (and patient if needed)
app.post('/api/appointments', async (req, res) => {
    const connection = await db.getConnection();
    try {
        const { patientName, email, phone, doctorId, appointDate } = req.body;

        // Validate required fields
        if (!patientName || !email || !phone || !doctorId || !appointDate) {
            return res.status(400).json({ error: 'Missing required fields: patientName, email, phone, doctorId, appointDate' });
        }

        await connection.beginTransaction();

        // Check if patient already exists by email
        const [existing] = await connection.query('SELECT pid FROM Patients WHERE email = ?', [email]);
        let patientId;

        if (existing.length > 0) {
            // Patient exists — use their ID
            patientId = existing[0].pid;
        } else {
            // Insert new patient (password set to a default since booking form doesn't collect it)
            const [result] = await connection.query(
                'INSERT INTO Patients (pname, email, ppassword, contact) VALUES (?, ?, ?, ?)',
                [patientName, email, 'temp1234', phone]
            );
            patientId = result.insertId;
        }

        // Insert the appointment
        const [appointResult] = await connection.query(
            'INSERT INTO appointments (pid, did, appoint_date, appoint_status) VALUES (?, ?, ?, ?)',
            [patientId, doctorId, appointDate, 'Pending']
        );

        await connection.commit();

        res.status(201).json({
            message: 'Appointment booked successfully',
            appointmentId: appointResult.insertId,
            patientId: patientId,
            reference: `APT-${appointResult.insertId.toString().padStart(5, '0')}`
        });

    } catch (err) {
        await connection.rollback();
        console.error('Error creating appointment:', err.message);
        if (err.code === 'ER_DUP_ENTRY') {
            res.status(409).json({ error: 'A patient with this email already exists with different details.' });
        } else {
            res.status(500).json({ error: 'Failed to book appointment' });
        }
    } finally {
        connection.release();
    }
});

// Start server
app.listen(PORT, () => {
    console.log(`🏥 Hospital API server running at http://localhost:${PORT}`);
    console.log(`   Doctors endpoint: http://localhost:${PORT}/api/doctors`);
});
