<?php
// Start the session
session_start();

// Include database connection
include 'dbconnect.php';

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];
    $password = md5($_POST['password']); // Hash password using MD5

    // Validate inputs
    if (empty($phone) || empty($password)) {
        $error = "Phone and password are required.";
    } else {
        // Prepare SQL query to check user credentials
        $stmt = $conn->prepare("SELECT id, name FROM user_table WHERE phone = ? AND password = ?");
        $stmt->bind_param("ss", $phone, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Login successful
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: home.php"); // Redirect to the home page
            exit();
        } else {
            $error = "Invalid phone or password.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            animation: changeBackground 20s infinite;
        }

        @keyframes changeBackground {
            5% {
                background-image: url('https://img.freepik.com/premium-photo/bus-traveling-asphalt-road-rural-landscape-sunset_933530-6596.jpg');
            }
            33% {
                background-image: url('https://images.pexels.com/photos/1178448/pexels-photo-1178448.jpeg?cs=srgb&dl=pexels-madsdonald-1178448.jpg&fm=jpg');
            }
            66% {
                background-image: url('https://c0.wallpaperflare.com/preview/568/270/339/bus-night-light-public.jpg');
            }
            100% {
                background-image: url('https://wallpapers.com/images/hd/bus-pictures-h7rlf1upkg0wxpyq.jpg');
            }
        }

        .container {
            background: rgba(0, 0, 0, 0.7);
            padding: 30px; /* Reduced padding */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            width: 260px; /* Smaller width */
            text-align: center;
            color: white;
        }

        .container .logo {
            margin-bottom: 10px; /* Reduced margin */
        }

        .container .logo img {
            width: 60px; /* Smaller logo size */
            border-radius: 50%;
        }

        .container h1 {
            font-size: 1.5em; /* Much smaller font size for login heading */
            margin-bottom: 5px; /* Reduced margin */
            color: #f8f9fa;
        }

        h2 {
            margin-bottom: 15px; /* Reduced margin */
            font-size: 1em; /* Smaller subtitle size */
            color: #f8f9fa;
        }

        input {
            width: 100%;
            padding: 10px; /* Reduced padding */
            margin: 8px 0; /* Reduced margin */
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.9em; /* Smaller input font size */
        }

        button {
            width: 50%;
            align-items: center;
            padding: 10px; /* Reduced padding */
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em; /* Smaller button font size */
        }

        button:hover {
            background: #0056b3;
        }

        p {
            margin-top: 10px; /* Reduced margin */
            color: #ddd;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #ff4c4c;
            font-size: 0.9em; /* Smaller font size for error */
            margin-bottom: 10px; /* Reduced margin */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo section -->
        <div class="logo">
            <img src="https://r2.erweima.ai/imgcompressed/img/compressed_7a5a399b571944cc6baaae053c5277cb.webp" alt="SmartBus Logo">
        </div>

        <h1>Login</h1>

        <?php if (!empty($error)) : ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="phone" placeholder="Phone" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="signup.php">Create one</a></p>
    </div>
</body>
</html>
