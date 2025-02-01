<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bus Seat Selection</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f7f6; /* Background color */
    }

    .seat-selection {
      display: flex;
      justify-content: center;
      flex-direction: column;
      align-items: center;
      padding: 40px;
      background-color: #fff;
      max-width: 1200px;
      margin: 0 auto;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    .seat-selection h1 {
      font-size: 24px;
      color: #333;
      margin-bottom: 20px;
    }

    .seat-map {
      position: relative;
      background-color: #f0f0f0;
      width: 100%;
      height: 600px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .row {
      display: flex;
      justify-content: center;
      gap: 2%; /* 2% space between seats */
      margin-bottom: 20px;
      width: 100%;
      flex-wrap: wrap;
      justify-content: center; /* Centers seats horizontally */
    }

    .seat {
      width: 50px;
      height: 50px;
      background-color: #f0f0f0;
      border-radius: 6px;
      border: 2px solid #ccc;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 10px;
      transition: all 0.3s ease;
      position: relative;
    }

    .seat.available {
      background-color: #8bc34a;
    }

    .seat.selected {
      background-color: #ffeb3b;
      border-color: #ff9800;
    }

    .seat.booked {
      background-color: #9e9e9e;
      pointer-events: none;
    }

    .seat:hover {
      transform: scale(1.1);
    }

    .seat-tooltip {
      position: absolute;
      top: -30px;
      background-color: #333;
      color: #fff;
      padding: 5px;
      font-size: 12px;
      border-radius: 3px;
      display: none;
    }

    .seat:hover .seat-tooltip {
      display: block;
    }

    .driver-seat {
      background-color: #ff5722;
      border: 2px solid #d84315;
      pointer-events: none;
      cursor: default;
      margin-left: 22.5%; /* Shift driver seat 10% to the right */
      margin-right: 3%; /* 3% space between driver seat and passenger seats */
      margin-bottom: 7px;
    }

    .sidebar {
      width: 300px;
      background-color: #fff;
      padding: 25px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      position: relative;
      z-index: 2;
      margin-top: 20px;
    }

    .sidebar h2 {
      font-size: 24px;
      color: #333;
      margin-bottom: 20px;
    }

    .sidebar p {
      font-size: 16px;
      color: #555;
    }

    .sidebar button {
      width: 100%;
      padding: 15px;
      margin-top: 20px;
      background-color: #2196f3;
      color: #fff;
      border: none;
      cursor: pointer;
      border-radius: 5px;
      font-size: 18px;
      transition: all 0.3s ease;
    }

    .sidebar button:hover {
      background-color: #1976d2;
    }

    @media (max-width: 768px) {
      .seat-selection {
        flex-direction: column;
        align-items: center;
      }

      .sidebar {
        width: 100%;
        margin-top: 20px;
      }

      .seat-map {
        width: 100%;
        height: auto;
      }

      .row {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>
<body>

  <div class="seat-selection">
    <!-- Heading -->
    <h1>Select the Seats</h1>

    <!-- Seat Map -->
    <div class="seat-map">
      <!-- Driver Seat placed at the top with 10% margin-left and 3% margin-right -->
      <div class="seat driver-seat" data-seat="Driver" data-type="Driver" data-price="0">
        <div class="seat-tooltip">Driver Seat</div>
        Driver
      </div>

      <!-- Row 1 -->
      <div class="row">
        <div class="seat available" data-seat="1A" data-type="Available" data-price="150">
          <div class="seat-tooltip">Lower Window</div>
          1A
        </div>
        <div class="seat available" data-seat="1B" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          1B
        </div>
        <div class="seat available" data-seat="1C" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          1C
        </div>
        <div class="seat available" data-seat="1D" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          1D
        </div>
      </div>

      <!-- Row 2 -->
      <div class="row">
        <div class="seat available" data-seat="2A" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          2A
        </div>
        <div class="seat available" data-seat="2B" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          2B
        </div>
        <div class="seat available" data-seat="2C" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          2C
        </div>
        <div class="seat available" data-seat="2D" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          2D
        </div>
      </div>

      <!-- Row 3 -->
      <div class="row">
        <div class="seat available" data-seat="3A" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          3A
        </div>
        <div class="seat available" data-seat="3B" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          3B
        </div>
        <div class="seat available" data-seat="3C" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          3C
        </div>
        <div class="seat available" data-seat="3D" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          3D
        </div>
      </div>

      <!-- Row 4 -->
      <div class="row">
        <div class="seat available" data-seat="4A" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          4A
        </div>
        <div class="seat available" data-seat="4B" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          4B
        </div>
        <div class="seat available" data-seat="4C" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          4C
        </div>
        <div class="seat available" data-seat="4D" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          4D
        </div>
      </div>

      <!-- Added Rows 5 to 9 for additional seats -->
      <div class="row">
        <div class="seat available" data-seat="5A" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          5A
        </div>
        <div class="seat available" data-seat="5B" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          5B
        </div>
        <div class="seat available" data-seat="5C" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          5C
        </div>
        <div class="seat available" data-seat="5D" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          5D
        </div>
      </div>
      
      <div class="row">
        <div class="seat available" data-seat="6A" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          6A
        </div>
        <div class="seat available" data-seat="6B" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          6B
        </div>
        <div class="seat available" data-seat="6C" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          6C
        </div>
        <div class="seat available" data-seat="6D" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          6D
        </div>
      </div>
      
      <div class="row">
        <div class="seat available" data-seat="7A" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          7A
        </div>
        <div class="seat available" data-seat="7B" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          7B
        </div>
        <div class="seat available" data-seat="7C" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          7C
        </div>
        <div class="seat available" data-seat="7D" data-type="Available" data-price="150">
          <div class="seat-tooltip">Available Seat</div>
          7D
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <h2>Your Selection</h2>
      <p><strong>Seats:</strong> <span id="selected-seats">None</span></p>
      <p><strong>Total Price:</strong> ₹<span id="total-price">0</span></p>
      <button id="confirm-button">Confirm Seats</button>
    </div>
  </div>

  <script>
    const seats = document.querySelectorAll('.seat');
    let selectedSeats = [];
    const maxSeats = 5;

    seats.forEach(seat => {
      seat.addEventListener('click', (event) => {
        if (!seat.classList.contains('booked') && !seat.classList.contains('driver-seat')) {
          const seatNumber = seat.getAttribute('data-seat');
          const seatType = seat.getAttribute('data-type');
          const seatPrice = parseInt(seat.getAttribute('data-price'));

          const seatIndex = selectedSeats.findIndex(seat => seat.seatNumber === seatNumber);

          if (seatIndex > -1) {
            seat.classList.remove('selected');
            selectedSeats.splice(seatIndex, 1);
          } else {
            if (selectedSeats.length >= maxSeats) {
              showMaxSeatsAlert();
              return;
            }
            seat.classList.add('selected');
            selectedSeats.push({ seatNumber, seatType, seatPrice });
          }

          updateSidebar();
        }
      });
    });

    function updateSidebar() {
      const selectedSeatsList = selectedSeats.map(seat => `${seat.seatNumber} (${seat.seatType})`).join(', ');
      document.getElementById('selected-seats').textContent = selectedSeatsList;

      const totalPrice = selectedSeats.reduce((total, seat) => total + seat.seatPrice, 0);
      document.getElementById('total-price').textContent = totalPrice;
    }

    function showMaxSeatsAlert() {
      const notification = document.createElement('div');
      notification.textContent = `You have selected the maximum number of seats (${maxSeats})!`;
      notification.style.position = 'fixed';
      notification.style.top = '20px';
      notification.style.left = '50%';
      notification.style.transform = 'translateX(-50%)';
      notification.style.padding = '10px 20px';
      notification.style.backgroundColor = '#f44336';
      notification.style.color = '#fff';
      notification.style.fontSize = '16px';
      notification.style.borderRadius = '5px';
      notification.style.zIndex = '1000';
      document.body.appendChild(notification);

      setTimeout(() => {
        notification.remove();
      }, 3000);
    }

    document.getElementById('confirm-button').addEventListener('click', () => {
      if (selectedSeats.length > 0) {
        const seatsList = selectedSeats.map(seat => `${seat.seatNumber}`);
        alert(`You have selected seats: ${seatsList.join(', ')}`);
      } else {
        alert("No seats selected.");
      }
    });
  </script>

</body>
</html>
