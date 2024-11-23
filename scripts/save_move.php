<?php
// Retrieve the move data from the POST request
$gameId = $_POST['game_id'];
$moveNumber = $_POST['move_number'];
$player = $_POST['player'];
$moveText = $_POST['move_text'];

// Connect to the database (replace with your own database connection code)
$mysqli = new mysqli('localhost', 'username', 'password', 'your_database_name');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Insert the move into the database
$sql = "INSERT INTO chess_moves (game_id, move_number, player, move_text) VALUES (?, ?, ?, ?)";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param('iiis', $gameId, $moveNumber, $player, $moveText);
    $stmt->execute();
    $stmt->close();
    echo 'Move saved successfully.';
} else {
    echo 'Error: ' . $mysqli->error;
}

$mysqli->close();
?>



