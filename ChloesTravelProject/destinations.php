<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations</title>

    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="style/nav_footer.css">
    <style>
        /* Basic styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .filter-form {
            margin-bottom: 20px;
        }

        .filter-form select,
        .filter-form button {
            padding: 10px;
            margin-right: 10px;
        }

        .destinations-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .destination-card {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .destination-card img {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }

        .destination-card h3 {
            margin: 10px 0 5px;
        }

        .destination-card p {
            margin: 5px 0;
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
                <a href="animal_sightings.php" class="active">Animal sighting</a>
                <a href="reviews.php">Reviews</a>
                <a href="login_signup.php">Login</a>
            </div>
        </div>
    </div>
</header>

<body>


    <div class="container">
        <h1>Destinations</h1>

        <!-- Filter Form -->
        <div class="filter-form">
            <select id="countryFilter">
                <option value="">Select Country</option>
                <option value="Chile">Chile</option>
                <option value="South Africa">South Africa</option>
                <option value="Vietnam">Vietnam</option>
                <option value="Turkey">Turkey</option>
                <option value="Croatia">Croatia</option>
                <option value="Norway">Norway</option>
                <option value="Namibia">Namibia</option>
                <option value="France">France</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Jordan">Jordan</option>
                <option value="Philippines">Philippines</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Italy">Italy</option>
                <option value="Peru/Bolivia">Peru/Bolivia</option>
                <option value="Czech Republic">Czech Republic</option>
                <option value="Iceland">Iceland</option>
                <option value="Egypt">Egypt</option>
            </select>
            <button id="filterButton">Filter</button>
        </div>

        <!-- Destinations List -->
        <div class="destinations-list" id="destinationsList">
            <!-- Destination  will be dynamically inserted here -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            // Function to fetch and display destinations
            function fetchDestinations(country = '') {
                $.ajax({
                    url: 'get_destinations.php',
                    type: 'GET',
                    data: { country: country },
                    success: function (data) {
                        displayDestinations(data); // Display fetched destinations
                    },
                    error: function (xhr, status, error) {
                        alert('Error loading destinations: ' + error);
                    }
                });
            }

            // Display the fetched destinations
            function displayDestinations(destinations) {
                const destinationsList = $('#destinationsList');
                destinationsList.empty(); // Clear existing destinations list

                if (destinations.length === 0) {
                    destinationsList.append('<p>No destinations found for this country.</p>');
                    return;
                }

                destinations.forEach(destination => {
                    destinationsList.append(`
                    <div class="destination-card">
                        <h3>${destination.name}</h3>
                        <p><strong>Country:</strong> ${destination.country}</p>
                        <p>${destination.description}</p>
                        ${destination.image_url ? `<img src="${destination.image_url}" alt="Destination Image">` : ''}
                        <p><strong>Added on:</strong> ${new Date(destination.created_at).toLocaleString()}</p>
                    </div>
                `);
                });
            }

            // Filter destinations
            $('#filterButton').click(function () {
                const country = $('#countryFilter').val();
                fetchDestinations(country); // Fetch and display filtered results
            });

            // Initial load to show all destinations
            fetchDestinations();
        });
    </script>
    <!-- Footer -->
    <footer>
        <p>© 2024 Chloe's Travel Project | Made with ❤️</p>
    </footer>
</body>

</html>