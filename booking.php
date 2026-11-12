
<?php
session_start();

require_once "db/config.php";

// Get Car ID
$car_id = 0;

if (isset($_GET['car_id'])) {
    $car_id = (int) $_GET['car_id'];
} elseif (isset($_POST['car_id'])) {
    $car_id = (int) $_POST['car_id'];
}

if ($car_id <= 0) {
    die("Invalid Car ID!");
}


// Check Customer Login
if (!isset($_SESSION['user_id'])) {

    $_SESSION['redirect_after_login'] = "booking.php?car_id=" . $car_id;

    header("Location: login.php");
    exit();
}


// Verify Customer from Database
$user_id = (int) $_SESSION['user_id'];

$user_sql = "SELECT user_id, role_id, status
             FROM users
             WHERE user_id = ?";

$user_stmt = mysqli_prepare($conn, $user_sql);

mysqli_stmt_bind_param($user_stmt, "i", $user_id);

mysqli_stmt_execute($user_stmt);

$user_result = mysqli_stmt_get_result($user_stmt);

$user = mysqli_fetch_assoc($user_result);


// Only active customers can book
if (!$user || (int)$user['role_id'] !== 3 || $user['status'] !== 'active') {
    die("Access Denied! Only active customers can book cars.");
}


// Get Car Details
$car_sql = "SELECT
                cars.car_id,
                cars.model_name,
                cars.year,
                cars.daily_rate,
                cars.status,
                brands.brand_name
            FROM cars
            INNER JOIN brands
                ON cars.brand_id = brands.brand_id
            WHERE cars.car_id = ?";

$car_stmt = mysqli_prepare($conn, $car_sql);

mysqli_stmt_bind_param($car_stmt, "i", $car_id);

mysqli_stmt_execute($car_stmt);

$car_result = mysqli_stmt_get_result($car_stmt);

$car = mysqli_fetch_assoc($car_result);


// Check Car Exists
if (!$car) {
    die("Car Not Found!");
}


// Check Car Availability
if ($car['status'] !== 'available') {
    die("Sorry! This car is currently unavailable.");
}


// Clean Output
function clean($value) {
    return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
}


// Variables
$error = "";
$success = false;
$booking_number = "";

$pickup_date = "";
$return_date = "";
$pickup_location = "";
$return_location = "";
$special_requests = "";

$daily_rate = (float) $car['daily_rate'];


// Booking Form Submit
if (isset($_POST['submit_booking'])) {

    $pickup_date = trim($_POST['pickup_date'] ?? '');
    $return_date = trim($_POST['return_date'] ?? '');

    $pickup_location = trim($_POST['pickup_location'] ?? '');
    $return_location = trim($_POST['return_location'] ?? '');

    $special_requests = trim($_POST['special_requests'] ?? '');


    // Validate Dates
    $pickupDateObject = DateTime::createFromFormat('!Y-m-d', $pickup_date);
    $returnDateObject = DateTime::createFromFormat('!Y-m-d', $return_date);

    $today = new DateTime('today');


    if (
        !$pickupDateObject ||
        $pickupDateObject->format('Y-m-d') !== $pickup_date ||
        !$returnDateObject ||
        $returnDateObject->format('Y-m-d') !== $return_date
    ) {

        $error = "Please select valid pickup and return dates.";

    } elseif ($pickupDateObject < $today) {

        $error = "Pickup date cannot be in the past.";

    } elseif ($returnDateObject <= $pickupDateObject) {

        $error = "Return date must be after pickup date.";

    } elseif (empty($pickup_location) || empty($return_location)) {

        $error = "Please enter pickup and return locations.";

    } elseif (strlen($pickup_location) > 255 || strlen($return_location) > 255) {

        $error = "Location must not exceed 255 characters.";

    } else {

        // Calculate Total Days
        $interval = $pickupDateObject->diff($returnDateObject);

        $total_days = $interval->days;

        // Calculate Total Amount
        $total_amount = $total_days * $daily_rate;


        // Generate Booking Number
        $booking_number = "DG" . date("Ymd") . strtoupper(bin2hex(random_bytes(3)));


        // Insert Booking into Database
        $insert_sql = "INSERT INTO bookings
        (
            booking_number,
            customer_id,
            car_id,
            pickup_date,
            return_date,
            pickup_location,
            return_location,
            total_days,
            total_amount,
            status,
            special_requests
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?)";


        $insert_stmt = mysqli_prepare($conn, $insert_sql);


        if ($insert_stmt) {

            mysqli_stmt_bind_param(
                $insert_stmt,
                "siissssids",
                $booking_number,
                $user_id,
                $car_id,
                $pickup_date,
                $return_date,
                $pickup_location,
                $return_location,
                $total_days,
                $total_amount,
                $special_requests
            );


            if (mysqli_stmt_execute($insert_stmt)) {

                $success = true;

            } else {

                $error = "Booking Failed: " . mysqli_stmt_error($insert_stmt);

            }

            mysqli_stmt_close($insert_stmt);

        } else {

            $error = "Database Error: " . mysqli_error($conn);

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Book Your Car | DriveGo</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body {
            background: #f5f6fa;
            font-family: Arial, sans-serif;
        }

        .navbar-brand {
            font-size: 25px;
            font-weight: bold;
        }

        .booking-card {
            border: none;
            border-radius: 12px;
        }

        .car-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }

        .booking-title {
            font-weight: bold;
        }

        .form-label {
            font-weight: 600;
        }

        .submit-btn {
            padding: 12px;
            font-size: 17px;
            font-weight: bold;
        }

    </style>

</head>

<body>


<!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container">

        <a class="navbar-brand" href="index.php">
            DriveGo
        </a>

        <div class="d-flex align-items-center gap-2">

            <a href="index.php" class="btn btn-outline-light btn-sm">
                Home
            </a>

            <a href="cars.php" class="btn btn-outline-light btn-sm">
                Our Cars
            </a>

            <span class="text-white">
                Welcome, <?php echo clean($_SESSION['user_name'] ?? 'Customer'); ?>
            </span>

            <a href="logout.php" class="btn btn-danger btn-sm">
                Logout
            </a>

        </div>

    </div>

</nav>


<!-- Booking Section -->

<div class="container py-5">

    <div class="mb-4">

        <a href="car_details.php?id=<?php echo (int)$car['car_id']; ?>"
           class="text-decoration-none">

            <i class="bi bi-arrow-left"></i>
            Back to Car Details

        </a>

    </div>


    <div class="row justify-content-center">

        <div class="col-lg-8">


            <div class="card booking-card shadow-sm p-4 p-md-5">


                <h2 class="booking-title mb-2">
                    <i class="bi bi-calendar-check text-primary"></i>
                    Book Your Car
                </h2>

                <p class="text-muted mb-4">
                    Complete the form below to book your vehicle.
                </p>


                <!-- Success Message -->

                <?php if ($success): ?>

                    <div class="alert alert-success">

                        <h4 class="alert-heading">
                            <i class="bi bi-check-circle-fill"></i>
                            Booking Successful!
                        </h4>

                        <hr>

                        <p class="mb-2">
                            Your booking has been submitted successfully.
                        </p>

                        <p class="mb-2">
                            <strong>Booking Number:</strong>
                            <?php echo clean($booking_number); ?>
                        </p>

                        <p class="mb-2">
                            <strong>Car:</strong>
                            <?php echo clean($car['brand_name']); ?>
                            <?php echo clean($car['model_name']); ?>
                        </p>

                        <p class="mb-0">
                            <strong>Total Amount:</strong>
                            ৳ <?php echo number_format($total_amount, 2); ?>
                        </p>

                        <hr>

                        <p class="mb-0">
                            Your booking status is
                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>
                        </p>

                    </div>


                    <a href="cars.php" class="btn btn-primary w-100 mt-3">
                        Explore More Cars
                    </a>


                <?php else: ?>


                    <!-- Error Message -->

                    <?php if (!empty($error)): ?>

                        <div class="alert alert-danger">
                            <?php echo clean($error); ?>
                        </div>

                    <?php endif; ?>


                    <!-- Selected Car Information -->

                    <div class="car-info mb-4">

                        <h5 class="fw-bold mb-3">
                            Selected Car Information
                        </h5>

                        <h4 class="text-primary fw-bold">

                            <?php echo clean($car['brand_name']); ?>

                            <?php echo clean($car['model_name']); ?>

                        </h4>

                        <p class="mb-2">
                            Model Year:
                            <?php echo clean($car['year']); ?>
                        </p>

                        <h5 class="text-success fw-bold mb-0">

                            ৳ <?php echo number_format($daily_rate, 2); ?>

                            <small class="text-muted fs-6">
                                / day
                            </small>

                        </h5>

                    </div>


                    <!-- Booking Form -->

                    <form method="POST"
                          action="booking.php?car_id=<?php echo (int)$car_id; ?>">

                        <input
                            type="hidden"
                            name="car_id"
                            value="<?php echo (int)$car_id; ?>"
                        >


                        <!-- Pickup Date -->

                        <div class="mb-3">

                            <label class="form-label">
                                Pickup Date
                            </label>

                            <input
                                type="date"
                                name="pickup_date"
                                class="form-control"
                                min="<?php echo date('Y-m-d'); ?>"
                                value="<?php echo clean($pickup_date); ?>"
                                required
                            >

                        </div>


                        <!-- Return Date -->

                        <div class="mb-3">

                            <label class="form-label">
                                Return Date
                            </label>

                            <input
                                type="date"
                                name="return_date"
                                class="form-control"
                                min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                                value="<?php echo clean($return_date); ?>"
                                required
                            >

                        </div>


                        <!-- Pickup Location -->

                        <div class="mb-3">

                            <label class="form-label">
                                Pickup Location
                            </label>

                            <input
                                type="text"
                                name="pickup_location"
                                class="form-control"
                                placeholder="Enter pickup location"
                                maxlength="255"
                                value="<?php echo clean($pickup_location); ?>"
                                required
                            >

                        </div>


                        <!-- Return Location -->

                        <div class="mb-3">

                            <label class="form-label">
                                Return Location
                            </label>

                            <input
                                type="text"
                                name="return_location"
                                class="form-control"
                                placeholder="Enter return location"
                                maxlength="255"
                                value="<?php echo clean($return_location); ?>"
                                required
                            >

                        </div>


                        <!-- Special Requests -->

                        <div class="mb-4">

                            <label class="form-label">
                                Special Requests (Optional)
                            </label>

                            <textarea
                                name="special_requests"
                                class="form-control"
                                rows="3"
                                placeholder="Write any special requests..."
                            ><?php echo clean($special_requests); ?></textarea>

                        </div>


                        <!-- Booking Information -->

                        <div class="alert alert-info">

                            <i class="bi bi-info-circle"></i>

                            Booking will be submitted with
                            <strong>Pending</strong> status.
                            Total payment will be calculated using the
                            daily rental rate.

                        </div>


                        <!-- Submit Button -->

                        <button
                            type="submit"
                            name="submit_booking"
                            class="btn btn-primary w-100 submit-btn"
                        >

                            <i class="bi bi-calendar-check"></i>
                            Confirm Booking

                        </button>


                        <a href="cars.php"
                           class="btn btn-outline-secondary w-100 mt-3">

                            Cancel

                        </a>

                    </form>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>


<!-- Footer -->

<footer class="bg-dark text-white text-center py-3">

    <p class="mb-0">

        © <?php echo date("Y"); ?> DriveGo. All Rights Reserved.

    </p>

</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
