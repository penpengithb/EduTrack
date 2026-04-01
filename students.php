<?php
// students.php — Read (list all students) with SEARCH (Bonus feature)
include 'config.php';
$pageTitle = 'Students';

$search  = isset($_GET['q']) ? clean($conn, $_GET['q']) : '';
$filter  = isset($_GET['status']) ? clean($conn, $_GET['status']) : '';
$course_f = isset($_GET['course']) ? clean($conn, $_GET['course']) : '';

$where = [];
if ($search)   $where[] = "(first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR student_id LIKE '%$search%' OR email LIKE '%$search%')";
if ($filter)   $where[] = "status = '$filter'";
if ($course_f) $where[] = "course = '$course_f'";

$sql = "SELECT * FROM students" . ($where ? ' WHERE '.implode(' AND ',$where) : '') . " ORDER BY enrolled_at DESC";
$result = $conn->query($sql);

$courses = $conn->query("SELECT DISTINCT course FROM students ORDER BY course");
$total   = $result->num_rows;

include 'nav.php';
?>

<section class="page-hero">
  <div class="container-xl">
    <h1><i class="bi bi-people me-3"></i>Student Records</h1>
    <p class="subtitle mb-0">View, search, edit, and manage all enrolled students</p>
  </div>
</section>

<div class="container-xl py-4">

  <?php if (isset($_GET['deleted'])): ?>
  <div class="alert-custom alert-danger"><i class="bi bi-trash3-fill"></i> Student record deleted successfully.</div>
  <?php endif; ?>
  <?php if (isset($_GET['added'])): ?>
  <div class="alert-custom alert-success"><i class="bi bi-check-circle-fill"></i> New student enrolled successfully!</div>
  <?php endif; ?>
  <?php if (isset($_GET['updated'])): ?>
  <div class="alert-custom alert-info"><i class="bi bi-pencil-fill"></i> Student record updated successfully.</div>
  <?php endif; ?>

  <div class="main-card">
    <div class="card-header-custom">
      <h5><i class="bi bi-table me-2"></i>All Students
        <span style="background:rgba(255,255,255,.15);border-radius:20px;padding:2px 10px;font-size:.8rem;margin-left:8px;"><?= $total ?></span>
      </h5>
      <a href="create.php" class="btn-accent">
        <i class="bi bi-person-plus"></i> Enroll Student
      </a>
    </div>

    <!-- Search & Filter Bar (BONUS: Search Feature) -->
    <div class="card-body-custom" style="padding-bottom:0;border-bottom:1px solid var(--border)">
      <form method="GET" action="students.php" class="d-flex flex-wrap gap-2 align-items-end pb-3">
        <div class="search-wrap">
          <i class="bi bi-search search-icon"></i>
          <input type="text" name="q" placeholder="Search name, ID, email…" value="<?= htmlspecialchars($search) ?>"/>
        </div>

        <select name="status" class="form-select" style="width:auto;border-radius:9px;padding:9px 14px;font-size:.9rem;">
          <option value="">All Status</option>
          <option value="Active"    <?= $filter=='Active'?'selected':'' ?>>Active</option>
          <option value="Inactive"  <?= $filter=='Inactive'?'selected':'' ?>>Inactive</option>
          <option value="Graduated" <?= $filter=='Graduated'?'selected':'' ?>>Graduated</option>
          <option value="Dropped"   <?= $filter=='Dropped'?'selected':'' ?>>Dropped</option>
        </select>

        <select name="course" class="form-select" style="width:auto;border-radius:9px;padding:9px 14px;font-size:.9rem;">
          <option value="">All Courses</option>
          <?php while ($c = $courses->fetch_assoc()): ?>
          <option value="<?= htmlspecialchars($c['course']) ?>" <?= $course_f==$c['course']?'selected':'' ?>>
            <?= htmlspecialchars($c['course']) ?>
          </option>
          <?php endwhile; ?>
        </select>

        <button type="submit" class="btn-primary-custom"><i class="bi bi-funnel"></i> Filter</button>
        <?php if ($search || $filter || $course_f): ?>
        <a href="students.php" class="btn-edit"><i class="bi bi-x"></i> Clear</a>
        <?php endif; ?>
      </form>
    </div>

    <!-- Table -->
    <div class="table-responsive">
      <table class="table-custom">
        <thead>
          <tr>
            <th>#</th>
            <th>Student ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Year</th>
            <th>GWA</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0):
            $i = 1;
            while ($s = $result->fetch_assoc()): ?>
          <tr>
            <td style="color:var(--muted);font-size:.85rem"><?= $i++ ?></td>
            <td><code style="font-size:.83rem;color:var(--blue)"><?= htmlspecialchars($s['student_id']) ?></code></td>
            <td>
              <strong><?= htmlspecialchars($s['first_name'].' '.$s['last_name']) ?></strong>
              <?php if ($s['section']): ?>
              <br><small style="color:var(--muted)">Sec. <?= htmlspecialchars($s['section']) ?></small>
              <?php endif; ?>
            </td>
            <td style="font-size:.88rem"><?= htmlspecialchars($s['email']) ?></td>
            <td style="font-size:.88rem"><?= htmlspecialchars($s['course']) ?></td>
            <td><span class="badge-year"><?= $s['year_level'] ?></span></td>
            <td>
              <?php
                $g = $s['gwa'];
                $gc = $g <= 1.5 ? 'gwa-1' : ($g <= 2.0 ? 'gwa-2' : ($g <= 3.0 ? 'gwa-3' : 'gwa-4'));
              ?>
              <span class="gwa-badge <?= $gc ?>"><?= number_format($g,2) ?></span>
            </td>
            <td>
              <span class="badge-status <?= strtolower($s['status']) ?>"><?= $s['status'] ?></span>
            </td>
            <td>
              <div class="d-flex gap-1">
                <a href="update.php?id=<?= $s['id'] ?>" class="btn-edit">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="delete.php?id=<?= $s['id'] ?>"
                   class="btn-delete"
                   onclick="return confirm('Delete <?= htmlspecialchars($s['first_name']) ?>\'s record? This cannot be undone.')">
                  <i class="bi bi-trash3"></i> Delete
                </a>
              </div>
            </td>
          </tr>
          <?php endwhile; else: ?>
          <tr>
            <td colspan="9">
              <div class="empty-state">
                <i class="bi bi-person-x"></i>
                <h5>No students found</h5>
                <p><?= $search ? "No results for \"$search\"." : "No students enrolled yet." ?></p>
                <a href="create.php" class="btn-primary-custom">
                  <i class="bi bi-person-plus"></i> Enroll First Student
                </a>
              </div>
            </td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<footer>
  &copy; <?= date('Y') ?> <strong>EduTrack SIS</strong> — Student Information System | ITEL 203
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
