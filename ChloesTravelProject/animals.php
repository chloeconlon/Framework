<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animals Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="style/nav_footer.css">



    <style>
        /* Add custom styles for animals page */
        .animal-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin: 15px;
            width: 18rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .animal-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }

        .animal-card h5 {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
        }

        .animal-card p {
            font-size: 14px;
            color: #666;
        }

        .animal-card:hover {
            transform: scale(1.05);
        }

        #loadMoreBtn {
            margin: 20px;
            background-color: #8fbc8f;
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
                <a href="animals.php" class="active"> Animals</a>
                <a href="animal_sightings.php">Animal Sightings</a>
                <a href="reviews.php">Reviews</a>
                <a href="login_signup.php">Login</a>
            </div>
        </div>
    </div>
</header>

<body>

    <div class="container">
        <h1 class="text-center my-4">Chloe's Animal Encyclopedia</h1>
        <div class="row" id="animal-list"></div> <!-- Where the diff animals will be shown -->
        <div class="text-center">
            <button id="loadMoreBtn" class="btn btn-primary">Load More Animals</button>
        </div>
    </div>

    <!--  jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            let limit = 6; // Number of animals to load per request
            let offset = 0; //

            //  load animals 
            function loadAnimals() {
                $.ajax({
                    url: 'load_animals.php', // loading our animals 
                    type: 'GET',
                    data: { limit: limit, offset: offset },
                    success: function (data) {
                        $('#animal-list').append(data); // Addnew animals to the list
                        offset += limit; // Increase the offset for the next load
                    }
                });
            }


            loadAnimals();

            // Load more animals :)
            $('#loadMoreBtn').click(function () {
                loadAnimals();
            });
        });
    </script>
    <!-- Footer -->
    <footer>
        <p>© 2024 Chloe's Travel Project | Made with ❤️</p>
    </footer>

</body>

</html>