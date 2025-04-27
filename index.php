<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internet Banking Home</title>
    <link rel="stylesheet" href="index.css">
   <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
 <style type="text/css">
        section.search {
        max-width: 400px;
        margin: 40px auto;
        padding: 20px;
        border: 2px solid #007BFF;
        border-radius: 8px;
        background-color: #f9faff;
        font-family: Arial, sans-serif;
    }

    section.search h3 {
        text-align: center;
        color: #007BFF;
        margin-bottom: 20px;
        font-weight: 600;
    }

    section.search form {
        display: flex;
        gap: 10px;
    }

    section.search input[type="text"] {
        flex-grow: 1;
        padding: 10px 15px;
        font-size: 16px;
        border: 1.5px solid #007BFF;
        border-radius: 5px;
        outline-color: #0056b3;
        transition: border-color 0.3s ease;
    }

    section.search input[type="text"]:focus {
        border-color: #0056b3;
        box-shadow: 0 0 5px rgba(0, 91, 187, 0.5);
    }

    section.search button {
        padding: 10px 20px;
        background-color: #007BFF;
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    section.search button:hover {
        background-color: #0056b3;
    }

    section.search p {
        margin-top: 20px;
        color: #333;
        font-size: 16px;
        text-align: center;
    }

    section.search p b {
        color: #007BFF;
    }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <h1>BankApp</h1>
        </div>
        <nav>
            <ul class="nav-links">
               	<li><a href="help_contact.php">Help and Contact</a></li>
		 <li><a href="AdminLogin.php">Admin Portal</a></li>
                <li><a href="StaffLogin.php">Staff Portal</a></li>
                <li><a href="ClientLogin.php">Client Portal</a></li>
                <li><a href="Register.php" class="join-us">Join Us</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h2>Welcome to BankApp</h2>
            <p>Your one-stop solution for online banking.</p><br>
            <a href="Register.php">
            <button class="get-started">Get Started</button>
            </a>
        </section>
        
        <section class="features">
            <h3>Our Features</h3>
            <div class="feature-card">
                <h4>Secure Transactions</h4>
                <p>Your money is safe with us.</p>
            </div>
            <div class="feature-card">
                <h4>24/7 Customer Support</h4>
                <p>We're here to assist you anytime.</p>
            </div>
            <div class="feature-card">
                <h4>User-friendly Interface</h4>
                <p>Easy navigation for all users.</p>
            </div>
        </section>
        <section class="search">
            <h3>Search Our Services</h3>
            <form method="GET" action="index.php">
                <input type="text" name="query" placeholder="Search something...">
                <button type="submit">Search</button>
            </form>

            <?php
            if (isset($_GET['query'])) {
                $search = $_GET['query']; 
                echo "<p>You searched for: <b>$search</b></p>"; 
            }
            ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 BankApp. All rights reserved.</p>
    </footer>
	<script>
        
        $(document).ready(function() {
            
            var userInput = $('#search-result').text();
            $('#search-result').html(userInput);
        });
    </script>

</body>

</html>
