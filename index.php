<?php
// index.php — Dashboard (Read / Overview)
include 'config.php';
$pageTitle = 'Dashboard';

// Stats
$total     = $conn->query("SELECT COUNT(*) AS c FROM students")->fetch_assoc()['c'];
$active    = $conn->query("SELECT COUNT(*) AS c FROM students WHERE status='Active'")->fetch_assoc()['c'];
$graduated = $conn->query("SELECT COUNT(*) AS c FROM students WHERE status='Graduated'")->fetch_assoc()['c'];
$dropped   = $conn->query("SELECT COUNT(*) AS c FROM students WHERE status='Dropped'")->fetch_assoc()['c'];

// Course distribution
$courses = $conn->query("SELECT course, COUNT(*) AS cnt FROM students GROUP BY course ORDER BY cnt DESC");

// Recent 5 students
$recent = $conn->query("SELECT * FROM students ORDER BY enrolled_at DESC LIMIT 5");

include 'nav.php';
?>

<section class="page-hero">
  <div class="container-xl">
    <div class="d-flex align-items-center gap-4">
      <div class="hero-icon"><i class="bi bi-mortarboard"></i></div>
      <div>
        <h1>EduTrack Dashboard</h1>
        <p class="subtitle mb-0">Student Information System — Overview & Analytics</p>
      </div>
    </div>
  </div>
</section>

<div class="container-xl py-4">

  <!-- Stat cards -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="stat-card blue">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="stat-number"><?= $total ?></div>
            <div class="stat-label">Total Students</div>
          </div>
          <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card teal">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="stat-number"><?= $active ?></div>
            <div class="stat-label">Active</div>
          </div>
          <div class="stat-icon"><i class="bi bi-person-check-fill"></i></div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card accent">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="stat-number"><?= $graduated ?></div>
            <div class="stat-label">Graduated</div>
          </div>
          <div class="stat-icon"><i class="bi bi-award-fill"></i></div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card red">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="stat-number"><?= $dropped ?></div>
            <div class="stat-label">Dropped</div>
          </div>
          <div class="stat-icon"><i class="bi bi-person-dash-fill"></i></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <!-- Recent Students -->
    <div class="col-lg-8">
      <div class="main-card">
        <div class="card-header-custom">
          <h5><i class="bi bi-clock-history me-2"></i>Recently Enrolled</h5>
          <a href="students.php" class="btn-accent" style="padding:6px 16px;font-size:.85rem;">
            View All <i class="bi bi-arrow-right"></i>
          </a>
        </div>
        <div class="table-responsive">
          <table class="table-custom">
            <thead>
              <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>Year</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($recent->num_rows > 0): ?>
                <?php while ($s = $recent->fetch_assoc()): ?>
                <tr>
                  <td><code style="font-size:.83rem;color:var(--blue)"><?= htmlspecialchars($s['student_id']) ?></code></td>
                  <td><strong><?= htmlspecialchars($s['first_name'].' '.$s['last_name']) ?></strong></td>
                  <td style="font-size:.88rem"><?= htmlspecialchars($s['course']) ?></td>
                  <td><span class="badge-year"><?= $s['year_level'] ?></span></td>
                  <td>
                    <span class="badge-status <?= strtolower($s['status']) ?>">
                      <?= $s['status'] ?>
                    </span>
                  </td>
                </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr><td colspan="5" class="text-center py-4 text-muted">No students yet.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Course Distribution -->
    <div class="col-lg-4">
      <div class="main-card h-100">
        <div class="card-header-custom">
          <h5><i class="bi bi-bar-chart-fill me-2"></i>By Course</h5>
        </div>
        <div class="card-body-custom">
          <?php $courses->data_seek(0); while ($c = $courses->fetch_assoc()): ?>
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
              <small style="font-weight:500;font-size:.82rem"><?= htmlspecialchars($c['course']) ?></small>
              <small style="font-weight:700;color:var(--blue)"><?= $c['cnt'] ?></small>
            </div>
            <?php $pct = $total > 0 ? round($c['cnt']/$total*100) : 0; ?>
            <div style="background:var(--border);border-radius:6px;height:7px;">
              <div style="width:<?= $pct ?>%;background:var(--blue);border-radius:6px;height:7px;transition:width .6s"></div>
            </div>
          </div>
          <?php endwhile; ?>
          <?php if ($total == 0): ?>
            <p class="text-muted text-center py-3">No data yet.</p>
          <?php endif; ?>

          <div class="mt-4 pt-3" style="border-top:1px solid var(--border);">
            <a href="create.php" class="btn-primary-custom w-100 justify-content-center">
              <i class="bi bi-person-plus"></i> Enroll New Student
            </a>
          </div>
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
