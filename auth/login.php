<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../classes/connect.php");
if (isset($_SESSION["email"])) {
    header("Location: ../index.php");
    die;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login & Register</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      margin: 0;
      background: linear-gradient(135deg, #6a11cb, #2575fc);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .card {
      background: #fff;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 400px;
    }

    .toggle-btns {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }

    .toggle-btns button {
      background: none;
      border: none;
      font-size: 16px;
      font-weight: 600;
      padding: 10px 20px;
      cursor: pointer;
      color: #555;
      border-bottom: 3px solid transparent;
      transition: all 0.3s;
    }

    .toggle-btns button.active {
      border-color: #2575fc;
      color: #2575fc;
    }

    form {
      display: none;
      flex-direction: column;
    }

    form.active {
      display: flex;
    }

    .input-group {
      position: relative;
      margin-bottom: 20px;
    }

    .input-group input {
      width: 100%;
      padding: 12px 45px 12px 15px;
      border-radius: 10px;
      border: 1px solid #ccc;
      outline: none;
    }

    .input-group i {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #aaa;
    }

    .btn {
      padding: 12px;
      background: #2575fc;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn:hover {
      background: #1a5ee8;
    }

    .links {
      text-align: center;
      margin-top: 15px;
    }

    .links button {
      background: none;
      border: none;
      color: #2575fc;
      font-weight: bold;
      cursor: pointer;
    }

    .recover {
      text-align: right;
      font-size: 14px;
      margin: -10px 0 15px;
    }

    .recover a {
      color: #2575fc;
      text-decoration: none;
    }
  </style>
</head>
<body>

  <div class="card">
    <div class="toggle-btns">
      <button id="loginToggle" class="active" onclick="toggleForm('login')">Sign In</button>
      <button id="signupToggle" onclick="toggleForm('signup')">Sign Up</button>
    </div>

    <!-- Login Form -->
    <form id="loginForm" class="active" method="POST" action="auth.php">
      <div class="input-group">
        <input type="email" name="email" placeholder="Enter your email" required>
        <i class="fas fa-envelope"></i>
      </div>
      <div class="input-group">
        <input type="password" name="password" placeholder="Enter your password" required>
        <i class="fas fa-lock"></i>
      </div>
      <input type="submit" class="btn" name="signIn" value="Sign In">
    </form>

    <!-- Signup Form -->
    <form id="signupForm" method="POST" action="auth.php">
      <div class="input-group">
        <input type="text" name="fname" placeholder="Enter your First Name" required>
        <i class="fas fa-user"></i>
      </div>
      <div class="input-group">
        <input type="text" name="lname" placeholder="Enter your Last Name" required>
        <i class="fas fa-user"></i>
      </div>
      <div class="input-group">
        <input type="email" name="email" placeholder="Enter your email" required>
        <i class="fas fa-envelope"></i>
      </div>
      <div class="input-group">
        <input type="password" name="password" placeholder="Enter your password" required>
        <i class="fas fa-lock"></i>
      </div>
      <input type="submit" class="btn" name="signUp" value="Sign Up">
    </form>

  </div>

  <script>
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    const loginBtn = document.getElementById('loginToggle');
    const signupBtn = document.getElementById('signupToggle');
    const toggleText = document.getElementById('toggleText');
    let showingLogin = true;

    function toggleForm(form) {
      if (form === 'login') {
        loginForm.classList.add('active');
        signupForm.classList.remove('active');
        loginBtn.classList.add('active');
        signupBtn.classList.remove('active');
        showingLogin = true;
      } else {
        signupForm.classList.add('active');
        loginForm.classList.remove('active');
        signupBtn.classList.add('active');
        loginBtn.classList.remove('active');
        showingLogin = false;
      }
    }

    function switchForms() {
      toggleForm(showingLogin ? 'signup' : 'login');
    }
  </script>
</body>
</html>