CREATE DATABASE IF NOT EXISTS medique;
USE medique;
SHOW TABLES;

CREATE TABLE IF NOT EXISTS patients(
patient_id INT PRIMARY KEY AUTO_INCREMENT,
patient_first_name VARCHAR(100) NOT NULL,
patient_last_name VARCHAR(100) NOT NULL,
patient_email VARCHAR(100) NOT NULL UNIQUE,
patient_password VARCHAR(100) NOT NULL,
patient_city VARCHAR(100) NOT NULL,
patient_phone VARCHAR(15) NOT NULL,
emergency_contact_name VARCHAR(100),
emergency_contact_phone VARCHAR(15)
);

CREATE TABLE IF NOT EXISTS staff(
staff_id INT PRIMARY KEY AUTO_INCREMENT,
staff_first_name VARCHAR(100) NOT NULL,
staff_last_name VARCHAR(100) NOT NULL,
staff_email VARCHAR(100) NOT NULL UNIQUE,
staff_password VARCHAR(100) NOT NULL,
staff_role ENUM("Staff", "Admin") NOT NULL
);

CREATE TABLE IF NOT EXISTS queue(
patient_id INT NOT NULL,
queue_position INT NOT NULL,
added_by INT NULL,
queue_date DATE NOT NULL,
queue_time TIME NOT NULL,
priority INT DEFAULT 0,
status ENUM("Active", "Completed", "Dropped") NOT NULL,
FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
FOREIGN KEY (added_by) REFERENCES staff(staff_id)
);

CREATE TABLE IF NOT EXISTS visit_records(
record_id INT PRIMARY KEY AUTO_INCREMENT,
patient_id INT NOT NULL,
queue_date DATE NOT NULL,
status ENUM("Active", "Completed", "Dropped") NOT NULL,
FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
); 
