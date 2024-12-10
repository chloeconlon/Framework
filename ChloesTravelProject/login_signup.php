<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Signup</title>

    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f8f0;
            /* Light sage green for the background */
        }

        /* Navbar */
        .navbar {
            background-color: #8fbc8f;
            /* Sage Green */
            padding: 15px 30px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            border-radius: 0 0 15px 15px;
        }

        .navbar-right a {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            padding: 8px 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .navbar-right a:hover {
            background-color: #6c9e6c;
            /* Darker sage green on hover */
        }

        .navbar-right a.active {
            background-color: #6c9e6c;
        }

        /* Form Container */
        .container {
            background-color: white;
            padding: 30px 20px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            width: 350px;
            border-radius: 15px;
            text-align: center;
            margin-top: 80px;
            /* To compensate for the navbar height */
        }

        /* Form Heading */
        .container h2 {
            margin: 0 0 20px;
            color: #4f784f;
            /* Dark sage green */
            font-size: 1.8rem;
        }

        /* Input Fields */
        .container input[type="text"],
        .container input[type="email"],
        .container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        /* Buttons */
        .container .button {
            width: 100%;
            padding: 12px;
            background-color: #8fbc8f;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .container .button:hover {
            background-color: #6c9e6c;
            transform: scale(1.02);
        }

        /* Message */
        .message {
            text-align: center;
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        /* Toggle Links */
        .toggle {
            margin-top: 15px;
        }

        .toggle a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .toggle a:hover {
            color: #2f6f2f;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .container {
                width: 90%;
                /* Make the form container flexible on smaller screens */
            }

            .navbar {
                padding: 10px 20px;
            }

            .navbar-right a {
                font-size: 1rem;
                padding: 6px 12px;
            }
        }
    </style>
    <header>
        <!-- Navbar -->
        <div class="navbar">
            <div class="navbar-container">
                <!-- Navbar links -->
                <div class="navbar-right">
                    <a href="index.html">Home</a>
                    <a href="animals.php"> Animals</a>
                    <a href="animal_sightings.php">Animal Sightings</a>
                    <a href="reviews.php">Reviews</a>
                    <a href="login_signup.php " class="active">Login</a>
                </div>
            </div>
        </div>
    </header>
    <link rel="stylesheet" href="style/styles.css">


</head>

<body>


    <div class="container" id="form-container">
        <h2>Login</h2>
        <form id="login-form">
            <input type="email" id="login-email" placeholder="Email" required>
            <input type="password" id="login-password" placeholder="Password" required>
            <button type="submit" class="button">Login</button>
        </form>
        <div class="toggle">
            <p>Don't have an account? <a href="#" id="toggle-to-signup">Sign up</a></p>
        </div>
        <div class="message" id="login-message"></div>
    </div>

    <div class="container" id="signup-container" style="display: none;">
        <h2>Sign Up</h2>
        <form id="signup-form">
            <input type="text" id="signup-username" placeholder="Username" required>
            <input type="email" id="signup-email" placeholder="Email" required>
            <input type="password" id="signup-password" placeholder="Password" required>
            <button type="submit" class="button">Sign Up</button>
        </form>
        <div class="toggle">
            <p>Already have an account? <a href="#" id="toggle-to-login">Login</a></p>
        </div>
        <div class="message" id="signup-message"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Toggle between login and signup forms
        $('#toggle-to-signup').click(function () {
            $('#form-container').hide();
            $('#signup-container').show();
        });

        $('#toggle-to-login').click(function () {
            $('#signup-container').hide();
            $('#form-container').show();
        });

        // Handle login form submission
        $('#login-form').submit(function (event) {
            event.preventDefault();
            const email = $('#login-email').val();
            const password = $('#login-password').val();

            $.ajax({
                url: 'login.php',
                type: 'POST',
                data: { email: email, password: password },
                success: function (response) {
                    if (response === 'Success') {
                        window.location.href = 'index.html'; // Redirect to dashboard
                    } else {
                        $('#login-message').text(response); // Show error message
                    }
                },
                error: function (xhr, status, error) {
                    $('#login-message').text('Error: ' + error);
                }
            });
        });

        // Handle signup form submission
        $('#signup-form').submit(function (event) {
            event.preventDefault();
            const username = $('#signup-username').val();
            const email = $('#signup-email').val();
            const password = $('#signup-password').val();

            $.ajax({
                url: 'signup.php',
                type: 'POST',
                data: { username: username, email: email, password: password },
                success: function (response) {
                    if (response === 'Success') {
                        alert('Signup successful, you can now login!');
                        $('#toggle-to-login').click();
                    } else {
                        $('#signup-message').text(response); // Show error message
                    }
                },
                error: function (xhr, status, error) {
                    $('#signup-message').text('Error: ' + error);
                }
            });
        });
    </script>
    <!-- Footer -->
    <footer>
        <p>© 2024 Chloe's Travel Project | Made with ❤️</p>
    </footer>
</body>

</html>