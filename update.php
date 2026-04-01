<?php
// update.php — UPDATE a student record
include 'config.php';
$pageTitle = 'Edit Student';
$errors = [];

$id = intval($_GET['id'] ?? 0);
if (!$id) { header("Location: students.php"); exit(); }

// Fetch existing record
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$student = $res->fetch_assoc();
$stmt->close();

if (!$student) { header("Location: students.php"); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id     = clean($conn, $_POST['student_id']);
    $first_name     = clean($conn, $_POST['first_name']);
    $last_name      = clean($conn, $_POST['last_name']);
    $email          = clean($conn, $_POST['email']);
    $course         = clean($conn, $_POST['course']);
    $year_level     = clean($conn, $_POST['year_level']);
    $section        = clean($conn, $_POST['section'] ?? '');
    $contact_number = clean($conn, $_POST['contact_number'] ?? '');
    $address        = clean($conn, $_POST['address'] ?? '');
    $gwa            = floatval($_POST['gwa'] ?? 0);
    $status         = clean($conn, $_POST['status']);

    if (!$first_name)  $errors[] = "First name is required.";
    if (!$last_name)   $errors[] = "Last name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (!$course)      $errors[] = "Course is required.";
    if ($gwa < 0 || $gwa > 5) $errors[] = "GWA must be between 0 and 5.";

    // Check duplicate student_id (exclude current)
    $check = $conn->query("SELECT id FROM students WHERE student_id='$student_id' AND id != $id");
    if ($check->num_rows > 0) $errors[] = "Student ID '$student_id' is already used by another record.";

    if (empty($errors)) {
        $stmt2 = $conn->prepare("UPDATE students SET student_id=?,first_name=?,last_name=?,email=?,course=?,year_level=?,section=?,contact_number=?,address=?,gwa=?,status=? WHERE id=?");
        $stmt2->bind_param("sssssssssdsi", $student_id,$first_name,$last_name,$email,$course,$year_level,$section,$contact_number,$address,$gwa,$status,$id);
        if ($stmt2->execute()) {
            header("Location: students.php?updated=1");
            exit();
        } else {
            $errors[] = "Database error: " . $stmt2->error;
        }
        $stmt2->close();
    }
    // Repopulate with submitted data on error
    $student = array_merge($student, $_POST);
}

$courses_list = ['BS Information Technology','BS Computer Science','BS Information Systems','BS Computer Engineering','BS Electronics Engineering','Associate in Computer Technology'];
$year_levels  = ['1st Year','2nd Year','3rd Year','4th Year'];
$statuses     = ['Active','Inactive','Graduated','Dropped'];

include 'nav.php';
?>

<section class="page-hero">
  <div class="container-xl">
    <h1><i class="bi bi-pencil-square me-3"></i>Edit Student Record</h1>
    <p class="subtitle mb-0">Updating: <strong><?= htmlspecialchars($student['first_name'].' '.$student['last_name']) ?></strong></p>
  </div>
</section>

<div class="container-xl py-4">
  <div class="row justify-content-center">
    <div class="col-lg-9">

      <?php foreach ($errors as $e): ?>
      <div class="alert-custom alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> <?= $e ?></div>
      <?php endforeach; ?>

      <div class="main-card">
        <div class="card-header-custom">
          <h5><i class="bi bi-pencil me-2"></i>Update Student Information</h5>
          <a href="students.php" class="btn-edit"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
        <div class="card-body-custom">
          <form method="POST" action="update.php?id=<?= $id ?>">

            <p class="form-section-title"><i class="bi bi-person me-2"></i>Personal Information</p>
            <div class="row g-3 mb-4">
              <div class="col-md-4">
                <label class="form-label">Student ID <span class="required-star">*</span></label>
                <input type="text" name="student_id" class="form-control"
                  value="<?= htmlspecialchars($student['student_id']) ?>" required/>
              </div>
              <div class="col-md-4">
                <label class="form-label">First Name <span class="required-star">*</span></label>
                <input type="text" name="first_name" class="form-control"
                  value="<?= htmlspecialchars($student['first_name']) ?>" required/>
              </div>
              <div class="col-md-4">
                <label class="form-label">Last Name <span class="required-star">*</span></label>
                <input type="text" name="last_name" class="form-control"
                  value="<?= htmlspecialchars($student['last_name']) ?>" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email Address <span class="required-star">*</span></label>
                <input type="email" name="email" class="form-control"
                  value="<?= htmlspecialchars($student['email']) ?>" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-control"
                  value="<?= htmlspecialchars($student['contact_number']) ?>"/>
              </div>
              <div class="col-12">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($student['address']) ?></textarea>
              </div>
            </div>

            <p class="form-section-title"><i class="bi bi-book me-2"></i>Academic Information</p>
            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label">Course / Program <span class="required-star">*</span></label>
                <select name="course" class="form-select" required>
                  <?php foreach ($courses_list as $c): ?>
                  <option value="<?= $c ?>" <?= $student['course']==$c?'selected':'' ?>><?= $c ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Year Level <span class="required-star">*</span></label>
                <select name="year_level" class="form-select" required>
                  <?php foreach ($year_levels as $y): ?>
                  <option value="<?= $y ?>" <?= $student['year_level']==$y?'selected':'' ?>><?= $y ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Section</label>
                <input type="text" name="section" class="form-control"
                  value="<?= htmlspecialchars($student['section']) ?>"/>
              </div>
              <div class="col-md-3">
                <label class="form-label">GWA</label>
                <input type="number" name="gwa" class="form-control" step="0.01" min="0" max="5"
                  value="<?= number_format($student['gwa'],2) ?>"/>
              </div>
              <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                  <?php foreach ($statuses as $st): ?>
                  <option value="<?= $st ?>" <?= $student['status']==$st?'selected':'' ?>><?= $st ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="d-flex gap-2 pt-2">
              <button type="submit" class="btn-primary-custom"><i class="bi bi-check-lg"></i> Save Changes</button>
              <a href="students.php" class="btn-edit" style="padding:9px 18px">Cancel</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<footer>
  &copy; <?= date('Y') ?> <strong>EduTrack SIS</strong> — Student Information System | ITEL 203
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
