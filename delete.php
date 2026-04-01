<?php
// delete.php — DELETE a student record
include 'config.php';

$id = intval($_GET['id'] ?? 0);

if ($id) {
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: students.php?deleted=1");
exit();
?>
