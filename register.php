
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Generate a unique game id
    $gameId = uniqid("game_id_");

    // Connect to the MySQL database
    $host = 'localhost';
    $dbUsername = 'root'; // Replace with your database username
    $dbPassword = '';     // Replace with your database password
    $database = 'chesstaticmind'; // Replace with your database name

    $conn = new mysqli($host, $dbUsername, $dbPassword, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the username or email already exists in the database
    $checkQuery = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $checkQuery->bind_param("ss", $username, $email);
    $checkQuery->execute();
    $result = $checkQuery->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        echo "Username or email already exists. Please choose another.";
    } else {
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        $insertQuery = $conn->prepare("INSERT INTO users (username, email, password, game_id) VALUES (?, ?, ?, ?)");
        $insertQuery->bind_param("ssss", $username, $email, $hashedPassword, $gameId);

        if ($insertQuery->execute()) {
            echo "Registration successful. Welcome, $username!";
            header("Location: login.php"); // Redirect to the login page after successful registration
            exit();
        } else {
            echo "Failed to register. Please try again.";
        }
    }

    $checkQuery->close();
    $insertQuery->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha384-jZ5l5r02JqXXfPAFSBdnRMbLcdsHRoK5FCRdxvDM06pVi2TfN5C5CT9AiUkN0nTT" crossorigin="anonymous">

    <title>Registration</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #5e5353;
            margin: 0;
            padding: 0;
        }
        .tabs {
            display: flex;
            position: relative;
            top: -25px;
            justify-content: center;
            color: rgb(73, 71, 71);
            height: 25px;
        }


        h2 {
            text-align: center;
            color: rgb(73, 71, 71);
            margin: 15px 0;
        }

        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            margin: 15px auto;
        }
        .value {
            text-align: center;
        }

        input[type="submit"]:hover {
            background-color: rgba(0, 81, 255, 0.781);
        }

        input[value="register"]:hover {
            text-align: center;
            padding: 20px 20px;
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

        .reg-tab,
        .login-tab {
            width: 50%;
            text-align: center;
            padding-bottom: 15px;
            margin: auto 25px;
            cursor: pointer;
        }

        .reg-tab:hover,
        .login-tab:hover {
            color: rgb(10, 51, 98);
            border-bottom: 4px solid rgb(10, 51, 98);
        }

        .active {
            color: rgb(10, 51, 98);
            border-bottom: 4px solid rgb(10, 51, 98);
        }

        #login-form {
            display: block;
            padding-top: 25px;
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
        
        .reg-tab:hover,
        
        .active {
            color: rgb(255 255 255);
            border-bottom: 4px solid rgb(93 147 209);
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
        @media (max-width: 768px) {
            #account {
                width: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <i id="account" class="fas fa-users">
            <img src="./images/black-knight.png" alt="User Image">
        </i>
        <div class="tabs">
            <h2 class="login-tab active">Registration</h2>
        </div>
        <form method="post" action="register.php">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
            <button class="login">
                Register
            </button>
        </form>
    </div>
</body>
</html>

