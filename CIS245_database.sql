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