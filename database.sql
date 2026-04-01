USE `if0_41549197_db_students`;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) UNIQUE NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    course VARCHAR(100) NOT NULL,
    year_level ENUM('1st Year','2nd Year','3rd Year','4th Year') NOT NULL,
    section VARCHAR(20),
    contact_number VARCHAR(20),
    address TEXT,
    gwa DECIMAL(3,2) DEFAULT 0.00,
    status ENUM('Active','Inactive','Graduated','Dropped') DEFAULT 'Active',
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students (student_id, first_name, last_name, email, course, year_level, section, contact_number, gwa, status) VALUES
('2024-0001', 'Maria', 'Santos', 'maria.santos@school.edu', 'BS Information Technology', '3rd Year', 'A', '09171234567', 1.75, 'Active'),
('2024-0002', 'Juan', 'Dela Cruz', 'juan.delacruz@school.edu', 'BS Computer Science', '2nd Year', 'B', '09281234567', 2.00, 'Active'),
('2023-0015', 'Ana', 'Reyes', 'ana.reyes@school.edu', 'BS Information Systems', '4th Year', 'A', '09391234567', 1.50, 'Active'),
('2022-0008', 'Carlo', 'Garcia', 'carlo.garcia@school.edu', 'BS Computer Engineering', '1st Year', 'C', '09501234567', 2.25, 'Active');
