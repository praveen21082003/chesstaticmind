<?php
session_start();

// Establish a database connection (replace these with your actual database credentials)
$host = "localhost";
$username = "root";
$password = "";
$database = "chesstaticmind";

$con = new mysqli($host, $username, $password, $database);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT username, password FROM users WHERE username='$username'";
    $result = $con->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            header("Location: index.php "); // Redirect to the customer dashboard
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid username.";
    }

    $con->close();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <!-- Styles -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #5e5353;
            margin: 0;
            padding: 0;
        }
        .body {
            min-width: 100vh;
            background-image: url("C:\Users\HP\Downloads\endgame-master\endgame-master\img\games\w6Q5CUU.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-size: cover;
            padding: 0;
            margin: 0;
            height: 100vh;
            width: 100vw;
            min-height: 600px;
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .tabs {
            display: flex;
            position: relative;
            top: 0px;
            justify-content: center;
            color: rgb(73, 71, 71);
            height: 60px;
        }
        

        .container {
            width: 300px;
            margin: auto;
            height: 50x;
            border-radius: 20px;
            box-shadow: 0 0 10px black;
            position: absolute;
            top: 55%;
            left: 50%;
            transform: translate(-50%, -50%);
        }


        h2 {
            text-align: center;
            color: rgb(73, 71, 71);
            margin: 15px 0;
        }

        form {
            width: 90%;
            display: flex;
            flex-direction: column;
            margin: 15px auto;
        }
        input {
            height: 27px;
            margin: 5px;
            border-radius: 15px;
            border: none;
            outline: none;
            background-color: rgb(209, 209, 209);
            padding: 5px;
            font-size: 17px;
            color: rgb(73, 73, 73);
            text-align: center;
        }

        #login-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login {
            margin-top: 15px;
            align-items: center;
        }

        input[type="submit"] {
            background-color: rgb(10, 51, 98);
            color: white;
            padding: 10px 45px;
            border-radius: 18px;
            box-shadow: 0 0 2px rgb(117, 113, 113);
            border: none;
            cursor: pointer;
            font-size: 20px;
        }

        input[type="submit"]:hover {
            background-color: rgba(0, 81, 255, 0.781);
        }
        .container {
            width: 380px;
            margin: auto;
            height: 500px;
            border-radius: 25px;
            box-shadow: 0 0 10px black;
        }
        
        #account {
            position: relative;
            font-size: 50px;
            color: #e1cfcf;
            padding: 50px;
            background: rgb(99, 140, 187);
            background: radial-gradient(circle, rgb(10, 51, 98) 54%, rgba(10, 3, 60, 0.97) 100%);
            border-radius: 10px;
            border-bottom-left-radius: 100px;
            border-bottom-right-radius: 100px;
            top: -50px;
            left: calc(50% - 74px);
            box-shadow: 0 0 5px black;
        }   
        .reg-tab,#account img {
            max-width:15%; /* Ensure the image doesn't exceed the container width */
            height: auto;
            transform: scale(1.8);    /* Maintain the image's aspect ratio */
        }
        .login-tab {
            width: 50%;
            text-align: center;
            padding-bottom: 10px;
            margin: auto 25px;
            cursor: pointer;
        }
        
        .reg-tab:hover,
        .login-tab:hover {
            color: rgb(10, 51, 98);
            border-bottom: 4px solid rgb(10, 51, 98);
        }
        
        .active {
            color:  rgb(255 255 255);
            border-bottom: 4px solid rgb(93 147 209);
        }
        
        #login-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        p {
            margin: 0;
            padding: 0;
        }
        
        .options {
            display: flex;
            align-items: center;
            margin-top: 25px;
            font-style: italic;
        }
        
        .remember {
            display: flex;
            align-items: center;
            width: 50%;
            text-align: center;
        }
        
        button {
            margin: 20px auto;
            font-size: 20px;
            background-color: rgb(10, 51, 98);
            color: white;
            padding: 10px 45px;
            border-radius: 18px;
            box-shadow: 0 0 2px rgb(117, 113, 113);
            border: none;
            cursor: pointer;
        }
        
        button:hover {
            background-color: rgba(0, 81, 255, 0.781);
        }
        
        .tnc {
            display: flex;
            align-items: center;
            margin: auto;
            color: rgb(54, 52, 52);
            font-style: italic;
        }

        /* making design responsive */
        
        @media screen and (max-width: 600px) {
            .container {
                width: 90%;
            }
        }
        
        @media screen and (max-width: 350px) {
            .container {
                width: 320px;
            }
        }
        @media (max-width: 768px) {
            #account {
                width: 300px;
            }
        }
        
        /* Your existing media queries for responsiveness */
    </style>
</head>

<body>
    <div class="container">
        <i id="account" class="fas fa-users">
            <img src="./images/black-knight.png" alt="User Image">
        </i>
        <div class="tabs">            
            <h2 class="login-tab active">Login</h2>            
        </div>
        <!-- login part -->
        <div id="login-form">
            <form method="post" action="login.php">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <button class="login"> Login</button>
                <a href="register.php" class="complete-profile-btn">Click to Register....>></a>
            </form>
            <!-- Container div to center the login button -->

        </div>
    </div>
</body>

</html>
