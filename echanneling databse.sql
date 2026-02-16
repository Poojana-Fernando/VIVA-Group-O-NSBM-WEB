CREATE DATABASE IF NOT EXISTS echannelling;

USE echannelling;

CREATE TABLE IF NOT EXISTS Patients(
pid INT AUTO_INCREMENT PRIMARY KEY,
pname VARCHAR(100)NOT NULL,
email VARCHAR(60)UNIQUE NOT NULL,
ppassword VARCHAR(50) NOT NULL,
contact VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS doctors(
did INT AUTO_INCREMENT PRIMARY KEY,
dname VARCHAR(100) NOT NULL,
specialization VARCHAR(100) NOT NULL,
fee DECIMAL(10, 2),
present_days VARCHAR(100)
);



CREATE TABLE IF NOT EXISTS appointments(
id INT AUTO_INCREMENT PRIMARY KEY,
pid INT NOT NULL,
did INT NOT NULL,
appoint_date DATE NOT NULL,
appoint_status ENUM('Pending', 'Confirmed', 'Cancelled') DEFAULT 'Pending',
FOREIGN KEY (pid) REFERENCES Patients(pid) ON DELETE CASCADE,
FOREIGN KEY (did) REFERENCES doctors(did) ON DELETE CASCADE);


-- ===== SEED DATA: Doctors =====
INSERT INTO doctors (dname, specialization, fee, present_days) VALUES
('Dr. Chamidu Rathnayake', 'Cardiology', 3500.00, 'Mon, Wed, Fri'),
('Dr. Sarah Silva', 'Neurology', 4000.00, 'Tue, Thu, Sat'),
('Dr. Nilanthi Appuhamy', 'Oncology', 5000.00, 'Mon, Tue, Wed'),
('Dr. James White', 'Orthopedics', 3000.00, 'Wed, Thu, Fri'),
('Dr. Kavitha Fernando', 'Pediatrics', 2500.00, 'Mon, Wed, Sat'),
('Dr. Amal Jayasena', 'Nephrology', 4500.00, 'Tue, Fri, Sat');
