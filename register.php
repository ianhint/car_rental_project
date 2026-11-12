
<?php
include 'db/config.php';

$error = "";
$success = "";

if (isset($_POST['register'])) {

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check password
    if ($password !== $confirm_password) {

        $error = "Password and Confirm Password do not match.";

    } elseif (strlen($password) < 6) {

        $error = "Password must be at least 6 characters.";

    } else {

        // Check email already exists
        $check_sql = "SELECT user_id FROM users WHERE email = ?";
        $check_stmt = mysqli_prepare($conn, $check_sql);

        mysqli_stmt_bind_param($check_stmt, "s", $email);
        mysqli_stmt_execute($check_stmt);

        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {

            $error = "This email is already registered.";

        } else {

            // Hash password
            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Insert new customer
            $sql = "INSERT INTO users
                    (role_id, full_name, email, phone, password, address, status)
                    VALUES (3, ?, ?, ?, ?, ?, 'active')";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "sssss",
                $full_name,
                $email,
                $phone,
                $hashed_password,
                $address
            );

            if (mysqli_stmt_execute($stmt)) {

                $success = "Registration successful! You can now login.";

            } else {

                $error = "Registration failed. Please try again.";

            }

            mysqli_stmt_close($stmt);
        }

        mysqli_stmt_close($check_stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Registration | DriveGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }

        .register-box {
            background: white;
            width: 100%;
            max-width: 500px;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .register-title {
            font-weight: bold;
        }

        .btn-register {
            background: #ffc107;
            border: none;
            font-weight: 600;
            padding: 11px;
        }

        .btn-register:hover {
            background: #e0a800;
        }
    </style>

</head>

<body>

    <div class="register-box">

        <div class="text-center mb-4">
            <h2 class="register-title">DriveGo</h2>
            <p class="text-muted">Create Your Customer Account</p>
        </div>

        <?php if (!empty($error)) { ?>

            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php } ?>

        <?php if (!empty($success)) { ?>

            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>

                <a href="login.php">Login Now</a>
            </div>

        <?php } ?>

        <form method="POST" action="">

            <div class="mb-3">
                <label class="form-label">Full Name</label>

                <input type="text"
                       name="full_name"
                       class="form-control"
                       placeholder="Enter your full name"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>

                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Enter your email"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>

                <input type="text"
                       name="phone"
                       class="form-control"
                       placeholder="Enter your phone number"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>

                <textarea name="address"
                          class="form-control"
                          rows="2"
                          placeholder="Enter your address"
                          required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>

                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Enter password"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>

                <input type="password"
                       name="confirm_password"
                       class="form-control"
                       placeholder="Confirm password"
                       required>
            </div>

            <div class="d-grid mt-4">
                <button type="submit"
                        name="register"
                        class="btn btn-register">
                    Create Account
                </button>
            </div>

        </form>

        <div class="text-center mt-4">

            <p>
                Already have an account?
                <a href="login.php">Login</a>
            </p>

            <a href="index.php" class="text-decoration-none">
                Back to Home
            </a>

        </div>

    </div>

</body>
</html>
