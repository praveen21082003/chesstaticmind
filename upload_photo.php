<?php
session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Directory where uploaded images will be saved
$uploadDirectory = 'uploads/';

// Full path to the uploaded file on the server
$uploadFilePath = $uploadDirectory . basename($_FILES['new_profile_image']['name']);

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the file is an image
    $imageFileType = strtolower(pathinfo($uploadFilePath, PATHINFO_EXTENSION));
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
    if (in_array($imageFileType, $allowedExtensions)) {
        // Move the uploaded file to the desired location
        $target_directory = 'uploads/';
        $target_file = $target_directory . basename($_FILES['new_profile_image']['name']);

        if (move_uploaded_file($_FILES['new_profile_image']['tmp_name'], $uploadFilePath)) {
            // Update the user's profile image path in the database
            $host = 'localhost';
            $dbUsername = 'root'; // Replace with your database username
            $dbPassword = '';     // Replace with your database password
            $database = 'chesstacticmind'; // Replace with your database name

            $conn = new mysqli($host, $dbUsername, $dbPassword, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $username = $_SESSION['username'];
            $updateQuery = $conn->prepare("UPDATE users SET profile_image = ? WHERE username = ?");
            $updateQuery->bind_param("ss", $uploadFilePath, $username);

            if ($updateQuery->execute()) {
                echo "Profile image uploaded successfully.";
            } else {
                echo "Failed to update profile image path in the database.";
            }

            $updateQuery->close();
            $conn->close();
        } else {
            echo "Failed to upload the file.";
        }
    } else {
        echo "Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.";
    }
} else {
    echo "Invalid request.";
}
?>
