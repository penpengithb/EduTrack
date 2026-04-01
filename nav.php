<?php
// nav.php — Shared navigation included on every page
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($pageTitle) ? $pageTitle . ' | ' : '' ?>EduTrack SIS</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="assets/styles.css" rel="stylesheet"/>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top" id="mainNav">
  <div class="container-xl">
    <a class="navbar-brand" href="index.php">
      <span class="brand-icon"><i class="bi bi-mortarboard-fill"></i></span>
      <span class="brand-text">Edu<span class="accent">Track</span></span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto gap-1">
        <li class="nav-item">
          <a class="nav-link <?= $current=='index.php'?'active':'' ?>" href="index.php">
            <i class="bi bi-house-door"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current=='students.php'?'active':'' ?>" href="students.php">
            <i class="bi bi-people"></i> Students
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current=='create.php'?'active':'' ?>" href="create.php">
            <i class="bi bi-person-plus"></i> Add Student
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current=='about-project.php'?'active':'' ?>" href="about-project.php">
            <i class="bi bi-info-circle"></i> About
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
