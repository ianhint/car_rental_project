
<?php
require_once "db/config.php";

// Car images from Unsplash
$carImages = [
    1 => "https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=900&q=80",
    2 => "https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&w=900&q=80",
    3 => "https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=900&q=80"
];

// Get available cars
$sql = "SELECT
            cars.car_id,
            cars.model_name,
            cars.year,
            cars.seating_capacity,
            cars.fuel_type,
            cars.transmission,
            cars.daily_rate,
            brands.brand_name,
            categories.category_name
        FROM cars
        INNER JOIN brands
            ON cars.brand_id = brands.brand_id
        INNER JOIN categories
            ON cars.category_id = categories.category_id
        WHERE cars.status = 'available'
        ORDER BY cars.car_id ASC";

$result = mysqli_query($conn, $sql);

function clean($value) {
    return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Our Cars | DriveGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
        }

        .car-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: 0.3s;
        }

        .car-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .car-image {
            width: 100%;
            height: 230px;
            object-fit: cover;
        }

        .car-price {
            color: #198754;
            font-weight: bold;
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            DriveGo
        </a>

        <div>
            <a href="index.php" class="btn btn-outline-light btn-sm">
                Home
            </a>

            <a href="login.php" class="btn btn-warning btn-sm">
                Login
            </a>
        </div>

    </div>
</nav>


<!-- Cars Section -->
<div class="container py-5">

    <div class="text-center mb-5">

        <h1 class="fw-bold">Our Available Cars</h1>

        <p class="text-muted">
            Choose your perfect car and enjoy your journey.
        </p>

    </div>


    <div class="row g-4">

        <?php if ($result && mysqli_num_rows($result) > 0): ?>

            <?php while ($car = mysqli_fetch_assoc($result)): ?>

                <?php
                $carId = (int)$car['car_id'];

                // Use default image if car ID is not in image list
                $image = $carImages[$carId] ??
                    "https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=900&q=80";
                ?>

                <div class="col-md-6 col-lg-4">

                    <div class="card car-card h-100 shadow-sm">

                        <!-- Car Image -->
                        <img
                            src="<?php echo clean($image); ?>"
                            class="car-image"
                            alt="<?php echo clean($car['model_name']); ?>"
                        >

                        <div class="card-body p-4">

                            <span class="badge bg-primary">
                                <?php echo clean($car['category_name']); ?>
                            </span>

                            <h5 class="fw-bold mt-3">

                                <?php echo clean($car['brand_name']); ?>

                                <?php echo clean($car['model_name']); ?>

                            </h5>

                            <p class="text-muted mb-2">

                                Year: <?php echo clean($car['year']); ?>

                            </p>

                            <hr>

                            <p>
                                <strong>Seats:</strong>
                                <?php echo clean($car['seating_capacity']); ?>
                            </p>

                            <p>
                                <strong>Fuel:</strong>
                                <?php echo clean($car['fuel_type']); ?>
                            </p>

                            <p>
                                <strong>Transmission:</strong>
                                <?php echo clean($car['transmission']); ?>
                            </p>

                            <h5 class="car-price mt-3">

                                ৳ <?php echo number_format((float)$car['daily_rate'], 2); ?>

                                <small class="text-muted">/ day</small>

                            </h5>

                            <a
                                href="car_details.php?id=<?php echo $carId; ?>"
                                class="btn btn-dark w-100 mt-3"
                            >
                                View Details
                            </a>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="col-12 text-center">

                <h4>No Available Cars Found!</h4>

            </div>

        <?php endif; ?>

    </div>

</div>


<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">

    <p class="mb-0">
        © <?php echo date("Y"); ?> DriveGo. All Rights Reserved.
    </p>

</footer>

</body>
</html>
