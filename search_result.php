<?php
// Include database connection
include('dbconnect.php');

// Check if search parameters are provided
if (isset($_GET['from'], $_GET['to'], $_GET['date'])) {
    $from = htmlspecialchars($_GET['from']);
    $to = htmlspecialchars($_GET['to']);
    $date = htmlspecialchars($_GET['date']);

    // Query to fetch bus details
    $query = "SELECT * FROM bus WHERE departure_city = ? AND arrival_city = ? AND travel_date = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $from, $to, $date);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    die("<h2 class='text-center text-danger'>Invalid search parameters provided.</h2>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SmartBus - Search Results">
    <meta name="keywords" content="bus search, bus tickets, SmartBus">
    <title>Search Results | SmartBus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background: #f5f7fa;
        }
        .header {
            background: linear-gradient(45deg, #0197F6, #01C1F6);
            color: white;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            margin: 0;
            font-size: 3rem;
            font-weight: bold;
        }
        .header p {
            margin-top: 10px;
            font-size: 1.25rem;
        }
        .results-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }
        .table th {
            background: #0197F6;
            color: white;
            text-align: center;
        }
        .table tbody tr:hover {
            background: #f1f8ff;
            transition: background 0.3s ease;
        }
        .btn-success {
            background: #28a745;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            background: #218838;
            color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        .no-results {
            text-align: center;
            font-size: 1.5rem;
            color: #888;
        }
        .no-results a {
            margin-top: 10px;
            display: inline-block;
            padding: 10px 20px;
            background: #0197F6;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        .no-results a:hover {
            background: #017bb5;
        }
        footer {
            background: #0197F6;
            color: white;
            padding: 20px 0;
        }
        footer p {
            margin: 0;
            font-size: 0.9rem;
        }
        footer a {
            color: white;
            text-decoration: underline;
        }
        footer a:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Search Results</h1>
    <p class="lead">Find your perfect bus ride from <strong><?php echo $from; ?></strong> to <strong><?php echo $to; ?></strong> on <strong><?php echo $date; ?></strong>.</p>
</div>

<div class="results-container">
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>Bus Name</th>
                    <th>Departure City</th>
                    <th>Arrival City</th>
                    <th>Travel Date</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['bus_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['departure_city']); ?></td>
                        <td><?php echo htmlspecialchars($row['arrival_city']); ?></td>
                        <td><?php echo htmlspecialchars($row['travel_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['departure_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['arrival_time']); ?></td>
                        <td>₹<?php echo htmlspecialchars($row['price']); ?></td>
                        <td><a href="book.php?bus_id=<?php echo $row['id']; ?>" class="btn btn-success">Book Now</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-results">
            <p>No buses found for your search criteria.</p>
            <a href="home.php">Go Back</a>
        </div>
    <?php endif; ?>
</div>

<footer class="text-center">
    <p>&copy; 2025 SmartBus. All rights reserved. | <a href="#privacy">Privacy Policy</a> | <a href="#terms">Terms of Service</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
