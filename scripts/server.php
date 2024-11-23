<?php

// Start session if not already started
if (!isset($_SESSION)) {
    session_start();
}

// Connect to the database
$db = new mysqli('localhost', 'root', '', 'chesstaticmind');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Retrieve FEN and game ID from AJAX request
$fen = $_POST['fen'];
$gameId = $_SESSION['gameId'];  // Assuming game ID is stored in session

// Prepare SQL statement
$sql = "INSERT INTO history (gameId, fen) VALUES (?, ?)";
$stmt = $db->prepare($sql);

// Bind parameters
$stmt->bind_param("is", $gameId, $fen);

// Execute query
if ($stmt->execute()) {
    echo "FEN data stored successfully";  // Optional success message
} else {
    echo "Error storing FEN data: " . $stmt->error;
}

// Close statement and database connection
$stmt->close();
$db->close();
?>
