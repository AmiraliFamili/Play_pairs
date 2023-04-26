<?php

$title = "Home";
$stylesheet = "DataBase/Index.css";
include("DataBase/Header.php");



// change the shit in here later then ... 
// final checks in specification 
// how to make it work for mobile devices 
// Write the Readme text file , it shouldn't be more than 250 pages 
?>






<script>
  console.log("Username : " + localStorage.getItem("Username"));
  console.log("Password : " + localStorage.getItem("Password"));
  console.log("Eyes : " + localStorage.getItem("Eyes"));
  console.log("Mouth : " + localStorage.getItem("Mouth"));
  console.log("Skin : " + localStorage.getItem("Skin"));
</script>

<div id="main">
<h1>Welcome to Pairs</h1>
  <img src="DataBase/BackGround/Welcome.jpg" alt="Arcade Image">
</div>

<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<div id="Fun"></div>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>

<a href="#AVATAR" id="FunLink"> Forgot A Mirror ? <br> Click ... </a>


<script>
  var Username = localStorage.getItem("Username");
  var Eyes = localStorage.getItem("Eyes");
  var Mouth = localStorage.getItem("Mouth");
  var Skin = localStorage.getItem("Skin");
document.getElementById("Fun").innerHTML = "Did You Know That " + Username + " Has " + Skin + " Skin , " + Eyes + " Eyes And a " + Mouth + " Mouth...!"; 
</script>


</body>

</html>
