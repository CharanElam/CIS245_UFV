CREATE DATABASE IF NOT EXISTS medione;
USE medione;
SHOW TABLES;

CREATE TABLE IF NOT EXISTS patients(
patient_id INT PRIMARY KEY,
patient_first_name VARCHAR(100),
patient_last_name VARCHAR(100),
patient_email VARCHAR(100),
patient_password VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS staff(
staff_id INT PRIMARY KEY,
staff_first_name VARCHAR(100),
staff_last_name VARCHAR(100),
staff_email VARCHAR(100),
staff_password VARCHAR(100),
staff_role ENUM("Surgery","Anesthesia","Pathology") NULL
);

CREATE TABLE IF NOT EXISTS queue(
queue_id INT PRIMARY KEY,
patient_id INT,
queue_position INT,
added_by INT,
queue_date DATE,
queue_time TIME,
priority INT,
FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
FOREIGN KEY (added_by) REFERENCES staff(staff_id)
);

CREATE TABLE IF NOT EXISTS visit_records(
record_id INT PRIMARY KEY,
patient_id INT,
queue_id INT,
FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
FOREIGN KEY (queue_id) REFERENCES queue(queue_id)
); 