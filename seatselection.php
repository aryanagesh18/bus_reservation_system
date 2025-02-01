<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SmartBus - Payment Page">
    <meta name="keywords" content="bus booking, payment, SmartBus">
    <title>Payment | SmartBus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background: #f5f7fa;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
        }
        .bus-image {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .seats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 20px;
        }
        .seat {
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .ac-seat { background: #ffcc00; }
        .window-seat { background: #0099ff; }
        .sleeper-upper { background: #ff6666; }
        .sleeper-lower { background: #66cc66; }
        .selected {
            border: 2px solid black;
        }
        .notification {
            margin-top: 20px;
            padding: 10px;
            background: #28a745;
            color: white;
            border-radius: 5px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Select Your Seat</h2>
        <img src="3d-bus-image.jpg" alt="3D Bus" class="bus-image">
        <div class="seats">
            <div class="seat ac-seat" data-seat="AC Seat - ₹500">AC Seat</div>
            <div class="seat window-seat" data-seat="Window Seat - ₹600">Window Seat</div>
            <div class="seat sleeper-upper" data-seat="Sleeper Upper - ₹800">Sleeper Upper</div>
            <div class="seat sleeper-lower" data-seat="Sleeper Lower - ₹750">Sleeper Lower</div>
        </div>
        <div class="notification" id="notification">You selected: <span id="selected-seat"></span></div>
    </div>
    <script>
        document.querySelectorAll('.seat').forEach(seat => {
            seat.addEventListener('click', function () {
                document.querySelectorAll('.seat').forEach(s => s.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('selected-seat').innerText = this.getAttribute('data-seat');
                document.getElementById('notification').style.display = 'block';
            });
        });
    </script>
</body>
</html>
