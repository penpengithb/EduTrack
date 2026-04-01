<?php
$pageTitle = 'About the Project';
include 'nav.php';
?>

<section class="page-hero">
  <div class="container-xl">
    <h1><i class="bi bi-info-circle me-3"></i>About the Project</h1>
    <p class="subtitle mb-0">Learn about EduTrack and what it was built to accomplish</p>
  </div>
</section>

<div class="container-xl py-5">

  <!-- Project Overview -->
  <div class="row g-4 mb-5 align-items-center">
    <div class="col-lg-6">
      <div style="background:var(--navy);border-radius:var(--radius);padding:40px;color:#fff;">
        <div style="background:var(--accent);display:inline-flex;align-items:center;justify-content:center;width:54px;height:54px;border-radius:12px;font-size:1.6rem;color:var(--navy);margin-bottom:20px;">
          <i class="bi bi-mortarboard-fill"></i>
        </div>
        <h2 style="font-family:'Syne',sans-serif;font-weight:800;font-size:2rem;color:#fff;margin-bottom:8px;">EduTrack SIS</h2>
        <p style="color:rgba(255,255,255,.7);font-size:1rem;line-height:1.7;">
          EduTrack is a <strong style="color:var(--accent)">Student Information System</strong> built with PHP and MySQL. It allows schools and administrators to manage student enrollment records efficiently through a clean, modern web interface.
        </p>
        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:20px;">
          <span style="background:rgba(245,166,35,.2);color:var(--accent);border-radius:20px;padding:5px 14px;font-size:.82rem;font-weight:600;">PHP</span>
          <span style="background:rgba(245,166,35,.2);color:var(--accent);border-radius:20px;padding:5px 14px;font-size:.82rem;font-weight:600;">MySQL</span>
          <span style="background:rgba(245,166,35,.2);color:var(--accent);border-radius:20px;padding:5px 14px;font-size:.82rem;font-weight:600;">Bootstrap 5</span>
          <span style="background:rgba(245,166,35,.2);color:var(--accent);border-radius:20px;padding:5px 14px;font-size:.82rem;font-weight:600;">XAMPP</span>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <h3 style="font-family:'Syne',sans-serif;font-weight:800;color:var(--navy);margin-bottom:16px;">Purpose of the System</h3>
      <p style="color:var(--muted);line-height:1.8;">
        Managing student records manually is time-consuming and error-prone. EduTrack digitizes this process — from enrollment to graduation — providing a centralized, searchable, and easy-to-use platform for school administrators.
      </p>
      <ul style="list-style:none;padding:0;margin-top:16px;">
        <li style="padding:8px 0;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;">
          <i class="bi bi-check-circle-fill" style="color:var(--teal)"></i>
          Centralize all student academic records in one place
        </li>
        <li style="padding:8px 0;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;">
          <i class="bi bi-check-circle-fill" style="color:var(--teal)"></i>
          Reduce manual paperwork and data redundancy
        </li>
        <li style="padding:8px 0;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;">
          <i class="bi bi-check-circle-fill" style="color:var(--teal)"></i>
          Enable quick search and filtering of student data
        </li>
        <li style="padding:8px 0;display:flex;align-items:center;gap:10px;">
          <i class="bi bi-check-circle-fill" style="color:var(--teal)"></i>
          Provide real-time enrollment statistics via dashboard
        </li>
      </ul>
    </div>
  </div>

  <!-- Features -->
  <h3 style="font-family:'Syne',sans-serif;font-weight:800;text-align:center;margin-bottom:30px;color:var(--navy)">
    System Features
  </h3>
  <div class="row g-3 mb-5">
    <?php
    $features = [
      ['bi-plus-circle','Create Records','Enroll new students with full academic and personal details through a validated form.','#1e4fd8'],
      ['bi-table','Read / View','Browse all student records in a clean, sortable table on the Students page and Dashboard.','#0abfa3'],
      ['bi-pencil','Update Records','Edit any student\'s information at any time using the Edit button on the records table.','#f5a623'],
      ['bi-trash3','Delete Records','Remove student records with a confirmation prompt to prevent accidental deletions.','#e74c3c'],
      ['bi-search','Search & Filter','Search by name, ID, or email. Filter by course and enrollment status.','#8b5cf6'],
      ['bi-bar-chart','Dashboard','View enrollment statistics, course distribution charts, and recently added students.','#0891b2'],
    ];
    foreach ($features as $f): ?>
    <div class="col-md-4">
      <div class="feature-card" style="border-top-color:<?= $f[3] ?>">
        <div class="feature-icon" style="background:<?= $f[3] ?>20;color:<?= $f[3] ?>">
          <i class="bi <?= $f[0] ?>"></i>
        </div>
        <h6 style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:6px;"><?= $f[1] ?></h6>
        <p style="color:var(--muted);font-size:.88rem;margin:0;"><?= $f[2] ?></p>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Tech stack -->
  <div class="main-card">
    <div class="card-header-custom">
      <h5><i class="bi bi-tools me-2"></i>Technologies Used</h5>
    </div>
    <div class="card-body-custom">
      <div class="row g-3">
        <?php
        $tech = [
          ['bi-filetype-php','PHP 8','Server-side scripting language used for all backend logic, form handling, and database interaction.'],
          ['bi-database','MySQL','Relational database system used to store all student records, managed via phpMyAdmin.'],
          ['bi-bootstrap','Bootstrap 5','CSS framework used to build a responsive, mobile-friendly user interface.'],
          ['bi-code-slash','HTML & CSS','Markup and styling used for page structure and custom visual elements.'],
          ['bi-server','XAMPP','Local development server environment providing Apache, MySQL, and PHP.'],
          ['bi-github','GitHub','Version control platform used for source code management and collaboration.'],
        ];
        foreach ($tech as $t): ?>
        <div class="col-md-4">
          <div style="display:flex;align-items:flex-start;gap:12px;padding:14px;background:var(--light);border-radius:10px;">
            <div style="font-size:1.5rem;color:var(--blue);padding-top:2px;"><i class="bi <?= $t[0] ?>"></i></div>
            <div>
              <div style="font-weight:700;font-size:.9rem;"><?= $t[1] ?></div>
              <div style="color:var(--muted);font-size:.82rem;margin-top:2px;"><?= $t[2] ?></div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
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
