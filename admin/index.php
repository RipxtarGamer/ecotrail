<?php
if (session_status() === PHP_SESSION_NNE) {
    session_start();
}
require_once "../classes/connect.php";
$isAdmin = false;
if (isset($_SESSION['email'])) {
    $DB = new Database();
    $user = $DB->read("SELECT admin from users where email='$_SESSION[email]' limit 1");
    if (is_array($user)) {
        $user = $user[0]['admin'];
        if ($user == 1)
            $isAdmin = true;
    }
}
if (!$isAdmin) {
    echo "Access Denied!";
    die;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel</title>
    <style>
        :root {
            --primary: rgb(37, 99, 235);
            --light-bg: #f4f4f4;
            --dark-text: #333;
            --white: #fff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: var(--light-bg);
            color: var(--dark-text);
            display: flex;
            min-height: 100vh;
        }


        /* Main Content */
        .main {
            flex: 1;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--white);
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .topbar h1 {
            font-size: 1.5rem;
        }

        .toggle-btn {
            display: none;
            font-size: 24px;
            cursor: pointer;
        }

        /* Dashboard Cards */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: var(--white);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .card h3 {
            margin-bottom: 10px;
            color: var(--primary);
        }
    </style>
</head>

<body>


    <!-- Main Content -->
    <div class="main" id="main">
        <div class="topbar">
            <span class="toggle-btn" onclick="toggleSidebar()">☰</span>
            <h1>Dashboard</h1>
        </div>

        <div class="cards">
            <div class="card">
                <a href="new_place.php">
                    <h3>Add new place</h3>
                </a>
            </div>
            <div class="card">
                <a href="new_route.php">
                    <h3>Add new Plans</h3>
                </a>
            </div>
            <div class="card">
                <a href="../sponsors/">
                    <h3>Add new sponsor</h3>
                </a>
            </div>
            <div class="card">
                <a href="new_proute.php">
                    <h3>Submit Popular plans</h3>
                </a>
            </div>
            <div class="card">
                <a href="../contribute/admin.php">
                    <h3>Contributions Review</h3>
                </a>
            </div>
        </div>
    </div>

</body>

</html>
