<?php
// dbconnect.php - Include this file to connect to the database
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your database password
$dbname = "smart_bus";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
session_start(); // Start the session

// Get search parameters (from and to)
$from = isset($_GET['from']) ? $_GET['from'] : '';
$to = isset($_GET['to']) ? $_GET['to'] : '';

// Initialize variables for search results
$buses = [];
$busCount = 0;

// If the user submits a search, fetch the results from the database
if (!empty($from) && !empty($to)) {
    // Query the database to find buses between the 'from' and 'to' locations
    $sql = "SELECT * FROM buses WHERE departure_city = ? AND arrival_city = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $from, $to);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch results into an array
    $busCount = $result->num_rows;
    while ($row = $result->fetch_assoc()) {
        $buses[] = $row;
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SmartBus - Book bus tickets hassle-free with our fast, reliable, and convenient booking system.">
    <meta name="keywords" content="bus tickets, online booking, SmartBus">
    <title>SmartBus - Search and Book Bus Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .search-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .search-results {
            margin: 50px auto;
            max-width: 1200px;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .bus-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .bus-card:hover {
            background-color: #e9ecef;
            transform: translateY(-5px);
        }

        .bus-card .btn {
            background-color: #0197F6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .bus-card .btn:hover {
            background-color: #007bff;
        }

        footer {
            text-align: center;
            padding: 20px 0;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<header>
    <h1>SmartBus</h1>
    <p>Book your bus tickets hassle-free!</p>
</header>

<!-- Search Form -->
<div class="search-container">
    <h2>Find a Bus</h2>
    <form action="" method="get" class="row g-3">
        <div class="col-md-5">
            <label for="from" class="form-label">From</label>
            <input type="text" name="from" id="from" class="form-control" placeholder="Enter departure city" required>
        </div>
        <div class="col-md-5">
            <label for="to" class="form-label">To</label>
            <input type="text" name="to" id="to" class="form-control" placeholder="Enter destination city" required>
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
    </form>
</div>

<!-- Search Results -->
<?php if (!empty($from) && !empty($to)): ?>
    <div class="search-results">
        <h2>Search Results</h2>

        <?php if ($busCount > 0): ?>
            <?php foreach ($buses as $bus): ?>
                <div class="bus-card">
                    <div class="card-body">
                        <div>
                            <h5 class="card-title"><?php echo htmlspecialchars($bus['bus_name']); ?></h5>
                            <p class="card-text">Departure: <?php echo htmlspecialchars($bus['departure_time']); ?></p>
                            <p class="card-text">Arrival: <?php echo htmlspecialchars($bus['arrival_time']); ?></p>
                            <p class="card-text">Price: ₹<?php echo htmlspecialchars($bus['price']); ?></p>
                        </div>
                        <a href="book_ticket.php?bus_id=<?php echo $bus['bus_id']; ?>" class="btn">Book Now</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No buses found for your search. Please try again with different criteria.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<footer>
    <p>&copy; 2025 SmartBus. All rights reserved. | <a href="#privacy">Privacy Policy</a> | <a href="#terms">Terms of Service</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
