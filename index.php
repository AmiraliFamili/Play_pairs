<?php

$title = "Home";
$stylesheet = "DataBase/Index.css";
include("DataBase/Header.php");

/*
This is the main page of the website , it welcomes the new users and guide them to 
either pairs.php or registration.php 
*/
?>

<div id="main">
  <h1>Welcome to Pairs</h1>
  <img src="DataBase/BackGround/Welcome.jpg" alt="Arcade Image">
</div>

<br><br><br><br>


<div id="ShowPairs" style="display:none;">
  <abbr title="This Button Will Take You To Play Pairs"><button class="PlayPairs" id="PlayPairs" onclick="window.location.href = 'pairs.php'">Click here to play</button></abbr>
</div>
<div id="ShowRegistration" style="display:none;">
  You're not using a registered session?
  <br><br>
  <abbr title="This Button Will Take You To Registration"><button class="Register" id="Register" onclick="window.location.href = 'registration.php'">Register now</button></abbr>
</div>
<script>
  if (localStorage.getItem("Username") && localStorage.getItem("Password")) {
    var showPairsDiv = document.getElementById("ShowPairs");
    showPairsDiv.style.display = "inline-block";
  }
  else {
    var showRegistration = document.getElementById("ShowRegistration");
    showRegistration.style.display = "inline-block";
  }
</script>

<script>
  function DisplayInfo() {
    var DisplayInfo = document.getElementById("GameInfo");
    DisplayInfo.style.display = "inline-block";
    var Hidebutton = document.getElementById("GameInf");
    Hidebutton.style.display = "none";
    var Exit = document.getElementById("Exit");
    Exit.style.display = "inline-block";
  }

  function Exit() {
    var Exit = document.getElementById("Exit");
    Exit.style.display = "none";
    var Hidebutton = document.getElementById("GameInf");
    Hidebutton.style.display = "inline-block";
    var DisplayInfo = document.getElementById("GameInfo");
    DisplayInfo.style.display = "none";
  }

  function NewUserReset() {
    localStorage.clear(); // This is Used For Clearing the localStorage
    location.reload();
  }
</script>
<br><br><br>
<div style="display: flex; justify-content: space-between;">
  <abbr title="This Button Will Display Information about this game"><button class="GameInf" id="GameInf" onclick="DisplayInfo()">Game Information</button></abbr>
  <abbr title="This Button Will Reset Your Username and Password"><button class="NewUser" id="NewUser" onclick="NewUserReset()">Reset Username</button></abbr>
</div>
<div style="display: none;" id="GameInfo">
  <dl>
    <dt style="text-align: center; font-size: 80px;">Pairs Game</dt><br><br>
    <dd>
      - Pairs is a Memory Game , you have to match The same cards together untill all cards are faced up .
      <ul>
        <li>The game starts with 6 cards in total and you have to pair 3 of them with the other 3</li>
        <li>For each level you complete the number of cards will increase by one (Times the number of cards you have to match together in total)</li>
        <li>In Levels (10, 20, 40, 65, 100) the number of cards that you have to match together will increase (So for example in level 10 you have match 3 cards that are the same together rather than 2 in level 20, 4 rather than 3).</li>
        <li>There are 105 levels in total ... </li>
        <li>The last level has 756 cards , that is 108 cards that are repeated 7 times (and you have to match 7 cards at a time)</li>
        <li>In each new level the user will recive a bonuse point and it increases with each level (Level * 1000)</li>
        <li>This is how the score is calculated : UserScore = MaxScore - ((Attempts * 1000 / TotalPairs) + (Time / TotalPairs) - (Level * 1000)), where max score is 10000</li>
        <li>In each level completion you can play again , progress through the next level or you can submit your game and see it in the leaderboard</li>
        <br><br>
        <li>Exit For Showing Less and Reset For New Username and Password</li>
      </ul>
    </dd>
  </dl>
</div>

<abbr title="Click To Hide The information"><button class="Exit" id="Exit" style="display: none;" onclick="Exit()">Exit</button></abbr>

</body>

</html>