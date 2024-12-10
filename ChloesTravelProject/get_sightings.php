<?php
// Database connection
$servername = "ChloesTravelProject";
$username = "root";
$password = "";
$dbname = "travel_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected animal from the AJAX request
$selected_animal = isset($_GET['animal']) ? $conn->real_escape_string($_GET['animal']) : "";

// Modify the query based on the selected animal
$sql = "SELECT s.sighting_id, a.name AS animal_name, d.name AS destination_name, s.sighting_date, s.notes
        FROM Animal_Sightings s
        JOIN Animals a ON s.animal_id = a.animal_id
        JOIN Destinations d ON s.destination_id = d.destination_id";

if (!empty($selected_animal)) {
    $sql .= " WHERE a.name = '$selected_animal'";
}

$sql .= " ORDER BY s.sighting_date DESC";

$result = $conn->query($sql);

$sightings = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sightings[] = $row;
    }
}

// Return data as JSON
echo json_encode($sightings);

$conn->close();
?>