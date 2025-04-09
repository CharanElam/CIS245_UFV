# CIS245_UFV
# Patient Management System

## 📌 Overview

The **Patient Management System** is a web-based application developed for the **CIS 245: Intermediate Web Programming** course at the **University of the Fraser Valley (UFV)**. It allows medical staff to efficiently manage patient records, including functionalities for user authentication, record entry, and secure data retrieval.

---

## 🚀 Features

- 🔐 **User Authentication** (Login & Registration)
- 📝 **Patient Records Management** (Add, View, Update)
- 👨‍⚕️ **Role-Based Dashboards**
  - Staff Dashboard
  - Patient Dashboard
- 📱 **Responsive Design** (Works on all screen sizes)

---

## ⚙️ Prerequisites

Before running the application locally, ensure you have the following installed:

- [XAMPP](https://www.apachefriends.org/index.html) (or equivalent stack with):
  - Apache Server
  - MySQL Database
  - PHP

---

## 🛠️ Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/CharanElam/CIS245_UFV.git

### 2. 📥 Import the Database

1. Launch **phpMyAdmin** or your preferred **MySQL client**.
2. Create a **new database** (e.g., `cis245_db`).
3. Import the file named `CIS245_database.sql` into the new database:
   - In phpMyAdmin:
     - Select your new database from the sidebar.
     - Click on the **Import** tab.
     - Choose the `CIS245_database.sql` file from your system.
     - Click **Go** to execute the import.

### 3. ⚙️ Configure the Database Connection

- Open the file `connection.php` and update the credentials:

```php
$servername = "localhost";
$username = "your_mysql_username";
$password = "your_mysql_password";
$dbname = "cis245_db"; // or the name you used

### 4. 📂 Move Project Files to Server Directory

- Copy the entire folder into `htdocs/` if using **XAMPP** (or equivalent web root folder).

### 5. 🖥️ Start Server & Run the Application

- Open the **XAMPP Control Panel**, start **Apache** and **MySQL**.
- Visit the app in your browser:

```bash
http://localhost/CIS245_UFV/index.php

## 📁 Project Structure

```bash
CIS245_UFV/
│
├── index.php              # Landing page
├── login.php              # Login form
├── register.php           # Registration page
├── patient_dashboard.php  # Dashboard for patients
├── staff_dashboard.php    # Dashboard for staff
├── patient_records.php    # Patient records interface
├── staff_records.php      # Staff records interface
├── connection.php         # DB connection configuration
├── medique.css            # Main stylesheet
├── images/                # Contains logos and headers
└── CIS245_database.sql    # Database schema file

## 👥 Usage

### For Staff

1. Register via `register.php`
2. Log in via `login.php`
3. Manage patient records through staff dashboard

### For Patients

1. Log in to access personal dashboard
2. View personal medical records

## Acknowledgments

Developed as a term project for **CIS 245 – Intermediate Web Programming** at the **University of the Fraser Valley**.  
Thanks to the instructor and peers who provided valuable feedback and guidance.
