# Hospital Management System

A simple hospital management system built with HTML, PHP, and MySQL using XAMPP.

## Features

### For Patients:
- User registration and login
- View available doctors
- Filter doctors by specialization
- Book appointments with doctors
- Send messages to doctors
- View appointment history

### For Doctors:
- Doctor registration and login (with specialization)
- View scheduled appointments
- View messages from patients
- Reply to patient messages

## Setup Instructions

1. **Install XAMPP**
   - Download and install XAMPP from https://www.apachefriends.org/

2. **Start Services**
   - Open XAMPP Control Panel
   - Start Apache and MySQL services

3. **Setup Database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Import the `database.sql` file or run the SQL commands manually

4. **Deploy Files**
   - Copy all project files to `C:\xampp\htdocs\hospital_management\`

5. **Access the Application**
   - Open browser and go to `http://localhost/hospital_management/`

## File Structure

- `index.html` - Main page with role selection
- `config.php` - Database connection configuration
- `database.sql` - Database schema
- `doctor_login.php` - Doctor login page
- `doctor_signup.php` - Doctor registration page
- `doctor_dashboard.php` - Doctor dashboard
- `patient_login.php` - Patient login page
- `patient_signup.php` - Patient registration page
- `patient_dashboard.php` - Patient dashboard
- `book_appointment.php` - Appointment booking handler
- `send_message.php` - Message sending handler
- `send_reply.php` - Reply handler for doctors
- `logout.php` - Logout handler

## Database Tables

1. **doctors** - Stores doctor information including specialization
2. **patients** - Stores patient information
3. **appointments** - Stores appointment bookings
4. **messages** - Stores messages between patients and doctors

## Usage

1. Start with the main page to select your role (Doctor or Patient)
2. Register a new account or login with existing credentials
3. Patients can browse doctors, book appointments, and send messages
4. Doctors can view their appointments and respond to patient messages

## Security Features

- Password hashing using PHP's password_hash()
- Prepared statements to prevent SQL injection
- Session management for user authentication
- Input validation and sanitization

## Technologies Used

- HTML5 for structure
- CSS3 for styling (minimal as requested)
- PHP for server-side logic
- MySQL for database
- MySQLi for database connectivity (as requested, not PDO)