<?php
session_start();

$title = "LeaderBoard";
include("DataBase/Header.php");

// Read the request body as JSON
$jsonData = file_get_contents("php://input");
$Data = json_decode($jsonData, true);


var_dump($Data);
var_dump($jsonData);
// Get the data from the JSON object
$Score = $Data["Score"];
$MaxLevel = $Data["MaxLevel"];
$TotalAttempts = $Data["TotalAttempts"];
$TotalTime = $Data["TotalTime"];

// Do something with the data...
echo " Score is : $Score .... <br> BestLevel is : $MaxLevel .... <br> Attempts : $TotalAttempts .... <br> Time : $TotalTime ......... <br>";

// Send the response as JSON
$response_data = array("status" => "success");
echo json_encode($response_data);
?>






</body>
</html>