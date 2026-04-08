# EduTrack SIS — Student Information System

A web-based Student Information System (SIS) built with PHP and MySQL for managing student enrollment records through a clean, modern interface.

> **Course:** ITEL 203

---

## Features

- **Dashboard** — View real-time enrollment statistics, course distribution charts, and recently added students
- **Student Records** — Browse and search all student records in a sortable table
- **Enroll Students** — Add new students through a validated enrollment form
- **Edit Records** — Update any student's information at any time
- **Delete Records** — Remove records with a confirmation prompt to prevent accidental deletions
- **Search & Filter** — Search by name, student ID, or email; filter by course and enrollment status

---

## Tech Stack

| Technology | Purpose |
|---|---|
| PHP 8 | Backend logic, form handling, and database interaction |
| MySQL | Relational database for storing student records |
| Bootstrap 5 | Responsive, mobile-friendly UI framework |
| Bootstrap Icons | Icon library |
| HTML & CSS | Page structure and custom styling |
| XAMPP | Local development environment (Apache + MySQL + PHP) |

---

## Project Structure

```
student-system/
├── index.php           # Dashboard — enrollment stats and recent students
├── students.php        # Student records table with search and filter
├── create.php          # Enroll new student form
├── update.php          # Edit existing student record
├── delete.php          # Delete student record handler
├── about-project.php   # Project info page
├── nav.php             # Shared navigation (included on every page)
├── config.php          # Database connection and input sanitization helper
├── database.sql        # SQL schema and sample data
└── assets/
    └── styles.css      # Custom styles
```

---

## Database Schema

The system uses a single `students` table:

| Column | Type | Description |
|---|---|---|
| `id` | INT (PK, Auto Increment) | Internal record ID |
| `student_id` | VARCHAR(20), UNIQUE | School-assigned student ID (e.g. `2024-0001`) |
| `first_name` | VARCHAR(100) | Student's first name |
| `last_name` | VARCHAR(100) | Student's last name |
| `email` | VARCHAR(150) | Email address |
| `course` | VARCHAR(100) | Enrolled program/course |
| `year_level` | ENUM | `1st Year`, `2nd Year`, `3rd Year`, `4th Year` |
| `section` | VARCHAR(20) | Section (optional) |
| `contact_number` | VARCHAR(20) | Phone number (optional) |
| `address` | TEXT | Home address (optional) |
| `gwa` | DECIMAL(3,2) | General Weighted Average (0.00–5.00) |
| `status` | ENUM | `Active`, `Inactive`, `Graduated`, `Dropped` |
| `enrolled_at` | TIMESTAMP | Date/time of enrollment (auto-set) |

**Supported Courses:**
- BS Information Technology
- BS Computer Science
- BS Information Systems
- BS Computer Engineering
- BS Electronics Engineering
- Associate in Computer Technology

---

## Installation & Setup

### Prerequisites

- [XAMPP](https://www.apachefriends.org/) (or any Apache + MySQL + PHP 8 stack)
- A web browser

### Steps

1. **Clone or extract** the project into your XAMPP `htdocs` folder:
   ```
   C:/xampp/htdocs/student-system/
   ```

2. **Start XAMPP** — ensure Apache and MySQL services are running.

3. **Create the database:**
   - Open your browser and go to `http://localhost/phpmyadmin`
   - Create a new database (e.g., `db_students`)
   - Select the database, go to the **Import** tab
   - Upload and run `database.sql` to create the table and load sample data

4. **Configure the database connection** in `config.php`:
   ```php
   $host     = "localhost";
   $user     = "root";        // your MySQL username
   $password = "";            // your MySQL password (blank by default in XAMPP)
   $dbname   = "db_students"; // the database you created
   ```

5. **Open the app** in your browser:
   ```
   http://localhost/student-system/
   ```

---

## Usage

| Page | URL | Description |
|---|---|---|
| Dashboard | `index.php` | Overview, stats, and recently enrolled students |
| Students | `students.php` | Full list with search, filter, edit, and delete |
| Add Student | `create.php` | Form to enroll a new student |
| About | `about-project.php` | Project information and tech stack |

---

## Screenshots

> *(Add screenshots of the Dashboard, Students list, and Enroll form here)*

---

## License

This project was built for academic purposes as part of **ITEL 203**.
