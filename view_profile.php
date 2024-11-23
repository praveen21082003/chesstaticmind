<?php
session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user details from the database
$host = 'localhost';
$dbUsername = 'root'; // Replace with your database username
$dbPassword = '';     // Replace with your database password
$database = 'chesstaticmind'; // Replace with your database name

$conn = new mysqli($host, $dbUsername, $dbPassword, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];
$query = $conn->prepare("SELECT email, game_id, profile_image FROM users WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();
$userDetails = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 50%;
        }

        h3 {
            margin-top: 20px;
            color: #333;
        }

        p {
            margin-top: 20px;
            color: #333;
        }

        .logout-btn {
            display: block;
            margin-top: 10px;
            padding: 10px 10px;
            background-color: #333;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-photo-btn {
            display: block;
            margin-top: 0px;
            padding: 5px 8px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            top: 10%;
        }

        #upload-form {
            display: none;
            margin-top: 20px;
        }

        #upload-form input {
            margin-bottom: 10px;
        }
        .profile-container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 70vh; /* Adjust the height as needed */
            color: #fff; /* Text color for profile information */
            background: #b1b2b461;/* Semi-transparent dark background */
            box-shadow: 0 0 20px rgba(191, 172, 172, 0.386); /* Light-dark shadow */
            position: fixed;
            top: 50px; /* Adjust the distance from the top */
            left: 500px; /* Adjust the distance from the left */
            padding: 50px; /* Adjust padding as needed */
        }
        .profile-container img {
            width: 200px;
            height: 500px;
            border-radius: 5%;
            margin-bottom: 10px;
        }

        .complete-profile-btn {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
            padding: 5px 15px;
            border: none;
            border-radius: 4px;
            font-size: 20px;
        }

        .complete-profile-btn:hover {
            background-color: #45a049;
        }
        .profile-container img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 30px;
        }
        .a{
            padding: 5px;
        }

    </style>
</head>
<body>
    <div class="profile-container">
        <img src="./images/OIP.jpeg" alt="User Image">
        <img src="<?php echo isset($userDetails['profile_image']) ? htmlspecialchars($userDetails['profile_image']) : 'images/OIP.jpeg'; ?>" alt="User Image">
        <a href="#" class="edit-photo-btn" onclick="showUploadForm()">Edit Photo</a>
        <h3>Welcome, <?php echo htmlspecialchars($_SESSION['username'])?></h3>
        <p>Username: <?php echo htmlspecialchars($_SESSION['username'])?></p>
        <p>Email: <?php echo htmlspecialchars($userDetails['email'])?></p>
        <p>Game ID: <?php echo htmlspecialchars($userDetails['game_id'])?></p>
        <a href="index.php" class="a"> Back to Home....>></a>
        <a href="logout.php" class="complete-profile-btn">Logout</a>
        <!-- Edit Photo Form -->
        <form id="upload-form" action="upload_photo.php" method="post" enctype="multipart/form-data">
            <input type="file" name="new_profile_image" accept="image/png, image/jpeg" required>
            <input type="submit" value="Upload">
        </form>
    </div>

    <script>
        function showUploadForm() {
            var uploadForm = document.getElementById('upload-form');
            uploadForm.style.display = 'block';
        }
    </script>
</body>
</html>
