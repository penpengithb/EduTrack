<?php
// create.php — CREATE a new student record
include 'config.php';
$pageTitle = 'Enroll Student';
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect & sanitize
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

    // Validate
    if (!$student_id)  $errors[] = "Student ID is required.";
    if (!$first_name)  $errors[] = "First name is required.";
    if (!$last_name)   $errors[] = "Last name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (!$course)      $errors[] = "Course is required.";
    if (!$year_level)  $errors[] = "Year level is required.";
    if ($gwa < 0 || $gwa > 5) $errors[] = "GWA must be between 0 and 5.";

    // Check duplicate student_id
    $check = $conn->query("SELECT id FROM students WHERE student_id = '$student_id'");
    if ($check->num_rows > 0) $errors[] = "Student ID '$student_id' already exists.";

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO students (student_id, first_name, last_name, email, course, year_level, section, contact_number, address, gwa, status) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssssssds", $student_id, $first_name, $last_name, $email, $course, $year_level, $section, $contact_number, $address, $gwa, $status);
        if ($stmt->execute()) {
            header("Location: students.php?added=1");
            exit();
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}

$courses_list = ['BS Information Technology','BS Computer Science','BS Information Systems','BS Computer Engineering','BS Electronics Engineering','Associate in Computer Technology'];
$year_levels  = ['1st Year','2nd Year','3rd Year','4th Year'];
$statuses     = ['Active','Inactive','Graduated','Dropped'];

include 'nav.php';
?>

<section class="page-hero">
  <div class="container-xl">
    <h1><i class="bi bi-person-plus me-3"></i>Enroll New Student</h1>
    <p class="subtitle mb-0">Fill in the form below to add a student record</p>
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
          <h5><i class="bi bi-clipboard-plus me-2"></i>Student Enrollment Form</h5>
          <a href="students.php" class="btn-edit"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
        <div class="card-body-custom">
          <form method="POST" action="create.php">

            <p class="form-section-title"><i class="bi bi-person me-2"></i>Personal Information</p>
            <div class="row g-3 mb-4">
              <div class="col-md-4">
                <label class="form-label">Student ID <span class="required-star">*</span></label>
                <input type="text" name="student_id" class="form-control" placeholder="e.g. 2024-0001"
                  value="<?= htmlspecialchars($_POST['student_id'] ?? '') ?>" required/>
              </div>
              <div class="col-md-4">
                <label class="form-label">First Name <span class="required-star">*</span></label>
                <input type="text" name="first_name" class="form-control" placeholder="First name"
                  value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" required/>
              </div>
              <div class="col-md-4">
                <label class="form-label">Last Name <span class="required-star">*</span></label>
                <input type="text" name="last_name" class="form-control" placeholder="Last name"
                  value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email Address <span class="required-star">*</span></label>
                <input type="email" name="email" class="form-control" placeholder="student@school.edu"
                  value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-control" placeholder="09XXXXXXXXX"
                  value="<?= htmlspecialchars($_POST['contact_number'] ?? '') ?>"/>
              </div>
              <div class="col-12">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Home address"><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
              </div>
            </div>

            <p class="form-section-title"><i class="bi bi-book me-2"></i>Academic Information</p>
            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label">Course / Program <span class="required-star">*</span></label>
                <select name="course" class="form-select" required>
                  <option value="">— Select Course —</option>
                  <?php foreach ($courses_list as $c): ?>
                  <option value="<?= $c ?>" <?= (($_POST['course'] ?? '') == $c) ? 'selected' : '' ?>><?= $c ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Year Level <span class="required-star">*</span></label>
                <select name="year_level" class="form-select" required>
                  <option value="">— Year —</option>
                  <?php foreach ($year_levels as $y): ?>
                  <option value="<?= $y ?>" <?= (($_POST['year_level'] ?? '') == $y) ? 'selected' : '' ?>><?= $y ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Section</label>
                <input type="text" name="section" class="form-control" placeholder="e.g. A"
                  value="<?= htmlspecialchars($_POST['section'] ?? '') ?>"/>
              </div>
              <div class="col-md-3">
                <label class="form-label">GWA</label>
                <input type="number" name="gwa" class="form-control" step="0.01" min="0" max="5" placeholder="0.00"
                  value="<?= htmlspecialchars($_POST['gwa'] ?? '0.00') ?>"/>
              </div>
              <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                  <?php foreach ($statuses as $st): ?>
                  <option value="<?= $st ?>" <?= (($_POST['status'] ?? 'Active') == $st) ? 'selected' : '' ?>><?= $st ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="d-flex gap-2 pt-2">
              <button type="submit" class="btn-accent"><i class="bi bi-check-lg"></i> Enroll Student</button>
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
