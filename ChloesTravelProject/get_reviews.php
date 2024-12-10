<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "travel_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$destination_id = isset($_GET['destination_id']) ? $_GET['destination_id'] : null;

// SQL query to fetch reviews
$sql = "SELECT review_id, user_id, destination_id, rating, comment, created_at FROM Reviews WHERE 1";

// Filter by destination if provided
if ($destination_id) {
    $sql .= " AND destination_id = ?";
}

$stmt = $conn->prepare($sql);

if ($destination_id) {
    $stmt->bind_param("i", $destination_id);
}

$stmt->execute();
$result = $stmt->get_result();

$reviews = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($reviews);

$stmt->close();
$conn->close();
?>