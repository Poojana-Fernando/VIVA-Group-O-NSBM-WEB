const API = 'api';

// ===== Load Doctors from Database =====
async function loadDoctors() {
  try {
    const res = await fetch(`${API}/doctors.php`);
    if (!res.ok) throw new Error('API error');
    const doctors = await res.json();
    displayDoctors(doctors);
    populateDoctorSelect(doctors);
    window._allDoctors = doctors;
  } catch (err) {
    document.getElementById('doctor-list').innerHTML =
      '<p class="no-results">⚠ Could not load doctors. Make sure PHP and MySQL are running.</p>';
  }
}

function displayDoctors(doctors) {
  const container = document.getElementById('doctor-list');
  if (doctors.length === 0) {
    container.innerHTML = '<p class="no-results">No doctors found.</p>';
    return;
  }
  container.innerHTML = doctors.map(d => `
    <div class="doctor-card">
      <h3>${d.dname}</h3>
      <p class="specialty">${d.specialization}</p>
      <p class="details">
        Fee: Rs. ${Number(d.fee).toLocaleString()}
        ${d.present_days ? `<br>Available: ${d.present_days}` : ''}
      </p>
    </div>
  `).join('');
}

function populateDoctorSelect(doctors) {
  const select = document.getElementById('doctor-select');
  select.innerHTML = '<option value="">Select a doctor</option>' +
    doctors.map(d => `<option value="${d.did}">${d.dname} — ${d.specialization}</option>`).join('');
}

// ===== Load Specializations from Database =====
async function loadSpecializations() {
  try {
    const res = await fetch(`${API}/specializations.php`);
    if (!res.ok) return;
    const specs = await res.json();
    const select = document.getElementById('specialization');
    select.innerHTML = '<option value="">All Specializations</option>' +
      specs.map(s => `<option value="${s}">${s}</option>`).join('');
  } catch (err) { /* use empty dropdown */ }
}

// ===== Filter Doctors =====
function filterDoctors() {
  const search = document.getElementById('search').value.toLowerCase();
  const spec = document.getElementById('specialization').value;
  const all = window._allDoctors || [];
  const filtered = all.filter(d => {
    const matchName = d.dname.toLowerCase().includes(search);
    const matchSpec = !spec || d.specialization === spec;
    return matchName && matchSpec;
  });
  displayDoctors(filtered);
}

// ===== Book Appointment (POST to Database) =====
async function bookAppointment(e) {
  e.preventDefault();
  const msg = document.getElementById('form-message');
  const btn = document.getElementById('submit-btn');

  const data = {
    doctorId: Number(document.getElementById('doctor-select').value),
    appointDate: document.getElementById('appoint-date').value,
    patientName: document.getElementById('patient-name').value.trim(),
    email: document.getElementById('patient-email').value.trim(),
    phone: document.getElementById('patient-phone').value.trim()
  };

  btn.disabled = true;
  btn.textContent = 'Booking...';
  msg.className = '';
  msg.style.display = 'none';

  try {
    const res = await fetch(`${API}/appointments.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });
    const result = await res.json();

    if (!res.ok) throw new Error(result.error || 'Booking failed');

    msg.textContent = `✅ Appointment booked! Reference: ${result.reference}`;
    msg.className = 'success';
    msg.style.display = 'block';
    e.target.reset();
  } catch (err) {
    msg.textContent = `❌ ${err.message}`;
    msg.className = 'error';
    msg.style.display = 'block';
  } finally {
    btn.disabled = false;
    btn.textContent = 'Book Appointment';
  }
}

// ===== Init =====
document.addEventListener('DOMContentLoaded', () => {
  loadDoctors();
  loadSpecializations();

  document.getElementById('search').addEventListener('input', filterDoctors);
  document.getElementById('specialization').addEventListener('change', filterDoctors);
  document.getElementById('booking-form').addEventListener('submit', bookAppointment);

  // Set min date to today
  document.getElementById('appoint-date').min = new Date().toISOString().split('T')[0];
});
