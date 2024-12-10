<?php
session_start(); // Start the session

$servername = "ChloesTravelProject";
$username = "root";
$password = "";
$dbname = "travel_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the limit and offset from the AJAX request
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 6;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

// Query to get animals with pagination
$sql = "SELECT * FROM Animals ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Check if any animals were returned
if ($result->num_rows > 0) {
    // Output each animal as a card
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4">';
        echo '<div class="animal-card">';
        echo '<img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['name']) . '">';
        echo '<h5>' . htmlspecialchars($row['name']) . '</h5>';
        echo '<p><strong>Species:</strong> ' . htmlspecialchars($row['species']) . '</p>';
        echo '<p><strong>Habitat:</strong> ' . htmlspecialchars($row['habitat']) . '</p>';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p>No more animals to display.</p>';
}

$conn->close();
?>