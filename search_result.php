<?php
// Include database connection
include('dbconnect.php');

// ... (search parameters and query - no changes needed) ...
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
    <title>Search Results | SmartBus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background: #f5f7fa;
        }
        /* ... (other styles) ... */

        .bus-card {
            border: none;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            background: #fff;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            overflow: hidden;
            display: flex; /* Use flexbox for layout */
            flex-direction: column; /* Stack elements vertically */
            height: 100%; /* Make cards equal height */
        }

        .bus-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .bus-card img {
            max-width: 150px;
            height: auto;
            margin-right: 20px;
            border-radius: 10px;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .bus-card:hover img {
            transform: scale(1.05);
        }

        .bus-details {
            flex-grow: 1; /* Allow details to take up remaining space */
        }

        .bus-card h4 {
            color: #007bff;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .bus-card p {
            color: #6c757d;
            margin-bottom: 10px;
        }

        .bus-card .btn-success {
            margin-top: auto; /* Push button to the bottom */
            margin-left: auto;
            background: #28a745;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-weight: 500;
            transition: background-color 0.2s ease-in-out, box-shadow 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .bus-card .btn-success:hover {
            background-color: #218838;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        }

        .no-results {
            text-align: center;
            font-size: 1.5rem;
            color: #888;
            margin-top: 30px;
        }
        .bus-card-container {
            perspective: 1000px;
        }

        .bus-card {
            transition: transform 0.5s ease;
            transform-style: preserve-3d;
        }

        .bus-card:hover {
            transform: rotateY(5deg);
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
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 bus-card-container">
                    <div class="bus-card">
                        <img src="<?php echo $row['bus_image']; ?>" alt="Bus Image" class="img-fluid">
                        <div class="bus-details">
                            <h4><?php echo htmlspecialchars($row['bus_name']); ?></h4>
                            <p><i class="fas fa-clock"></i> Departure: <?php echo htmlspecialchars($row['departure_time']); ?></p>
                            <p><i class="fas fa-clock"></i> Arrival: <?php echo htmlspecialchars($row['arrival_time']); ?></p>
                            <p><i class="fas fa-map-marker-alt"></i> From: <?php echo htmlspecialchars($row['departure_city']); ?></p>
                            <p><i class="fas fa-map-marker-alt"></i> To: <?php echo htmlspecialchars($row['arrival_city']); ?></p>
                            <p><i class="fas fa-calendar-alt"></i> Date: <?php echo htmlspecialchars($row['travel_date']); ?></p>
                            <p><i class="fas fa-money-bill-wave"></i> Price: ₹<?php echo htmlspecialchars($row['price']); ?></p>
                            <a href="seat_selection.php?bus_id=<?php echo $row['id']; ?>&date=<?php echo $date; ?>" class="btn btn-success mt-auto"><i class="fas fa-check"></i> Select Seats</a>


                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
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
