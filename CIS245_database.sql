CREATE DATABASE IF NOT EXISTS mediqueue;
USE mediqueue;
SHOW TABLES;

CREATE TABLE IF NOT EXISTS patients(
patient_id INT PRIMARY KEY,
patient_first_name VARCHAR(100) NOT NULL,
patient_last_name VARCHAR(100) NOT NULL,
patient_email VARCHAR(100) NOT NULL,
patient_password VARCHAR(100) NOT NULL,
patient_city VARCHAR(100) NOT NULL,
patient_phone INT NOT NULL,
emergency_contact_name VARCHAR(100),
emergency_contact_phone VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS staff(
staff_id INT PRIMARY KEY,
staff_first_name VARCHAR(100) NOT NULL,
staff_last_name VARCHAR(100) NOT NULL,
staff_email VARCHAR(100) NOT NULL,
staff_password VARCHAR(100) NOT NULL,
staff_role ENUM("Staff", "Admin") NOT NULL
);

CREATE TABLE IF NOT EXISTS queue(
queue_id INT PRIMARY KEY,
patient_id INT NOT NULL,
queue_position INT AUTO_INCREMENT,
added_by INT DEFAULT 0,
queue_date DATE NOT NULL,
queue_time TIME NOT NULL,
priority INT AUTO_INCREMENT,
status ENUM("Completed", "Dropped") NOT NULL,
FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
FOREIGN KEY (added_by) REFERENCES staff(staff_id)
);

CREATE TABLE IF NOT EXISTS visit_records(
record_id INT PRIMARY KEY,
patient_id INT NOT NULL,
queue_id INT NOT NULL,
FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
FOREIGN KEY (queue_id) REFERENCES queue(queue_id)
); 
