<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "classes/connect.php";
$logged = false;
$isAdmin = false;
if (isset($_SESSION['email'])) {
  $logged = true;
    $DB = new Database();
    $user = $DB->read("SELECT admin from users where email='$_SESSION[email]' limit 1");
    if (is_array($user)) {
        $user = $user[0]['admin'];
        if ($user == 1)
            $isAdmin = true;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>EcoTrail+ Navbar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #2c3e50;
    }
    .navbar {
      background-color: #fff;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .navbar-brand {
      font-weight: bold;
      font-size: 1.8rem;
      color: #27ae60 !important;
    }
    .nav-link {
      font-weight: 500;
      color: #2c3e50 !important;
      margin-right: 1rem;
      transition: color 0.3s ease;
    }
    .nav-link:hover {
      color: #27ae60 !important;
    }
    .btn-nav {
      background-color: #27ae60;
      color: white;
      border-radius: 25px;
      padding: 6px 20px;
      font-weight: 500;
      border: none;
      transition: background-color 0.3s ease;
      text-decoration: none;
    }
    .btn-nav:hover {
      background-color: #219150;
      color: white;
      text-decoration: none;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand" href="/ecotrail/index.php">
      <img src="/ecotrail/ecotrail.png" alt="EcoTrail+" style="height:60px;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navMenu">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a class="nav-link" href="/ecotrail/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/ecotrail/contribute/alert.php">Alerts</a></li>
        <li class="nav-item"><a class="nav-link" href="/ecotrail/community">Forum</a></li>
        <li class="nav-item"><a class="nav-link" href="/ecotrail/planner.php">Trip Planner</a></li>
        <?php if ($isAdmin): ?>
          <li class="nav-item"><a class="nav-link" href="/ecotrail/admin">Admin</a></li>
          <?php endif;?>
        <?php if ($logged): ?>
          <li class="nav-item">
            <a class="nav-link" href="/ecotrail/auth/logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item ms-2">
            <a class="btn btn-nav" href="/ecotrail/auth/login.php">Login</a>
          </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>
</body>
</html>
