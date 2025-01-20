<?php
// Include database connection
include 'dbconnect.php';

// Handle signup form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = md5($_POST['password']); // Hash password using MD5

    // Validate inputs
    if (empty($name) || empty($phone) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Prepare SQL query to insert new user
        $stmt = $conn->prepare("INSERT INTO user_table (name, phone, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $phone, $password);

        if ($stmt->execute()) {
            $success = "Signup successful! You can now <a href='login.php'>login</a>.";
        } else {
            $error = "Error: " . $stmt->error;
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
    <title>Signup</title>
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
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            width: 260px;
            text-align: center;
            color: white;
        }

        .container .logo {
            margin-bottom: 10px;
        }

        .container .logo img {
            width: 60px;
            border-radius: 50%;
        }

        .container h1 {
            font-size: 1.5em;
            margin-bottom: 5px;
            color: #f8f9fa;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.9em;
        }

        button {
            width: 50%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        button:hover {
            background: #0056b3;
        }

        p {
            margin-top: 10px;
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
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .success-message {
            color: #28a745;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo section -->
        <div class="logo">
            <img src="https://r2.erweima.ai/imgcompressed/img/compressed_7a5a399b571944cc6baaae053c5277cb.webp" alt="SmartBus Logo">
        </div>

        <h1>Signup</h1>

        <?php if (!empty($error)) : ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php elseif (!empty($success)) : ?>
            <p class="success-message"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Signup</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
