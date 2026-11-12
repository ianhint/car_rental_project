
<?php
session_start();

include 'db/config.php';

$error = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check user from database
    $sql = "SELECT * FROM users WHERE email = ? AND role_id = 3";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        // Check account status
        if ($user['status'] !== 'active') {

            $error = "Your account is not active.";

        } 
        // Verify password
        elseif (password_verify($password, $user['password'])) {

            // Store user information in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role_id'];

            // Redirect to homepage
            header("Location: index.php");
            exit();

        } else {

            $error = "Invalid email or password.";

        }

    } else {

        $error = "Invalid email or password.";

    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Login | DriveGo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: white;
            width: 100%;
            max-width: 430px;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .login-title {
            font-weight: bold;
            color: #222;
        }

        .btn-login {
            background: #ffc107;
            border: none;
            font-weight: 600;
            padding: 11px;
        }

        .btn-login:hover {
            background: #e0a800;
        }
    </style>

</head>

<body>

    <div class="login-box">

        <div class="text-center mb-4">
            <h2 class="login-title">DriveGo</h2>
            <p class="text-muted">Customer Login</p>
        </div>

        <?php if (!empty($error)) { ?>

            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php } ?>

        <form method="POST" action="">

            <div class="mb-3">
                <label class="form-label">Email Address</label>

                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Enter your email"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>

                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Enter your password"
                       required>
            </div>

            <div class="d-grid mt-4">
                <button type="submit"
                        name="login"
                        class="btn btn-login">
                    Login
                </button>
            </div>

        </form>

        <div class="text-center mt-4">
            <p class="mb-1">
                Don't have an account?
                <a href="register.php">Sign Up</a>
            </p>

            <a href="index.php" class="text-decoration-none">
                Back to Home
            </a>
        </div>

    </div>

</body>
</html>
