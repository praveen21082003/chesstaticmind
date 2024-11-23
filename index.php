<?php
session_start();

if (isset($_SESSION['username'])) {
    // Your existing code that uses $_SESSION['username']
} else {
    echo "Username not set in the session.";
}

?>


<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Chess-Game</title>
    <meta charset="UTF-8">
    <meta name="description" content="Chess-Game">
    <meta name="keywords" content="chess,gaming, magazine, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link href="./img/s.png" rel="shortcut icon"/>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/slicknav.min.css"/>
    <link rel="stylesheet" href="css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="css/magnific-popup.css"/>
    <link rel="stylesheet" href="css/animate.css"/>
    <style>
        /* Your existing styles */
		body{
			min-width: 100vh;
			background-image: url("images/back.jpg");
			background-size: cover;
		}
		.cs{
			font-size: 24px;
			/* Add any other styles you want */
		}
		.site-logo {
			float: left;
			display: flex;
			align-items: center;
			justify-content: center;	  
		}

		.site-logo img {
			width: 80px;
			
		}

		.site-logo img {
					width: 80px; /* Adjust the width of the logo as needed */
			}
	.main-menu li.menu-item-has-children {
    	position: relative;
	}
	.sub-menu {
		display: none;
		position: absolute;
		background: #08162461;
		top: 100%;
		left: 0;
		z-index: 1;
		background-color: #f1c3c322; /* Background color for the submenu */
		box-shadow: 0 0 10px rgba(212, 182, 182, 0.048); /* Box shadow for the submenu */
	}

	.main-menu li.menu-item-has-children:hover .sub-menu {
		display: block;
	}

	.sub-menu li {
		padding: 5px;
	}
	.ul.sub-menu{
		color: rgba(0, 0, 0, 0.073);
		background: #f1c3c322;
		padding: 20px 0px;
	}
	.profile-container {
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
		height: 70vh; /* Adjust the height as needed */
		color: #fff; /* Text color for profile information */
		background-color: #0a0101b5;/* Semi-transparent dark background */
		box-shadow: 0 0 20px rgba(191, 172, 172, 0.386); /* Light-dark shadow */
		position: fixed;
		top: 200px; /* Adjust the distance from the top */
		left: 20px; /* Adjust the distance from the left */
		padding: 50px; /* Adjust padding as needed */
	}
        .profile-container img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 30px;
        }

        .complete-profile-btn {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 20px;
        }

        .complete-profile-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
	<header class="header-section">
		<div class="header-warp">
			<div class="header-social d-flex justify-content-end">
				<p>Follow us:</p>
				<a href="#"><i class="fa fa-pinterest"></i></a>
				<a href="#"><i class="fa fa-facebook"></i></a>
				<a href="#"><i class="fa fa-twitter"></i></a>
				<a href="#"><i class="fa fa-dribbble"></i></a>
				<a href="#"><i class="fa fa-behance"></i></a>
			</div>
			<div class="header-bar-warp d-flex">
				<!-- site logo -->
				<div href="index.php" class="site-logo">
					<img src="./img/s.png" width="80">
				</div>
				<nav class="top-nav-area w-100">
					<div class="user-panel">
						<a href="login.php">Login</a> / <a href="register.php">Register</a> 
					</div>
					
					<!-- Menu -->
					<ul class="main-menu primary-menu">
						<li><a href="">Home</a></li>
						<li><a href="play.php">Play</a></li>
						<li><a href="learn.html">Learn</a></li>
						<li><a href="about.html">About</a></li>
						<li class="menu-item-has-children">
        				<a href="#">Watch</a>
        					<ul class="sub-menu">
            					<li><a href="tournaments.html">Watch Tournaments</a></li>
            					<li><a href="improve-skills.html">Game Learning</a></li>
        					</ul>
   				 		</li>
						<li><a href="contact.html">Contact</a></li>
						<li><a href="review.html">Reviews</a></li>
					</ul>
				</nav>
				<div class="profile-container">
					<?php if (isset($_SESSION['username'])): ?>
						<!-- User is logged in -->
						<img src="./images/OIP.jpeg" alt="User Image">
						<h3>Welcome! <?php echo htmlspecialchars($_SESSION['username'])?></h3>
						<p>Add more details or actions here...</p>
						<a href="view_profile.php" class="complete-profile-btn">View Profile</a>
					<?php else: ?>
						<!-- User is not logged in -->
						<p>Please log in to view your profile.</p>
						<a href="login.php">Log In</a>
					<?php endif; ?>
				</div>

			</div>
    <!-- Your existing HTML content -->
	</header>

    <!--====== Javascripts & Jquery ======-->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.slicknav.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.sticky-sidebar.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/main.js"></script><!-- ... (your existing JavaScript imports) ... -->
</body>
</html>
