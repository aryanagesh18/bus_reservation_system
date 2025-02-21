<?php
session_start();
include('dbconnect.php');

if (isset($_GET['bus_id'], $_GET['date'])) {
    $bus_id = $_GET['bus_id'];
    $date = $_GET['date'];

    // Fetch bus details
    $bus_query = "SELECT * FROM bus WHERE id = ?";
    $bus_stmt = $conn->prepare($bus_query);
    $bus_stmt->bind_param("i", $bus_id);
    $bus_stmt->execute();
    $bus_result = $bus_stmt->get_result();
    $bus = $bus_result->fetch_assoc();

    // Fetch booked seats
    $booked_query = "SELECT seat_number FROM bookings WHERE bus_id = ? AND travel_date = ?";
    $booked_stmt = $conn->prepare($booked_query);
    $booked_stmt->bind_param("is", $bus_id, $date);
    $booked_stmt->execute();
    $booked_result = $booked_stmt->get_result();
    $booked_seats = [];
    while ($row = $booked_result->fetch_assoc()) {
        $booked_seats[] = $row['seat_number'];
    }

    // Fetch reserved seats for women and senior citizens
    $reserved_query = "SELECT seat_number, category FROM reserved_seats WHERE bus_id = ? AND travel_date = ?";
    $reserved_stmt = $conn->prepare($reserved_query);
    $reserved_stmt->bind_param("is", $bus_id, $date);
    $reserved_stmt->execute();
    $reserved_result = $reserved_stmt->get_result();
    $reserved_seats = [];
    while ($row = $reserved_result->fetch_assoc()) {
        $reserved_seats[$row['seat_number']] = $row['category'];
    }
} else {
    die("Invalid parameters.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Selection | SmartBus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .seat-map {
            display: grid;
            grid-template-columns: repeat(8, 1fr); /* 8 seats per row */
            gap: 15px;
            max-width: 680px;
            margin: 0 auto;
        }
        .seat-container {
            text-align: center;
            padding: 5px;
        }
        .seat {
            width: 60px;
            height: 60px;
            background-color: #eee;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-size: 12px;
            transition: background-color 0.3s;
        }
        .seat i {
            font-size: 20px;
            margin-bottom: 5px;
        }
        .seat:hover {
            background-color: #3e8e41; /* Dark Green on hover */
        }
        .seat.booked {
            background-color: #ff6b6b;
            cursor: not-allowed;
        }
        .seat.selected {
            background-color: #28a745;
        }
        .seat.window {
            background-color: #c0d9af;
        }
        .seat.window:hover {
            background-color: #3e8e41;
        }
        .seat.reserved-women {
            background-color: #f0ad4e; /* Reserved for Women */
        }
        .seat.reserved-senior {
            background-color: #f1c40f; /* Reserved for Senior Citizens */
        }
        .legend {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }
        .legend-box {
            width: 20px;
            height: 20px;
            margin-right: 5px;
            border-radius: 5px;
        }
        #confirmButton {
            display: block;
            margin: 20px auto;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Seat Selection for <?php echo $bus['bus_name']; ?></h1>
    <p>Date: <?php echo $date; ?></p>

    <div class="seat-map">
        <?php 
        $rows = [
            [1, 2, 3, 4, 5, 6, 7, 8],
            [9, 10, 11, 12, 13, 14, 15, 16],
            [17, 18, 19, 20, 21, 22, 23, 24],
            [25, 26, 27, 28, 29, 30, 31, 32]
        ];

        foreach ($rows as $row) {
            foreach ($row as $i) {
                $isBooked = in_array($i, $booked_seats);
                $isReserved = isset($reserved_seats[$i]);
                $reservedCategory = $isReserved ? $reserved_seats[$i] : null;
                $isWindow = ($i >= 1 && $i <= 8) || ($i >= 25 && $i <= 32);
        ?>
            <div class="seat-container">
                <button class="seat 
                    <?php echo $isBooked ? 'booked' : ''; ?> 
                    <?php echo $isReserved ? 'reserved-' . strtolower($reservedCategory) : ''; ?>
                    <?php echo $isWindow ? 'window' : ''; ?>"
                    <?php echo $isBooked ? 'disabled' : ''; ?>
                    data-seat="<?php echo $i; ?>">
                    <i class="fas fa-couch"></i> <span><?php echo $i; ?></span>
                </button>
            </div>
        <?php }} ?>
    </div>

    <div class="legend">
        <div class="legend-item"><div class="legend-box" style="background-color: #eee;"></div> Available</div>
        <div class="legend-item"><div class="legend-box" style="background-color: #ff6b6b;"></div> Booked</div>
        <div class="legend-item"><div class="legend-box" style="background-color: #f0ad4e;"></div> Reserved (Women)</div>
        <div class="legend-item"><div class="legend-box" style="background-color: #f1c40f;"></div> Reserved (Senior Citizens)</div>
        <div class="legend-item"><div class="legend-box" style="background-color: #c0d9af;"></div> Window</div>
    </div>

    <form id="bookingForm" action="process_booking.php" method="post">
        <input type="hidden" name="bus_id" value="<?php echo $bus_id; ?>">
        <input type="hidden" name="date" value="<?php echo $date; ?>">
        <input type="hidden" name="selected_seats" id="selectedSeats" value="">
    </form>
    <button type="button" id="confirmButton" class="btn btn-success" disabled>Confirm Booking</button>
</div>

<script>
    const seats = document.querySelectorAll('.seat');
    const selectedSeats = [];
    const selectedSeatsInput = document.getElementById('selectedSeats');
    const confirmButton = document.getElementById('confirmButton');

    seats.forEach(seat => {
        seat.addEventListener('click', () => {
            if (!seat.classList.contains('booked')) {
                seat.classList.toggle('selected');
                const seatNumber = seat.dataset.seat;
                seat.classList.contains('selected') ? selectedSeats.push(seatNumber) : selectedSeats.splice(selectedSeats.indexOf(seatNumber), 1);
                selectedSeatsInput.value = JSON.stringify(selectedSeats);
                confirmButton.disabled = selectedSeats.length === 0;
            }
        });
    });

    confirmButton.addEventListener('click', () => document.getElementById('bookingForm').submit());
</script>

</body>
</html>
