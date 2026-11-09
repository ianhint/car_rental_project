-- Car Rental Booking System Database Schema
-- Database Name: car_rental_db

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS car_damage_reports;
DROP TABLE IF EXISTS maintenance;
DROP TABLE IF EXISTS wishlists;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS booking_services;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS driver_assignments;
DROP TABLE IF EXISTS drivers;
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS car_images;
DROP TABLE IF EXISTS cars;
DROP TABLE IF EXISTS brands;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;
SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
-- 1. Table structure for table `roles`
-- --------------------------------------------------------
CREATE TABLE `roles` (
  `role_id` INT AUTO_INCREMENT PRIMARY KEY,
  `role_name` VARCHAR(50) NOT NULL UNIQUE,
  `description` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 2. Table structure for table `users`
-- --------------------------------------------------------
CREATE TABLE `users` (
  `user_id` INT AUTO_INCREMENT PRIMARY KEY,
  `role_id` INT NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `phone` VARCHAR(20) DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `address` TEXT DEFAULT NULL,
  `profile_image` VARCHAR(255) DEFAULT 'default_avatar.png',
  `status` ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 3. Table structure for table `categories`
-- --------------------------------------------------------
CREATE TABLE `categories` (
  `category_id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_name` VARCHAR(50) NOT NULL UNIQUE,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 4. Table structure for table `brands`
-- --------------------------------------------------------
CREATE TABLE `brands` (
  `brand_id` INT AUTO_INCREMENT PRIMARY KEY,
  `brand_name` VARCHAR(50) NOT NULL UNIQUE,
  `logo` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 5. Table structure for table `cars`
-- --------------------------------------------------------
CREATE TABLE `cars` (
  `car_id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT NOT NULL,
  `brand_id` INT NOT NULL,
  `model_name` VARCHAR(100) NOT NULL,
  `license_plate` VARCHAR(30) NOT NULL UNIQUE,
  `year` INT NOT NULL,
  `seating_capacity` INT NOT NULL,
  `fuel_type` ENUM('Petrol', 'Diesel', 'Hybrid', 'Electric') NOT NULL,
  `transmission` ENUM('Automatic', 'Manual') NOT NULL,
  `daily_rate` DECIMAL(10, 2) NOT NULL,
  `featured_image` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('available', 'rented', 'maintenance', 'inactive') DEFAULT 'available',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 6. Table structure for table `car_images`
-- --------------------------------------------------------
CREATE TABLE `car_images` (
  `image_id` INT AUTO_INCREMENT PRIMARY KEY,
  `car_id` INT NOT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  `is_primary` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 7. Table structure for table `bookings`
-- --------------------------------------------------------
CREATE TABLE `bookings` (
  `booking_id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_number` VARCHAR(20) NOT NULL UNIQUE,
  `customer_id` INT NOT NULL,
  `car_id` INT NOT NULL,
  `pickup_date` DATETIME NOT NULL,
  `return_date` DATETIME NOT NULL,
  `pickup_location` VARCHAR(255) NOT NULL,
  `return_location` VARCHAR(255) NOT NULL,
  `total_days` INT NOT NULL,
  `total_amount` DECIMAL(10, 2) NOT NULL,
  `status` ENUM('Pending', 'Confirmed', 'Rejected', 'Cancelled', 'Ongoing', 'Completed', 'Overdue') DEFAULT 'Pending',
  `special_requests` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 8. Table structure for table `payments`
-- --------------------------------------------------------
CREATE TABLE `payments` (
  `payment_id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT NOT NULL,
  `transaction_id` VARCHAR(100) NOT NULL UNIQUE,
  `payment_amount` DECIMAL(10, 2) NOT NULL,
  `payment_method` ENUM('Cash', 'Credit Card', 'Debit Card', 'Bank Transfer', 'bKash/Nagad') NOT NULL,
  `payment_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `verification_status` ENUM('Pending', 'Verified', 'Failed', 'Refunded') DEFAULT 'Pending',
  `remarks` TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 9. Table structure for table `drivers`
-- --------------------------------------------------------
CREATE TABLE `drivers` (
  `driver_id` INT AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(100) NOT NULL,
  `license_number` VARCHAR(50) NOT NULL UNIQUE,
  `phone` VARCHAR(20) NOT NULL,
  `status` ENUM('Available', 'Assigned', 'Off-duty') DEFAULT 'Available',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 10. Table structure for table `driver_assignments`
-- --------------------------------------------------------
CREATE TABLE `driver_assignments` (
  `assignment_id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT NOT NULL,
  `driver_id` INT NOT NULL,
  `assigned_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 11. Table structure for table `services`
-- --------------------------------------------------------
CREATE TABLE `services` (
  `service_id` INT AUTO_INCREMENT PRIMARY KEY,
  `service_name` VARCHAR(100) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `description` TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 12. Table structure for table `booking_services`
-- --------------------------------------------------------
CREATE TABLE `booking_services` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT NOT NULL,
  `service_id` INT NOT NULL,
  `price_applied` DECIMAL(10, 2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 13. Table structure for table `reviews`
-- --------------------------------------------------------
CREATE TABLE `reviews` (
  `review_id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT NOT NULL,
  `customer_id` INT NOT NULL,
  `car_id` INT NOT NULL,
  `rating` INT CHECK (`rating` BETWEEN 1 AND 5),
  `comment` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 14. Table structure for table `wishlists`
-- --------------------------------------------------------
CREATE TABLE `wishlists` (
  `wishlist_id` INT AUTO_INCREMENT PRIMARY KEY,
  `customer_id` INT NOT NULL,
  `car_id` INT NOT NULL,
  `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `user_car_unique` (`customer_id`, `car_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 15. Table structure for table `maintenance`
-- --------------------------------------------------------
CREATE TABLE `maintenance` (
  `maintenance_id` INT AUTO_INCREMENT PRIMARY KEY,
  `car_id` INT NOT NULL,
  `service_details` TEXT NOT NULL,
  `cost` DECIMAL(10, 2) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE DEFAULT NULL,
  `status` ENUM('Scheduled', 'In-Progress', 'Completed') DEFAULT 'Scheduled',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 16. Table structure for table `car_damage_reports`
-- --------------------------------------------------------
CREATE TABLE `car_damage_reports` (
  `report_id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT NOT NULL,
  `staff_id` INT NOT NULL,
  `pickup_time` DATETIME NOT NULL,
  `return_time` DATETIME DEFAULT NULL,
  `fuel_level_pickup` VARCHAR(20) NOT NULL,
  `fuel_level_return` VARCHAR(20) DEFAULT NULL,
  `damage_description` TEXT DEFAULT NULL,
  `repair_cost` DECIMAL(10, 2) DEFAULT 0.00,
  `status` ENUM('Pending', 'Inspected', 'Resolved') DEFAULT 'Pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================
-- SAMPLE DATA INSERTION
-- ========================================================

-- Roles
INSERT INTO `roles` (`role_id`, `role_name`, `description`) VALUES
(1, 'Admin', 'System Administrator with full permissions'),
(2, 'Staff', 'Staff/Manager for handling vehicle handovers, returns, and damage inspection'),
(3, 'Customer', 'Registered user who can browse vehicles and place bookings');

-- Users (Password is bcrypt encoded for 'password123')
INSERT INTO `users` (`user_id`, `role_id`, `full_name`, `email`, `phone`, `password`, `address`) VALUES
(1, 1, 'Ismail Hossain', 'admin@carrental.com', '+8801700000001', '$2y$10$e8q4V3...hashed_pass...', 'Dhaka, Bangladesh'),
(2, 2, 'Rafiqul Islam', 'staff.rafiq@carrental.com', '+8801700000002', '$2y$10$e8q4V3...hashed_pass...', 'Dhanmondi, Dhaka'),
(3, 3, 'Tanvir Ahmed', 'tanvir@example.com', '+8801811111111', '$2y$10$e8q4V3...hashed_pass...', 'Gulshan, Dhaka'),
(4, 3, 'Nusrat Jahan', 'nusrat@example.com', '+8801922222222', '$2y$10$e8q4V3...hashed_pass...', 'Uttara, Dhaka');

-- Categories
INSERT INTO `categories` (`category_id`, `category_name`, `description`) VALUES
(1, 'Sedan', 'Comfortable 4-door vehicles suitable for family and business travel'),
(2, 'SUV', 'Spacious Sports Utility Vehicles built for all terrains'),
(3, 'Luxury', 'High-end executive vehicles delivering premium experience');

-- Brands
INSERT INTO `brands` (`brand_id`, `brand_name`, `logo`) VALUES
(1, 'Toyota', 'toyota_logo.png'),
(2, 'Honda', 'honda_logo.png'),
(3, 'BMW', 'bmw_logo.png');

-- Cars
INSERT INTO `cars` (`car_id`, `category_id`, `brand_id`, `model_name`, `license_plate`, `year`, `seating_capacity`, `fuel_type`, `transmission`, `daily_rate`, `featured_image`, `status`) VALUES
(1, 1, 1, 'Corolla Axio', 'DHAKA-METRO-GA-11-2233', 2020, 5, 'Hybrid', 'Automatic', 50.00, 'corolla.jpg', 'available'),
(2, 2, 1, 'Prado VX', 'DHAKA-METRO-GHA-44-5566', 2022, 7, 'Diesel', 'Automatic', 120.00, 'prado.jpg', 'available'),
(3, 3, 3, '5 Series 530i', 'DHAKA-METRO-CHA-99-0011', 2023, 5, 'Petrol', 'Automatic', 250.00, 'bmw5.jpg', 'available');

-- Car Images
INSERT INTO `car_images` (`image_id`, `car_id`, `image_url`, `is_primary`) VALUES
(1, 1, 'corolla_front.jpg', 1),
(2, 1, 'corolla_inside.jpg', 0),
(3, 2, 'prado_front.jpg', 1),
(4, 3, 'bmw_front.jpg', 1);

-- Bookings
INSERT INTO `bookings` (`booking_id`, `booking_number`, `customer_id`, `car_id`, `pickup_date`, `return_date`, `pickup_location`, `return_location`, `total_days`, `total_amount`, `status`, `special_requests`) VALUES
(1, 'BK-20261101-001', 3, 1, '2026-11-10 09:00:00', '2026-11-13 09:00:00', 'Airport Station, Dhaka', 'Gulshan 2, Dhaka', 3, 150.00, 'Confirmed', 'Child safety seat needed'),
(2, 'BK-20261102-002', 4, 2, '2026-11-15 10:00:00', '2026-11-17 10:00:00', 'Uttara Sector 4', 'Uttara Sector 4', 2, 240.00, 'Pending', 'Require full tank gas');

-- Payments
INSERT INTO `payments` (`payment_id`, `booking_id`, `transaction_id`, `payment_amount`, `payment_method`, `verification_status`, `remarks`) VALUES
(1, 1, 'TXN-BK1-889922', 150.00, 'bKash/Nagad', 'Verified', 'Payment received via mobile banking');

-- Drivers
INSERT INTO `drivers` (`driver_id`, `full_name`, `license_number`, `phone`, `status`) VALUES
(1, 'Abul Kalam', 'DL-DH-98765', '+8801533333333', 'Assigned'),
(2, 'Monir Hossain', 'DL-DH-12345', '+8801644444444', 'Available');

-- Driver Assignments
INSERT INTO `driver_assignments` (`assignment_id`, `booking_id`, `driver_id`) VALUES
(1, 1, 1);

-- Services (Add-ons)
INSERT INTO `services` (`service_id`, `service_name`, `price`, `description`) VALUES
(1, 'Child Safety Seat', 10.00, 'Baby / child seat installed'),
(2, 'Additional Driver', 25.00, 'Permission for an extra registered driver'),
(3, 'GPS Navigation', 15.00, 'Portable satellite navigation system');

-- Booking Services
INSERT INTO `booking_services` (`id`, `booking_id`, `service_id`, `price_applied`) VALUES
(1, 1, 1, 10.00);

-- Reviews
INSERT INTO `reviews` (`review_id`, `booking_id`, `customer_id`, `car_id`, `rating`, `comment`) VALUES
(1, 1, 3, 1, 5, 'Great condition car and smooth handover process!');

-- Wishlists
INSERT INTO `wishlists` (`wishlist_id`, `customer_id`, `car_id`) VALUES
(1, 3, 3),
(2, 4, 1);

-- Maintenance
INSERT INTO `maintenance` (`maintenance_id`, `car_id`, `service_details`, `cost`, `start_date`, `end_date`, `status`) VALUES
(1, 2, 'Engine oil change and brake pad inspection', 150.00, '2026-10-01', '2026-10-02', 'Completed');

-- Car Damage Reports
INSERT INTO `car_damage_reports` (`report_id`, `booking_id`, `staff_id`, `pickup_time`, `return_time`, `fuel_level_pickup`, `fuel_level_return`, `damage_description`, `repair_cost`, `status`) VALUES
(1, 1, 2, '2026-11-10 09:15:00', '2026-11-13 08:45:00', 'Full', 'Full', 'No new scratches or damage noted during return inspection.', 0.00, 'Resolved');
