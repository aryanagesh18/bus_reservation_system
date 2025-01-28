<?php
// Start session
session_start();
include('dbconnect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SmartBus - Book bus tickets hassle-free with our fast, reliable, and convenient booking system.">
    <meta name="keywords" content="bus tickets, online booking, SmartBus">
    <title>SmartBus - Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            overflow-x: hidden;
        }

        .hero {
            text-align: center;
            background-size: cover;
            background-position: center;
            color: white;
            padding: 150px 20px 100px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            animation: slide-bg 6s infinite;
        }

        @keyframes slide-bg {
            0% { background-image: url('images/image1.jpg'); }
            25% { background-image: url('images/image2.jpg'); }
            50% { background-image: url('images/image3.jpg'); }
            75% { background-image: url('images/image4.jpg'); }
            100% { background-image: url('images/image5.jpg'); }
        }

        footer {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 20px 0;
        }

        footer a {
            color: #007bff;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
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
            padding: 10px 20px;
            text-decoration: none;
            font-weight: bold;
            color: white;
            transition: 0.3s;
        }

        header nav a:hover {
            background-color: #0197F6;
            transform: skewX(-10deg);
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
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px;
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
            color: #0197F6;
        }
    </style>
</head>
<body>

<header class="bg-transparent text-white py-3 position-absolute">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">
            <img src="https://r2.erweima.ai/imgcompressed/img/compressed_7a5a399b571944cc6baaae053c5277cb.webp" alt="SmartBus Logo" class="rounded-circle" height="50">
        </div>
        <!-- Navbar for larger screens -->
        <nav class="d-flex gap-4 d-none d-md-flex">
            <a href="home.php" class="text-white text-decoration-none">Home</a>
            <a href="about.html" class="text-white text-decoration-none">About</a>
            <a href="services.html" class="text-white text-decoration-none">Services</a>
            <a href="contact.html" class="text-white text-decoration-none">Contact</a>
        </nav>
        <div class="d-flex align-items-center gap-3">
            <?php if (isset($_SESSION['user_name'])): ?>
                <a href="logout.php" class="btn btn-primary" onclick="confirmLogout(event)">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary">Login</a>
            <?php endif; ?>
        </div>
    </div>
    <!-- Mobile Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark d-block d-md-none">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="home.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
                <li class="nav-item"><a href="services.html" class="nav-link">Services</a></li>
                <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
            </ul>
        </div>
    </nav>
</header>

<div class="hero">
    <h1 class="display-3">Welcome to SmartBus</h1>
    <h2 class="display-5">Book Your Bus Ticket Hassle-Free</h2>
    <p class="fs-4">Fast, reliable, and convenient bus ticket booking system.</p>

    <!-- Greeting Message -->
    <?php if (isset($_SESSION['user_name'])): ?>
        <div class="greeting-card">
            <h3>Welcome Back, <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>!</h3>
            <p>We're delighted to have you here. Let's book your next journey together!</p>
        </div>
    <?php endif; ?>

    <!-- Search Bar -->
    <div class="search-bar">
        <form action="search_result.php" method="GET" class="d-flex flex-wrap gap-3 align-items-center">
            <input type="text" name="from" class="form-control" placeholder="From (Departure)" required>
            <input type="text" name="to" class="form-control" placeholder="To (Arrival)" required>
            <input type="text" id="dateInput" name="date" class="form-control" placeholder="yyyy-mm-dd" required>
            <button type="submit" class="btn">Search</button>
        </form>
    </div>
</div>

<footer class="text-center">
    <div class="container">
        <p>&copy; 2025 SmartBus. All rights reserved. | <a href="#privacy">Privacy Policy</a> | <a href="#terms">Terms of Service</a></p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmLogout(event) {
        event.preventDefault();
        const confirmation = confirm("Are you sure you want to log out?");
        if (confirmation) {
            window.location.href = "logout.php";
        }
    }

    const dateInput = document.getElementById('dateInput');

    dateInput.addEventListener('focus', () => {
        dateInput.type = 'date'; // Switch to date picker
    });

    dateInput.addEventListener('blur', () => {
        if (dateInput.value) {
            const selectedDate = new Date(dateInput.value);
            dateInput.value = selectedDate.toISOString().split('T')[0]; // Ensure yyyy-mm-dd format
        } else {
            dateInput.type = 'text'; // Switch back to text if no date selected
        }
    });
</script>

</body>
</html>
