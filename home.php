<?php
// Start the session
session_start();

// Include the database connection
include('dbconnect.php');

// Get search parameters from the GET request
$from = isset($_GET['from']) ? $_GET['from'] : '';
$to = isset($_GET['to']) ? $_GET['to'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

// Initialize variables for search results
$buses = [];
$busCount = 0;

// Check if the form was submitted with valid parameters
if (!empty($from) && !empty($to) && !empty($date)) {
    // Query the database to find buses between the 'from' and 'to' locations on the specified date
    $sql = "SELECT * FROM buses WHERE departure_city = ? AND arrival_city = ? AND departure_date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $from, $to, $date);
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
    <title>Search Results - SmartBus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .results-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
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
    </style>
</head>
<body>

<header>
    <h1>Search Results</h1>
</header>

<div class="results-container">
    <h2>Available Buses</h2>

    <?php if ($busCount > 0): ?>
        <p>We found <?php echo $busCount; ?> bus(es) for your search from <strong><?php echo htmlspecialchars($from); ?></strong> to <strong><?php echo htmlspecialchars($to); ?></strong> on <strong><?php echo htmlspecialchars($date); ?></strong>.</p>

        <?php foreach ($buses as $bus): ?>
            <div class="bus-card">
                <h4><?php echo htmlspecialchars($bus['bus_name']); ?></h4>
                <p>Departure Time: <?php echo htmlspecialchars($bus['departure_time']); ?></p>
                <p>Arrival Time: <?php echo htmlspecialchars($bus['arrival_time']); ?></p>
                <p>Price: ₹<?php echo htmlspecialchars($bus['price']); ?></p>
                <a href="book_ticket.php?bus_id=<?php echo $bus['bus_id']; ?>" class="btn">Book Now</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No buses found for your search. Please try again with different criteria.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
