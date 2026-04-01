<?php
// config.php — Database Connection
// Student Information System

$host     = "sql113.infinityfree.com";
$user     = "if0_41549197 ";
$password = "7fOmn8TboDqur";
$dbname   = "if0_41549197_db_students";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// Helper: sanitize input
function clean($conn, $data) {
    return htmlspecialchars(strip_tags(mysqli_real_escape_string($conn, trim($data))));
}
?>
