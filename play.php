<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "chesstaticmind";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$db_name", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT game_id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $game_id = $row['game_id'];

            // Retrieve the FEN data from the client-side (replace this with the actual way you send data from the client)
            $fen_from_client = isset($_POST['fen']) ? $_POST['fen'] : ''; // Update this based on your actual data transfer method

            // Check if $fen_from_client is not empty before inserting into the database
            if (!empty($fen_from_client)) {
                // Insert FEN data into the history table
                $history_stmt = $conn->prepare("INSERT INTO history (game_id, fen) VALUES (:game_id, :fen)");
                $history_stmt->bindParam(':game_id', $game_id);
                $history_stmt->bindParam(':fen', $fen_from_client); // Use the FEN data received from the client
                $history_stmt->execute();

                echo "Game ID and FEN stored in history table.";
            }
        } else {
            echo "User not found.";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}


 // Embed the Flask app using an iframe
 echo '<div id="analyzer" class="left" ><h1>Chess Move Analyzer</h1><iframe src="http://localhost:5000/" width="30%" height="400px"></iframe></div>';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>chess tacticmid</title>
  <link rel="stylesheet" type="text/css" href="styles/layout.css">
  <link rel="stylesheet" type="text/css" href="styles/board.css">
  <link rel="stylesheet" type="text/css" href="styles/checkLine.css">
  <link rel="stylesheet" type="text/css" href="styles/pieces.css">
  <link rel="stylesheet" type="text/css" href="styles/main-menu.css">

  <link rel="stylesheet" type="text/css" href="styles/game-alert.css">
  <link rel="stylesheet" type="text/css" href="styles/chss.css">
  <link rel="icon" href="images/black-pawn.png">
  <script defer type="text/javascript" src="scripts/sidebar.js" ></script>
  <script defer type="text/javascript" src="scripts/globalVars.js"></script>
  <script defer type="text/javascript" src="scripts/tools.js"></script>
  <script defer type="text/javascript" src="scripts/newGame.js"></script>
  <script defer type="text/javascript" src="scripts/promotion.js"></script>
  <script defer type="text/javascript" src="scripts/pieceClasses.js"></script>
  <script defer type="text/javascript" src="scripts/handDrag.js"></script>
  <script defer type="text/javascript" src="scripts/handleMoves.js"></script>
  <script defer type="text/javascript" src="scripts/rateBoardstate.js"></script>
  <script defer type="text/javascript" src="scripts/computerMove.js"></script>
  <script defer type="text/javascript" src="scripts/swapTurn.js"></script>
  <script defer type="text/javascript" src="scripts/postMove.js"></script>
  <script defer type="text/javascript" src="scripts/checkRepetition.js"></script>
  <script defer type="text/javascript" src="scripts/colorStyle.js"></script>
  <script defer type="text/javascript" src="scripts/winnerLogic.js"></script>
  <script defer type="text/javascript" src="scripts/autoMove.js"></script>
  <script defer  type="text/javascript" src="scripts/troubleshooting.js"></script>
  <script defer type="text/javascript" src="scripts/gameTracking1.js"></script>
  <script defer type="text/javascript" src="scripts/init.js"></script>
  
  <script defer type="text/javascript" src="scripts/bookTest.js"></script>



</head>

<body class = "">

<!--   <div id="menu-placeholder"></div> -->
  <div id="menu-container" class="left"> 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #5e5353;
            margin: 0;
            padding: 0;
        }
        #analyzer {
            /* Styles for the analyzer container */
            margin: 70px;
            padding: 20px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #analyzer iframe {
            /* Styles for the iframe embedding the Flask app */
            width: 105%; /* Adjust as needed */
            height: 400px; /* Adjust as needed */
            border: none; /* Remove iframe border */
            border-radius: 4px;
            overflow: hidden;
        }

     </style>
      <div id="menu-tab">
          <div id="menu-icon">
              <div class="menu-line"></div>
              <div class="menu-line"></div>
              <div class="menu-line"></div>
          </div>
      </div>
      <div id="menu-items">
        <div id="new-game" class="menu-item">New Game</div>
        <div></div>
        <div id="pgn-menu" class="hidden">
            <div id="close-pgn" class="close-alert-menu"></div>
            <div id="move-pgn-menu">
                
            </div>

       
            <div id="resize-pgn-menu">
              <hr><hr><hr>  
              <div id="resize-grab"></div>
            </div>
          </div>
        <div ></div>
        <div id="toggle-computer" class="menu-item">Turn Computer Off</div>
      </div>
  </div>  

  
  <div id="main-container">
    <nav id="navbar">
      <div class="menu-icon">
      </div>
    </nav>
    <div id="player2-area">
      <div id="thinking"> Thinking
        <div id="rotate-anim"> 
            <div class="rotate1"></div>
            <div class="rotate2"></div>
        </div>
      </div>
      <div class="icon"></div>
      <div class="player-name"></div>
      <div id="p1graveyard">
        <div class="sub-graveyard pos0">
          <div class="piece p1piece white rook"></div>
          <div class="piece p1piece white knight"></div>
          <div class="piece p1piece white bishop"></div>
          <div class="piece p1piece white king"></div>
          <div class="piece p1piece white queen"></div>
          <div class="piece p1piece white bishop"></div>
          <div class="piece p1piece white knight"></div>
          <div class="piece p1piece white rook"></div>
          <div class="piece p1piece white pawn"></div>
          <div class="piece p1piece white pawn"></div>
          <div class="piece p1piece white pawn"></div>
          <div class="piece p1piece white pawn"></div>
          <div class="piece p1piece white pawn"></div>
          <div class="piece p1piece white pawn"></div>
          <div class="piece p1piece white pawn"></div>
          <div class="piece p1piece white pawn"></div>
        </div>
        <div class="sub-graveyard pos1"></div>
        <div class="sub-graveyard pos2"></div>
        <div class="sub-graveyard pos3"></div>
        <div class="sub-graveyard pos4"></div>
        <div class="sub-graveyard pos5"></div>
      </div>  
    </div>   
    <div id="game-area">
        <div id="game-alert" class="alert-menu hidden">
          <div class="close-alert-menu">X</div>
          <div id="winner" class="alert-menu-text"></div>
          <div id="new-game-alert">New Game</div>
        </div>
        <div id="ff-menu" class="alert-menu hidden">
          <div class="close-alert-menu">X</div>
          <div id="ff-name" class="alert-menu-text"></div>
          <div id="ff-buttons">
            <div id="ff-yes">Yes</div>
            <div id="ff-no">No</div>
          </div>
        </div> 
        <div id="board-with-promotion" class="">
          <div id = "choose-promotion"> 
            <div class = "promotion-piece"></div>
            <div class = "promotion-piece"></div>
            <div class = "promotion-piece"></div>
            <div class = "promotion-piece"></div>
          </div>
          <div id="board" class="">
            <div class="gameRow">
               <div class="square">
                 <div class="avail-move hidden"></div>
                 <div class="tr-text">8</div>
               </div>
               <div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div>
               <div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div>
            </div>
            <div class="gameRow">
               <div class="dark square">
                  <div class="avail-move hidden"></div>
                  <div class="tr-text">7</div>
               </div>
               <div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div>
               <div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div>
            </div>
            <div class="gameRow ">
               <div class="square ">
                 <div class="avail-move hidden "></div>
                 <div class="tr-text ">6</div>
               </div>
               <div class="dark square "><div class="avail-move hidden "></div></div><div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div>
               <div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div>
            </div>
            <div class="gameRow">
               <div class="dark square">
                 <div class="avail-move hidden"></div>
                 <div class="tr-text">5</div>
               </div>
               <div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div>
               <div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div>
            </div>
            <div class="gameRow">
               <div class="square">
                 <div class="avail-move hidden"></div>
                 <div class="tr-text">4</div>
               </div>
               <div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div>
               <div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div>
            </div>
            <div class="gameRow">
               <div class="dark square">
                 <div class="avail-move hidden"></div>
                 <div class="tr-text">3</div>
               </div>
               <div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div>
               <div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div>
            </div>
            <div class="gameRow">
               <div class="square">
                 <div class="avail-move hidden"></div>
                 <div class="tr-text">2</div>
               </div>
               <div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div>
               <div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div><div class="square"><div class="avail-move hidden"></div></div><div class="dark square"><div class="avail-move hidden"></div></div>
            </div>
            <div class="gameRow">
               <div class="dark square">
                 <div class="avail-move hidden"></div>
                 <div class="br-text">a</div>
                 <div class="tr-text">1</div>
               </div>
               <div class="square">
                 <div class="avail-move hidden"></div>
                 <div class="br-text">b</div>
               </div>
               <div class="dark square">
                 <div class="avail-move hidden"></div>
                 <div class="br-text">c</div>
               </div>
               <div class="square">
                 <div class="avail-move hidden"></div>
                 <div class="br-text">d</div>
               </div>
               <div class="dark square">
                 <div class="avail-move hidden"></div>
                 <div class="br-text">e</div>
               </div>
               <div class="square
                 "><div class="avail-move hidden"></div>
                 <div class="br-text">f</div>
               </div>
               <div class="dark square">
                 <div class="avail-move hidden"></div>
                 <div class="br-text">g</div>
               </div>
               <div class="square">
               <div class="avail-move hidden"></div>
                 <div class="br-text">h</div>
               </div>
            </div>
          </div>
          <div id="piece-area"></div>
      </div>
    </div>
    <div id="player1-area">
      <div class="thinking"></div>
      <div class="icon"></div>
      <div class="player-name"></div>
      <div id="p2graveyard">
        <div class="sub-graveyard pos0">
        <div class="piece p2piece black pawn"></div>
          <div class="piece p2piece black pawn"></div>
          <div class="piece p2piece black pawn"></div>
          <div class="piece p2piece black pawn"></div>
          <div class="piece p2piece black pawn"></div>
          <div class="piece p2piece black pawn"></div>
          <div class="piece p2piece black pawn"></div>
          <div class="piece p2piece black pawn"></div>
          <div class="piece p2piece black rook"></div>
          <div class="piece p2piece black knight"></div>
          <div class="piece p2piece black bishop"></div>
          <div class="piece p2piece black king"></div>
          <div class="piece p2piece black queen"></div>
          <div class="piece p2piece black bishop"></div>
          <div class="piece p2piece black knight"></div>
          <div class="piece p2piece black rook"></div>
        </div>
        <div class="sub-graveyard pos1"></div>
        <div class="sub-graveyard pos2"></div>
        <div class="sub-graveyard pos3"></div>
        <div class="sub-graveyard pos4"></div>
        <div class="sub-graveyard pos5"></div>
      </div>
    </div>
    <div id="bottom-area">
      <div id="interactive">
        <button class="hidden" id="hint">
          <img src="images/bulb.svg" alt="hint"/>
          Hint
        </button>
        <button class="" id="forfeit">
          <img src="images/flag.svg" alt="resign"/>
          Resign
        </button>
      </div>
      <div id="navigation">
        <button class="" id="prev-move"></button>
        <button class="" id="next-move"></button>
      </div>
    </div>
  </div> 
</body>

</html>
