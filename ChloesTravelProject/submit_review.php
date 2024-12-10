<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("ChloesTravelProject", "root", "", "travel_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$destination_id = $_POST['destination_id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

// Assuming you have a logged-in user, for example, user_id = 1
$user_id = 1;

$sql = "INSERT INTO Reviews (user_id, destination_id, rating, comment) VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiis", $user_id, $destination_id, $rating, $comment);

if ($stmt->execute()) {
    echo "Review submitted successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>