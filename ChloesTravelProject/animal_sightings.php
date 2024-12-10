<?php
// Connect to the database
$servername = "ChloesTravelProject";
$username = "root";
$password = "";
$dbname = "travel_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the list of animals for the dropdown
$animals_sql = "SELECT DISTINCT name FROM Animals ORDER BY name ASC";
$animals_result = $conn->query($animals_sql);

$animal_options = [];
if ($animals_result->num_rows > 0) {
    while ($row = $animals_result->fetch_assoc()) {
        $animal_options[] = $row['name'];
    }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">


<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Animal Sightings</title>
<link rel="stylesheet" href="styles.css"> <!-- Include your CSS file -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for AJAX -->
<link rel="stylesheet" href="style/styles.css">
<link rel="stylesheet" href="style/nav_footer.css">

<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f8f0;
        /* Light sage green background */
        color: #333;
    }

    h1 {
        text-align: center;
        color: #4f784f;
        /* Dark sage green for headings */
        margin-bottom: 20px;
    }


    /* Main Content Container */
    .container {
        margin: 100px auto 0;
        /* Leave space for the fixed navbar */
        padding: 20px;
        background-color: white;
        border-radius: 15px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        width: 80%;
        max-width: 900px;
        text-align: center;
    }

    /* Dropdown */
    label {
        font-size: 1.2rem;
        color: #4f784f;
        /* Dark sage green for labels */
    }

    select {
        margin-top: 10px;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 1rem;
        color: #333;
        background-color: #f0f8f0;
        /* Light sage green for dropdown */
        transition: box-shadow 0.3s ease;
    }

    select:focus {
        outline: none;
        box-shadow: 0 0 5px #8fbc8f;
        /* Highlight with sage green */
    }

    /* Sightings Table */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #ffffff;
        /* White table background */
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    thead {
        background-color: #8fbc8f;
        /* Sage green for table header */
        color: white;
        font-weight: bold;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ccc;
    }

    tr:hover {
        background-color: #f0f8f0;
        /* Light sage green row hover effect */
    }

    p {
        font-size: 1rem;
        color: #666;
        margin-top: 20px;
    }

    /* Buttons */
    button {
        padding: 10px 20px;
        background-color: #8fbc8f;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    button:hover {
        background-color: #6c9e6c;
        /* Darker sage green */
        transform: scale(1.05);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            width: 90%;
        }

        table {
            font-size: 0.9rem;
        }
    }
</style>
</head>
<header>
    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-container">
            <!-- Navbar links -->
            <div class="navbar-right">
                <a href="index.html">Home</a>
                <a href="animals.php"> Animals</a>
                <a href="animal_sightings.php" class="active">Animal Sightings</a>
                <a href="reviews.php">Reviews</a>
                <a href="login_signup.php">Login</a>
            </div>
        </div>
    </div>
</header>

<body>
    <div class="container">
        <h1>Animal Sightings</h1>

        <!-- Dropdown for filtering animals -->
        <label for="animalFilter">Filter by Animal:</label>
        <select id="animalFilter">
            <option value="">All</option>
            <?php foreach ($animal_options as $animal): ?>
                <option value="<?php echo htmlspecialchars($animal); ?>"><?php echo htmlspecialchars($animal); ?></option>
            <?php endforeach; ?>
        </select>

        <div id="sightings-table">
            <!-- Table will be populated via AJAX -->
        </div>
    </div>

    <script>
        // Function to load animal sightings via AJAX
        function loadSightings(animal = "") {
            $.ajax({
                url: 'get_sightings.php',
                type: 'GET',
                data: { animal: animal }, // Send the selected animal as a parameter
                dataType: 'json',
                success: function (data) {
                    var sightingsHTML = '';

                    if (data.length > 0) {
                        sightingsHTML = '<table border="1"><thead><tr><th>Animal</th><th>Destination</th><th>Date</th><th>Notes</th></tr></thead><tbody>';

                        // Loop through the data and populate the table
                        $.each(data, function (index, sighting) {
                            sightingsHTML += '<tr>';
                            sightingsHTML += '<td>' + sighting.animal_name + '</td>';
                            sightingsHTML += '<td>' + sighting.destination_name + '</td>';
                            sightingsHTML += '<td>' + sighting.sighting_date + '</td>';
                            sightingsHTML += '<td>' + sighting.notes + '</td>';
                            sightingsHTML += '</tr>';
                        });

                        sightingsHTML += '</tbody></table>';
                    } else {
                        // Show message if no sightings are found
                        sightingsHTML = '<p>No sightings yet for this animal.</p>';
                    }

                    $('#sightings-table').html(sightingsHTML);
                },
                error: function () {
                    alert('Error loading sightings data.');
                }
            });
        }

        // Load all sightings on page load
        $(document).ready(function () {
            loadSightings();

            // Reload sightings when the dropdown changes
            $('#animalFilter').on('change', function () {
                var selectedAnimal = $(this).val();
                loadSightings(selectedAnimal);
            });
        });
    </script>
    <!-- Footer -->
    <footer>
        <p>© 2024 Chloe's Travel Project | Made with ❤️</p>
    </footer>

</body>

</html>