<?php
session_start();

$error = "";

if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Temporary demo login
    if ($username === "admin" && $password === "admin123") {

        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_name'] = "Administrator";

        header("Location: dashboard.php");
        exit();

    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | DriveGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #172033;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }

        .login-box {
            background: white;
            padding: 35px;
            width: 100%;
            max-width: 400px;
            border-radius: 12px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
        }
    </style>

</head>

<body>

    <div class="login-box">

        <h2>DriveGo Admin</h2>

        <p class="text-center text-muted">Login to your account</p>

        <?php if ($error != "") { ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Username</label>

                <input type="text"
                       name="username"
                       class="form-control"
                       placeholder="Enter username"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>

                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Enter password"
                       required>
            </div>

            <button type="submit"
                    name="login"
                    class="btn btn-primary w-100">
                Login
            </button>

        </form>

        <p class="text-center mt-3">
            <a href="../index.php">Back to Website</a>
        </p>

    </div>

</body>
</html>