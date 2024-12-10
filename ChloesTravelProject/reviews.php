<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="style/nav_footer.css">

    <header>
        <!-- Navbar -->
        <div class="navbar">
            <div class="navbar-container">
                <!-- Navbar links -->
                <div class="navbar-right">
                    <a href="index.html">Home</a>
                    <a href="animals.php"> Animals</a>
                    <a href="animal_sightings.php">Animal Sightings</a>
                    <a href="reviews.php" class="active">Reviews</a>
                    <a href="login_signup.php">Login</a>
                </div>
            </div>
        </div>
    </header>


    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
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

        .review-card {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .review-card h3 {
            margin: 0;
            font-size: 1.2em;
        }

        .review-card p {
            margin: 5px 0;
        }

        .review-card .rating {
            color: gold;
        }

        .review-card small {
            display: block;
            margin-top: 5px;
            color: gray;
        }

        .add-review-form {
            margin-top: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .add-review-form input,
        .add-review-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .add-review-form button {
            padding: 10px 20px;
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }

        .add-review-form button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Reviews</h1>

        <!-- Filter Reviews by Destination -->
        <div class="filter-form">
            <select id="destinationFilter">
                <option value="">Select Destination</option>
                <!-- Populate with destination options using PHP -->
                <?php
                // Database connection
                $conn = new mysqli("localhost", "root", "", "travel_db");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Get all destinations
                $result = $conn->query("SELECT destination_id, name FROM Destinations");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['destination_id'] . "'>" . $row['name'] . "</option>";
                }
                $conn->close();
                ?>
            </select>
            <button id="filterButton">Filter</button>
        </div>

        <!-- Reviews List -->
        <div id="reviewsList">
            <!-- Reviews will be dynamically loaded here -->
        </div>

        <!-- Add Review Form -->
        <div class="add-review-form">
            <h2>Add a Review</h2>
            <select id="destination" required>
                <option value="">Select Destination</option>
                <!-- Populate with destination options using PHP -->
                <?php
                $conn = new mysqli("localhost", "root", "", "travel_db");
                $result = $conn->query("SELECT destination_id, name FROM Destinations");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['destination_id'] . "'>" . $row['name'] . "</option>";
                }
                $conn->close();
                ?>
            </select>
            <input type="number" id="rating" placeholder="Rating (1-5)" min="1" max="5" required>
            <textarea id="comment" rows="5" placeholder="Your review..." required></textarea>
            <button id="submitReview">Submit Review</button>
        </div>
    </div>

    <!-- Load jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            // Function to fetch and display reviews
            function fetchReviews(destinationId = '') {
                $.ajax({
                    url: 'get_reviews.php',
                    type: 'GET',
                    data: { destination_id: destinationId },
                    success: function (data) {
                        displayReviews(data);
                    },
                    error: function (xhr, status, error) {
                        alert('Error loading reviews: ' + error);
                    }
                });
            }

            // Display reviews in the DOM
            function displayReviews(reviews) {
                const reviewsList = $('#reviewsList');
                reviewsList.empty(); // Clear existing list

                if (reviews.length === 0) {
                    reviewsList.append('<p>No reviews found for this destination.</p>');
                    return;
                }

                reviews.forEach(review => {
                    reviewsList.append(`
                <div class="review-card">
                    <h3>User ID: ${review.user_id}</h3>
                    <p><strong>Rating:</strong> <span class="rating">${'★'.repeat(review.rating)}</span></p>
                    <p>${review.comment}</p>
                    <small>Reviewed on: ${new Date(review.created_at).toLocaleString()}</small>
                </div>
            `);
                });
            }

            // Initial load to show all reviews
            fetchReviews();

            // Filter button click event
            $('#filterButton').click(function () {
                const destinationId = $('#destinationFilter').val();
                fetchReviews(destinationId); // Fetch and display filtered results
            });

            // Submit review event
            $('#submitReview').click(function () {
                const destinationId = $('#destination').val();
                const rating = $('#rating').val();
                const comment = $('#comment').val();

                if (!destinationId || !rating || !comment) {
                    alert('Please fill out all fields.');
                    return;
                }

                $.ajax({
                    url: 'submit_review.php',  // Ensure this URL is correct
                    type: 'POST',
                    data: {
                        destination_id: destinationId,
                        rating: rating,
                        comment: comment
                    },
                    success: function (response) {
                        alert('Review submitted successfully!');
                        fetchReviews(); // Refresh the reviews list
                        // Clear the form
                        $('#destination').val('');
                        $('#rating').val('');
                        $('#comment').val('');
                    },
                    error: function (xhr, status, error) {
                        alert('Error submitting review: ' + error);
                    }
                });
            });

        });
    </script>
    <!-- Footer -->
    <footer>
        <p>© 2024 Chloe's Travel Project | Made with ❤️</p>
    </footer>

</body>

</html>