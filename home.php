<?php
session_start();
include('dbconnect.php');

function db_error($error) {
    die("Database Error: " . $error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartBus - Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .hero {
            text-align: center;
            background-image: url('images/bg2.jpeg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 20px 50px;
            min-height: 50vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        footer {
            background: #333; /* Darker background */
            color: white;
            padding: 30px 0; /* Increased padding */
            text-align: center;
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around; /* Distribute content evenly */
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-section {
            flex: 1 1 250px; /* Adjust width as needed */
            margin-bottom: 20px; /* Spacing between sections */
            text-align: left; /* Align text to the left within sections */
        }

        .footer-section h4 {
            color: #fff;
            margin-bottom: 15px;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section li {
            margin-bottom: 10px;
        }

        .footer-section a {
            color: #ddd; /* Lighter link color */
            text-decoration: none;
            transition: color 0.3s; /* Smooth color transition on hover */
        }

        .footer-section a:hover {
            color: #fff; /* White link color on hover */
        }

        .social-links {
            margin-top: 20px;
        }

        .social-links a {
            display: inline-block;
            margin: 0 10px;
            font-size: 20px;
            color: #ddd;
            transition: color 0.3s;
        }

        .social-links a:hover {
            color: #fff;
        }

        .footer-bottom {
            background-color: #222; /* Slightly darker bottom bar */
            padding: 15px 0;
            text-align: center;
            width: 100%;
        }

        .footer-bottom p {
            margin: 0;
            font-size: 0.9rem;
        }

        header {
            background: rgba(0, 0, 0, 0.4);
            color: white;
            padding: 15px 20px;
            position: absolute;
            width: 100%;
            z-index: 1;
        }

        header .logo img {
            height: 50px;
        }

        header nav a {
            display: inline-block;
            margin: 0 15px;
            text-decoration: none;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            transition: 0.3s;
            position: relative;
            padding: 1rem;
            font-family: ui-sans-serif, system-ui, -apple-system, system-ui, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
            font-size: 1rem;
        }

        header nav a:before {
            background-color: #fff;
            content: "";
            display: inline-block;
            height: 1px;
            margin-right: 10px;
            transition: all .42s cubic-bezier(.25,.8,.25,1);
            width: 0;
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
        }

        header nav a:hover:before {
            background-color: #fff;
            width: 3rem;
        }

        header nav a:hover {
            background-color: transparent;
            transform: none;
        }

        .search-bar {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            max-width: 1000px;
            margin: 20px auto;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .search-bar input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-bar button {
            padding: 10px 20px;
            background-color: #0197F6;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
        }

        .search-bar button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            header .logo img {
                height: 40px;
            }

            .hero {
                padding: 100px 20px 50px;
                height: auto;
            }

            .search-bar {
                flex-direction: column;
                gap: 10px;
            }

            footer {
                padding: 15px 0;
            }
        }

        .greeting-card {
            padding: 10px;
            border-radius: 10px;
            color: white;
            text-align: center;
            max-width: 500px;
            margin: 20px auto;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .greeting-card h3 {
            font-size: 2rem;
            font-weight: bold;
        }

        .greeting-card span {
            color: rgb(239, 244, 247);
        }

        .popular-routes {
            padding: 50px 20px;
            background-color: #f8f9fa;
        }

        .popular-routes h2 {
            margin-bottom: 30px;
            text-align: center;
            color: #333;
        }

        .route-card {
            background-color: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
            overflow: hidden;
        }

        .route-card:hover {
            transform: translateY(-8px);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
        }

        .route-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            margin-bottom: 15px;
        }

        .route-card .route-content {
            padding: 15px;
        }

        .route-card h3 {
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
        }

        .route-card p {
            color: #666;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .route-card a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0197F6;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        .route-card a:hover {
            background-color: #007bff;
        }

        @media (min-width: 767px) {
            .route-card {
                display: flex;
                flex-direction: column;
            }

            .route-card img {
                height: 200px;
            }
        }

        @media (max-width: 767px) {
            .route-card img {
                height: auto;
            }
        }
    </style>
</head>
<body>

<header class="bg-transparent text-white py-3 position-absolute w-100">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">
            <img src="https://r2.erweima.ai/imgcompressed/img/compressed_7a5a399b571944cc6baaae053c5277cb.webp" alt="SmartBus Logo" class="rounded-circle" height="50">
        </div>
        <nav class="d-flex gap-4 d-none d-md-flex">
            <a href="home.php" class="text-white text-decoration-none">Home</a>
            <a href="about.html" class="text-white text-decoration-none">About</a>
            <a href="services.html" class="text-white text-decoration-none">Services</a>
            <a href="contact.html" class="text-white text-decoration-none">Contact</a>
            <div class="manage-bookings-dropdown">
                <a class="manage-bookings-link dropdown-toggle" href="#" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bus-alt"></i> Manage Bookings
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="view_bookings.php"><i class="fas fa-eye"></i> View Bookings</a>
                    <a class="dropdown-item" href="cancel_bookings.php"><i class="fas fa-times-circle"></i> Cancel Bookings</a>
                </div>
            </div>
        </nav>
        <div class="d-flex align-items-center gap-3">
            <?php if (isset($_SESSION['user_name'])): ?>
                <a href="logout.php" class="btn btn-primary" onclick="confirmLogout(event)">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary">Login</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<div class="hero">
    <h1 class="display-3">Welcome to SmartBus</h1>
    <h2 class="display-5">Book Your Bus Ticket Hassle-Free</h2>
    <p class="fs-4">Fast, reliable, and convenient bus ticket booking system.</p>

    <?php if (isset($_SESSION['user_name'])): ?>
        <div class="greeting-card">
            <h3>Welcome Back, <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>!</h3>
        </div>
    <?php endif; ?>

    <div class="search-bar">
        <form action="search_result.php" method="GET" class="d-flex flex-wrap gap-3 align-items-center">
            <input type="text" name="from" class="form-control" placeholder="From (Departure)" required>
            <input type="text" name="to" class="form-control" placeholder="To (Arrival)" required>
            <input type="date" id="dateInput" name="date" class="form-control" placeholder="yyyy-mm-dd" required>
            <button type="submit" class="btn">Search</button>
        </form>
    </div>
</div>

<div class="popular-routes">
    <div class="container">
        <h2>Popular Routes</h2>
        <div class="row">
            <?php
            $popularRoutesQuery = "SELECT * FROM popular_routes";
            $popularRoutesResult = $conn->query($popularRoutesQuery);

            if ($popularRoutesResult) {
                if ($popularRoutesResult->num_rows > 0) {
                    while ($row = $popularRoutesResult->fetch_assoc()) {
                        echo '<div class="col-md-4">';
                        echo '<div class="route-card">';
                        if (!empty($row['image'])) {
                            echo '<img src="' . $row['image'] . '" alt="' . $row['route_name'] . '">';
                        }
                        echo '<div class="route-content">';
                        echo '<h3>' . htmlspecialchars($row['route_name']) . '</h3>';
                        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                        echo '<a href="search_result.php?from=' . urlencode($row['departure']) . '&to=' . urlencode($row['arrival']) . '&date=' . date('Y-m-d') . '">Book Now</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No popular routes found.</p>";
                }
            } else {
                db_error($conn->error);
            }
            ?>
        </div>
    </div>
</div>

<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h4>About Us</h4>
            <ul>
                <li><a href="about.html">Our Story</a></li>
                <li><a href="#">Team</a></li>
                <li><a href="#">Careers</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="Services.html">Services</a></li>
                
                <li><a href="Contact.html">Contact</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Contact Us</h4>
            <ul>
                <li><a href="#">Help & Support</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Contact Form</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Follow Us</h4>
            <div class="social-links">
    <a href="https://www.facebook.com/yourpage" target="_blank"><i class="fab fa-facebook-f"></i></a>
    <a href="https://twitter.com/yourprofile" target="_blank"><i class="fab fa-twitter"></i></a>
    <a href="https://www.instagram.com/arya.nagesh.28" target="_blank"><i class="fab fa-instagram"></i></a>
    <a href="https://www.linkedin.com/in/yourprofile" target="_blank"><i class="fab fa-linkedin-in"></i></a>
</div>

        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 SmartBus. All rights reserved. | <a href="privacy_policy.html">Privacy Policy</a> | <a href="terms_conditions.html">Terms & Conditions</a></p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmLogout(event) {
        if (!confirm('Are you sure you want to log out?')) {
            event.preventDefault();
        }
    }
</script>

</body>
</html>
