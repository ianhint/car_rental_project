
<?php
session_start();

require_once "db/config.php";

// Get car ID from URL
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT) || (int)$_GET['id'] <= 0) {
    die("Invalid Car ID!");
}

$car_id = (int) $_GET['id'];

// Get car details from database
$sql = "SELECT
            cars.car_id,
            cars.model_name,
            cars.year,
            cars.seating_capacity,
            cars.fuel_type,
            cars.transmission,
            cars.daily_rate,
            cars.status,
            brands.brand_name,
            categories.category_name
        FROM cars
        INNER JOIN brands
            ON cars.brand_id = brands.brand_id
        INNER JOIN categories
            ON cars.category_id = categories.category_id
        WHERE cars.car_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $car_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$car = mysqli_fetch_assoc($result);

// Check car exists
if (!$car) {
    die("Car Not Found!");
}

// Escape output
function clean($value) {
    return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
}

// Direct image URLs
$carImages = [
    1 => "https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1200&q=85",
    2 => "https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&w=1200&q=85",
    3 => "https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=1200&q=85"
];

$carImage = $carImages[$car_id] ?? $carImages[1];

// Booking URL
$bookingUrl = "booking.php?car_id=" . (int)$car['car_id'];

// If customer is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    $bookingUrl = "login.php?redirect=" . urlencode($bookingUrl);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo clean($car['brand_name']); ?>
        <?php echo clean($car['model_name']); ?> | DriveGo
    </title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #f5f6fa;
            font-family: Arial, sans-serif;
        }

        .navbar-brand {
            font-size: 25px;
            font-weight: bold;
        }

        .details-image {
            width: 100%;
            height: 420px;
            object-fit: cover;
            border-radius: 12px;
        }

        .details-card {
            border: none;
            border-radius: 12px;
        }

        .car-price {
            color: #198754;
            font-size: 28px;
            font-weight: bold;
        }

        .feature-box {
            background: #f8f9fa;
            padding: 18px;
            border-radius: 10px;
            height: 100%;
        }

        .feature-box i {
            font-size: 25px;
            color: #0d6efd;
        }

        .book-btn {
            padding: 12px;
            font-size: 17px;
            font-weight: bold;
        }

        @media(max-width: 768px) {
            .details-image {
                height: 250px;
            }
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

            <?php if (isset($_SESSION['user_id'])): ?>

                <span class="text-white">
                    Welcome, <?php echo clean($_SESSION['user_name']); ?>
                </span>

                <a href="logout.php" class="btn btn-danger btn-sm">
                    Logout
                </a>

            <?php else: ?>

                <a href="login.php" class="btn btn-warning btn-sm">
                    Login
                </a>

            <?php endif; ?>

        </div>
    </div>
</nav>

<!-- Car Details Section -->
<div class="container py-5">

    <div class="mb-4">
        <a href="cars.php" class="text-decoration-none">
            <i class="bi bi-arrow-left"></i>
            Back to Cars
        </a>
    </div>

    <div class="row g-4">

        <!-- Left Side: Car Image -->
        <div class="col-lg-7">

            <div class="card details-card shadow-sm p-3">

                <img
                    src="<?php echo clean($carImage); ?>"
                    class="details-image"
                    alt="<?php echo clean($car['model_name']); ?>"
                >

            </div>

            <!-- Car Description -->
            <div class="card details-card shadow-sm mt-4 p-4">

                <h3 class="fw-bold mb-3">
                    Car Information
                </h3>

                <p class="text-muted">
                    Explore the details of this vehicle before making
                    your booking with DriveGo.
                </p>

                <hr>

                <h5 class="fw-bold">Vehicle Name</h5>

                <p>
                    <?php echo clean($car['brand_name']); ?>
                    <?php echo clean($car['model_name']); ?>
                </p>

                <h5 class="fw-bold">Category</h5>

                <p>
                    <?php echo clean($car['category_name']); ?>
                </p>

            </div>
        </div>

        <!-- Right Side: Car Details -->
        <div class="col-lg-5">

            <div class="card details-card shadow-sm p-4">

                <span class="badge bg-primary align-self-start mb-3">
                    <?php echo clean($car['category_name']); ?>
                </span>

                <h2 class="fw-bold">
                    <?php echo clean($car['brand_name']); ?>
                    <?php echo clean($car['model_name']); ?>
                </h2>

                <p class="text-muted">
                    Model Year: <?php echo clean($car['year']); ?>
                </p>

                <h3 class="car-price">
                    ৳ <?php echo number_format((float)$car['daily_rate'], 2); ?>
                    <small class="text-muted fs-6">/ day</small>
                </h3>

                <hr>

                <h5 class="fw-bold mb-3">
                    Car Features
                </h5>

                <div class="row g-3">

                    <div class="col-6">
                        <div class="feature-box">
                            <i class="bi bi-people"></i>
                            <p class="text-muted mt-2 mb-1">
                                Seating Capacity
                            </p>
                            <h6 class="fw-bold">
                                <?php echo clean($car['seating_capacity']); ?>
                                Persons
                            </h6>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="feature-box">
                            <i class="bi bi-fuel-pump"></i>
                            <p class="text-muted mt-2 mb-1">
                                Fuel Type
                            </p>
                            <h6 class="fw-bold">
                                <?php echo clean($car['fuel_type']); ?>
                            </h6>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="feature-box">
                            <i class="bi bi-gear"></i>
                            <p class="text-muted mt-2 mb-1">
                                Transmission
                            </p>
                            <h6 class="fw-bold">
                                <?php echo clean($car['transmission']); ?>
                            </h6>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="feature-box">
                            <i class="bi bi-calendar-check"></i>
                            <p class="text-muted mt-2 mb-1">
                                Model Year
                            </p>
                            <h6 class="fw-bold">
                                <?php echo clean($car['year']); ?>
                            </h6>
                        </div>
                    </div>

                </div>

                <hr class="my-4">

                <!-- Availability Status -->
                <p>
                    <strong>Availability:</strong>

                    <?php if ($car['status'] === 'available'): ?>
                        <span class="badge bg-success">
                            Available
                        </span>
                    <?php else: ?>
                        <span class="badge bg-danger">
                            <?php echo clean(ucfirst($car['status'])); ?>
                        </span>
                    <?php endif; ?>
                </p>

                <!-- Booking Button -->
                <?php if ($car['status'] === 'available'): ?>

                    <a
                        href="<?php echo clean($bookingUrl); ?>"
                        class="btn btn-primary w-100 book-btn mt-2"
                    >
                        <i class="bi bi-calendar-check"></i>
                        Book Now
                    </a>

                <?php else: ?>

                    <button class="btn btn-secondary w-100" disabled>
                        Currently Unavailable
                    </button>

                <?php endif; ?>

                <a href="cars.php" class="btn btn-outline-dark w-100 mt-3">
                    Explore More Cars
                </a>

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
