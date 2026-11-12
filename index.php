
<?php
// Car Rental Booking System - Homepage

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DriveGo | Car Rental</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f7f8fc;
            color: #172033;
        }

        .navbar {
            background: #ffffff;
            padding: 18px 0;
        }

        .navbar-brand {
            font-size: 26px;
            font-weight: 800;
            color: #1e40af;
        }

        .navbar-brand span {
            color: #f59e0b;
        }

        .nav-link {
            font-weight: 500;
            color: #475569;
            margin: 0 8px;
        }

        .nav-link:hover {
            color: #1e40af;
        }

        .btn-primary-custom {
            background: #1e40af;
            color: #fff;
            border: none;
            padding: 11px 22px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-primary-custom:hover {
            background: #1d4ed8;
            color: #fff;
        }

        .hero {
            background: linear-gradient(120deg, #0f172a, #1e3a8a);
            color: white;
            padding: 75px 0 100px;
            overflow: hidden;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: 800;
            line-height: 1.2;
        }

        .hero h1 span {
            color: #fbbf24;
        }

        .hero p {
            color: #dbeafe;
            font-size: 16px;
            line-height: 1.8;
            margin: 22px 0;
        }

        .hero-image {
            width: 100%;
            border-radius: 18px;
            object-fit: cover;
            max-height: 360px;
        }

        .booking-search {
            background: white;
            color: #172033;
            padding: 25px;
            border-radius: 15px;
            margin-top: -50px;
            position: relative;
            box-shadow: 0 12px 35px rgba(15, 23, 42, 0.10);
        }

        .form-label {
            font-weight: 600;
            font-size: 13px;
            color: #475569;
        }

        .form-control,
        .form-select {
            min-height: 45px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        .section {
            padding: 75px 0;
        }

        .section-title {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .section-subtitle {
            color: #64748b;
            margin-bottom: 35px;
        }

        .feature-card {
            background: #fff;
            padding: 25px;
            border-radius: 13px;
            border: 1px solid #eef0f5;
            height: 100%;
            transition: 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(15, 23, 42, 0.08);
        }

        .feature-icon {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            background: #eff6ff;
            color: #1e40af;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            margin-bottom: 18px;
        }

        .car-card {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #edf0f5;
            height: 100%;
            transition: 0.3s;
        }

        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.10);
        }

        .car-image {
            width: 100%;
            height: 210px;
            object-fit: cover;
        }

        .car-content {
            padding: 20px;
        }

        .car-price {
            color: #1e40af;
            font-size: 20px;
            font-weight: 800;
        }

        .car-price small {
            color: #64748b;
            font-size: 13px;
            font-weight: 400;
        }

        .car-specs {
            color: #64748b;
            font-size: 13px;
            border-top: 1px solid #eef0f5;
            border-bottom: 1px solid #eef0f5;
            padding: 13px 0;
            margin: 15px 0;
        }

        .badge-custom {
            background: #eff6ff;
            color: #1e40af;
            padding: 7px 11px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .cta {
            background: #1e40af;
            color: white;
            border-radius: 18px;
            padding: 45px;
        }

        .cta p {
            color: #dbeafe;
        }

        footer {
            background: #0f172a;
            color: #cbd5e1;
            padding: 45px 0 20px;
        }

        footer h5 {
            color: white;
            font-weight: 700;
        }

        footer a {
            color: #cbd5e1;
            text-decoration: none;
        }

        footer a:hover {
            color: #fbbf24;
        }

        @media (max-width: 768px) {
            .hero {
                padding: 55px 0 80px;
            }

            .hero h1 {
                font-size: 34px;
            }

            .hero-image {
                margin-top: 35px;
            }

            .section-title {
                font-size: 27px;
            }

            .cta {
                padding: 30px 22px;
            }
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top shadow-sm">
    <div class="container">

        <a class="navbar-brand" href="index.php">
            Drive<span>Go.</span>
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="cars.php">Our Cars</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#services">Services</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#about">About Us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>

            </ul>

            <!-- Customer Login / Logout -->

            <div class="d-flex align-items-center gap-2">

                <?php if (isset($_SESSION['user_id'])) { ?>

                    <span class="text-dark fw-semibold">
                        Welcome,
                        <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </span>

                    <a href="logout.php" class="btn btn-danger">
                        Logout
                    </a>

                <?php } else { ?>

                    <a href="login.php" class="btn btn-outline-primary">
                        Login
                    </a>

                    <a href="register.php" class="btn btn-warning">
                        Sign Up
                    </a>

                <?php } ?>

            </div>

        </div>
    </div>
</nav>


<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6">

                <span class="badge bg-warning text-dark mb-3">
                    Your Journey, Our Priority
                </span>

                <h1>
                    Find Your Perfect
                    <span>Rental Car</span>
                    Today
                </h1>

                <p>
                    Discover the perfect car for your next journey.
                    Affordable prices, comfortable rides and a simple
                    booking experience.
                </p>

                <a href="cars.php"
                   class="btn btn-warning fw-bold px-4 py-3">
                    Explore Our Cars →
                </a>

            </div>

            <div class="col-lg-6">

                <img
                    src="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=1000&q=85"
                    alt="Rental car"
                    class="hero-image">

            </div>

        </div>
    </div>
</section>


<!-- Booking Search -->
<div class="container">
    <div class="booking-search">

        <form action="cars.php" method="GET">

            <div class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label class="form-label">Pickup Location</label>

                    <select name="pickup_location" class="form-select">
                        <option value="Dhaka">Dhaka</option>
                        <option value="Chattogram">Chattogram</option>
                        <option value="Sylhet">Sylhet</option>
                        <option value="Cox's Bazar">Cox's Bazar</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Pickup Date</label>

                    <input type="date"
                           name="pickup_date"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Return Date</label>

                    <input type="date"
                           name="return_date"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-3">
                    <button type="submit"
                            class="btn btn-primary-custom w-100">
                        Search Cars
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>


<!-- Why Choose Us -->
<section class="section" id="services">
    <div class="container">

        <div class="text-center">
            <h2 class="section-title">Why Choose DriveGo?</h2>

            <p class="section-subtitle">
                Making your journey comfortable, safe and affordable.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">🚘</div>
                    <h5 class="fw-bold">Wide Car Selection</h5>

                    <p class="text-secondary mb-0">
                        Choose from economy, sedan, SUV and premium cars
                        for your travel needs.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h5 class="fw-bold">Affordable Pricing</h5>

                    <p class="text-secondary mb-0">
                        Transparent rental prices with no hidden charges.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">🛡️</div>
                    <h5 class="fw-bold">Safe & Reliable</h5>

                    <p class="text-secondary mb-0">
                        Enjoy a reliable rental experience with
                        well-maintained vehicles.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Featured Cars -->
<section class="section bg-white" id="cars">
    <div class="container">

        <div class="d-flex justify-content-between
                    align-items-center flex-wrap mb-4">

            <div>
                <h2 class="section-title">Featured Cars</h2>

                <p class="section-subtitle mb-0">
                    Choose your ride for your next adventure.
                </p>
            </div>

            <a href="cars.php" class="btn btn-outline-primary">
                View All Cars →
            </a>

        </div>

        <div class="row g-4">

            <!-- Car 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="car-card">

                    <img
                        src="https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?auto=format&fit=crop&w=900&q=85"
                        alt="Toyota Corolla"
                        class="car-image">

                    <div class="car-content">

                        <span class="badge-custom">Economy</span>

                        <h5 class="fw-bold mt-3">
                            Toyota Corolla
                        </h5>

                        <p class="text-secondary small">
                            Comfortable and fuel-efficient city car.
                        </p>

                        <div class="car-specs d-flex justify-content-between">
                            <span>👥 5 Seats</span>
                            <span>⚙ Automatic</span>
                            <span>⛽ Petrol</span>
                        </div>

                        <div class="d-flex justify-content-between
                                    align-items-center">

                            <div class="car-price">
                                ৳3,500 <small>/ day</small>
                            </div>

                            <a href="car_details.php?id=1"
                               class="btn btn-primary-custom">
                                Book Now
                            </a>

                        </div>
                    </div>
                </div>
            </div>


            <!-- Car 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="car-card">

                    <img
                        src="https://images.unsplash.com/photo-1568844293986-8d0400bd4745?auto=format&fit=crop&w=900&q=85"
                        alt="Toyota RAV4"
                        class="car-image">

                    <div class="car-content">

                        <span class="badge-custom">SUV</span>

                        <h5 class="fw-bold mt-3">
                            Toyota RAV4
                        </h5>

                        <p class="text-secondary small">
                            Spacious SUV for family trips and long drives.
                        </p>

                        <div class="car-specs d-flex justify-content-between">
                            <span>👥 5 Seats</span>
                            <span>⚙ Automatic</span>
                            <span>⛽ Hybrid</span>
                        </div>

                        <div class="d-flex justify-content-between
                                    align-items-center">

                            <div class="car-price">
                                ৳6,500 <small>/ day</small>
                            </div>

                            <a href="car_details.php?id=2"
                               class="btn btn-primary-custom">
                                Book Now
                            </a>

                        </div>
                    </div>
                </div>
            </div>


            <!-- Car 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="car-card">

                    <img
                        src="https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=900&q=85"
                        alt="BMW premium car"
                        class="car-image">

                    <div class="car-content">

                        <span class="badge-custom">Premium</span>

                        <h5 class="fw-bold mt-3">
                            BMW 5 Series
                        </h5>

                        <p class="text-secondary small">
                            Premium comfort and style for special journeys.
                        </p>

                        <div class="car-specs d-flex justify-content-between">
                            <span>👥 5 Seats</span>
                            <span>⚙ Automatic</span>
                            <span>⛽ Petrol</span>
                        </div>

                        <div class="d-flex justify-content-between
                                    align-items-center">

                            <div class="car-price">
                                ৳12,000 <small>/ day</small>
                            </div>

                            <a href="car_details.php?id=3"
                               class="btn btn-primary-custom">
                                Book Now
                            </a>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- About Section -->
<section class="section" id="about">
    <div class="container">

        <div class="row align-items-center g-5">

            <div class="col-lg-6">

                <img
                    src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1000&q=85"
                    alt="Car rental service"
                    class="img-fluid rounded-4">

            </div>

            <div class="col-lg-6">

                <span class="badge-custom">About Our Service</span>

                <h2 class="section-title mt-3">
                    Make Every Journey Special
                </h2>

                <p class="text-secondary">
                    DriveGo is a car rental booking system designed
                    to make vehicle rental easy and convenient.
                    Customers can explore cars, choose rental dates
                    and submit booking requests.
                </p>

                <ul class="text-secondary">
                    <li class="mb-2">Simple car booking process</li>
                    <li class="mb-2">Multiple vehicle categories</li>
                    <li class="mb-2">Easy booking management</li>
                    <li class="mb-2">Customer-focused service</li>
                </ul>

                <a href="cars.php" class="btn btn-primary-custom">
                    Find Your Car
                </a>

            </div>

        </div>
    </div>
</section>


<!-- Call to Action -->
<section class="section pt-0">
    <div class="container">

        <div class="cta text-center">

            <h2 class="fw-bold">
                Ready for Your Next Journey?
            </h2>

            <p class="mt-3 mb-4">
                Find the right car and book your trip today.
            </p>

            <a href="cars.php"
               class="btn btn-warning fw-bold px-4 py-3">
                Browse Available Cars
            </a>

        </div>

    </div>
</section>


<!-- Footer -->
<footer id="contact">
    <div class="container">

        <div class="row g-4">

            <div class="col-md-4">
                <h5>DriveGo.</h5>

                <p class="mt-3">
                    Your trusted partner for comfortable,
                    reliable and affordable car rentals.
                </p>
            </div>

            <div class="col-md-4">
                <h5>Quick Links</h5>

                <ul class="list-unstyled mt-3">

                    <li class="mb-2">
                        <a href="index.php">Home</a>
                    </li>

                    <li class="mb-2">
                        <a href="cars.php">Our Cars</a>
                    </li>

                    <?php if (isset($_SESSION['user_id'])) { ?>

                        <li class="mb-2">
                            <a href="logout.php">Logout</a>
                        </li>

                    <?php } else { ?>

                        <li class="mb-2">
                            <a href="login.php">Login</a>
                        </li>

                        <li class="mb-2">
                            <a href="register.php">Register</a>
                        </li>

                    <?php } ?>

                </ul>
            </div>

            <div class="col-md-4">
                <h5>Contact Us</h5>

                <p class="mt-3">
                    Dhaka, Bangladesh<br>
                    Email: info@drivego.com<br>
                    Phone: +880 1700-000000
                </p>
            </div>

        </div>

        <hr class="border-secondary mt-4">

        <div class="text-center small">
            © <?php echo date("Y"); ?> DriveGo Car Rental.
            All rights reserved.
        </div>

    </div>
</footer>


<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
