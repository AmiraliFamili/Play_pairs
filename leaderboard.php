<?php
session_start();

$title = "LeaderBoard";
$stylesheet = "DataBase/Leaderboard.css";
include("DataBase/Header.php");
/*
This is the leaderboard Page , All Users who submit their score will send a post request to this 
webpage , this webpage will gather the information and write them to a file called GameData
The data will then be red and displayed on tables in the center of the webpage . 
*/
?>

<h1>Leaderboard</h1>
<br>
<div id="main">
    <img src="DataBase/BackGround/leaderboard4.jpg" alt="Arcade Image">
</div>

<br>

<?php

function WriteData()
{
    $Time = $_POST['Time'];
    $scores = $_POST["Score"];
    $Attempts = $_POST["Attempts"];
    $Level = $_POST["Level"];
    $Username = $_POST["username"];

    $filename = 'GameData.txt';
    $file = fopen($filename, 'a');

    $data = array(
        "Time" => $Time,
        "Scores" => $scores,
        "Attempts" => $Attempts,
        "Level" => $Level,
        "Username" => $Username
    );

    $FileData = file($filename, FILE_IGNORE_NEW_LINES);
    $entries = [];
    $FileExists = false;
    foreach ($FileData as $line) {
        $entry = json_decode($line, true);// to decode the json file 
        $scores = json_decode($entry['Scores'], true); // to decode the array that contains all the scores 
        $totalScores = 0;
        foreach ($scores as $score) {
            $totalScores += $score;
        }
        $userScores = json_decode($data['Scores'], true);
        $userTotalScores = 0;
        foreach ($userScores as $score) {
            $userTotalScores += $score;
        }

        if ($entry["Time"] == $data["Time"] && $entry["Attempts"] == $data["Attempts"] && $entry["Level"] == $data["Level"] && $entry["Username"] == $data["Username"] && $userTotalScores == $totalScores) {
            $FileExists = true; // this if statement will preven the same data to be written twice 
        }
    }

    if (!$FileExists) {
        fwrite($file, json_encode($data) . PHP_EOL);
    }

    fclose($file);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    WriteData(); // only calls the function if there are values inside the post request 
    // and stops the function to write null values for game information 
}
function ReadData()
{
    $filename = 'GameData.txt';
    $data = file($filename, FILE_IGNORE_NEW_LINES); // Read all lines from the file into an array
    $entries = [];

    foreach ($data as $line) {
        $entry = json_decode($line, true); 
        $entries[] = $entry;
    }

    usort($entries, function ($a, $b) { // This function is used for sorting the Informarion Based On their priority 
        $ascores = json_decode($a['Scores'], true);
        $atotalScores = 0;
        foreach ($ascores as $score) {
            $atotalScores += $score;
        }
        $bscores = json_decode($b['Scores'], true);
        $btotalScores = 0;
        foreach ($bscores as $score) {
            $btotalScores += $score;
        }
        if ($atotalScores != $btotalScores) {
            return $btotalScores - $atotalScores;
        } else if ($a['Level'] != $b['Level']) {
            return $b['Level'] - $a['Level'];
        } else {
            return $a['Time'] - $b['Time'];
        }
    });

    // Loop through the sorted entries and display them in a table
    echo "<tr><th>Scores</th><th>Username</th><th>Level</th><th>Time</th><th>Attempts</th></tr>";
    foreach ($entries as $entry) {
        $time = $entry['Time'];
        $scores = json_decode($entry['Scores'], true);
        $totalScores = 0;
        foreach ($scores as $score) {
            $totalScores += $score;
        }
        $attempts = $entry['Attempts'];
        $level = $entry['Level'];
        $username = $entry['Username'];
        echo "<tr><td>$totalScores</td><td>$username</td><td>$level</td><td>$time</td><td>$attempts</td></tr>";
        // information which will be displayedd in table data blocks 
    }
}

function ResetData() // This function is used for reseting the GameData text File 
// Although it is never used in the webpage , it could be used by a developer 
{
    $filename = 'GameData.txt';
    file_put_contents($filename, '');
}

function ReadDataForLevel() // This function has the same structure as the ReadData() function 
// the main difference is that in this function the priority of sorting the game information is different 
// and it is based on the level 
{
    $filename = 'GameData.txt';
    $data = file($filename, FILE_IGNORE_NEW_LINES);
    $entries = [];
    foreach ($data as $line) {
        $entry = json_decode($line, true); 
        $entries[] = $entry;
    }

    $maxLevel = 0;
    foreach ($entries as $entry) {
        $level = json_decode($entry["Level"], true);
        if ($level > $maxLevel) {
            $maxLevel = $level;
        }
    }

    $HighestScores = [];
    for ($i = $maxLevel; $i >= 1; $i--) {
        $Result = false;
        $BestResult = [];
        $maxscore = 0;
        foreach ($entries as $entry) {
            $level = json_decode($entry["Level"], true);
                $scores = json_decode($entry['Scores'], true);
                //echo $level."<br>" ;
                if ($scores[$i - 1] > $maxscore && $scores[$i - 1] > 0) {
                    if (array_key_exists($i - 1, $scores)) {
                        $maxscore = $scores[$i - 1];
                       // echo $maxscore."<br>";
                        $Result = true;
                        $entry["Level"] = $i;
                        $entry["Scores"] = $maxscore ;
                        $BestResult = $entry;
                        //echo $BestResult["Scores"]."<br>";
                    }
                }
            
        }
        if ($Result) {
            $HighestScores[] = $BestResult;
        }
    }

    usort($entries, function ($a, $b) {
        $ascores = json_decode($a['Scores'], true);
        $atotalScores = 0;
        foreach ($ascores as $score) {
            $atotalScores += $score;
        }
        $bscores = json_decode($b['Scores'], true);
        $btotalScores = 0;
        foreach ($bscores as $score) {
            $btotalScores += $score;
        }
        if ($a['Level'] != $b['Level']) {
            return $b['Level'] - $a['Level'];
        }
        else if ($atotalScores != $btotalScores) {
            return $btotalScores - $atotalScores;
         } else {
            return $a['Time'] - $b['Time'];
        }
    });

    echo "<tr><th>Level</th><th>Scores</th><th>Username</th><th>Time</th><th>Attempts</th></tr>";
    foreach ($HighestScores as $entry) {
        $time = $entry['Time'];
        $scores =  json_decode($entry['Scores'], true);
        $attempts = $entry['Attempts'];
        $level = $entry['Level'];
        $username = $entry['Username'];
        echo "<tr><td>$level</td><td>$scores</td><td>$username</td><td>$time</td><td>$attempts</td></tr>";
    }
}


echo "<br>";

?>

<div id="main2">
    <img src="DataBase/BackGround/leaderboard3.jpg" alt="Arcade Image">
</div>

<br><br><br>

<div id="Table">
    <table>
        <caption>Best Scores</caption>
        <?php
        // write data to the table using php
        ReadData();
        ?>
    </table>
</div>
<br><br><br><br>
<div id="LevelTable">
    <table>
        <caption>Best Scores Per Level</caption>
    <?php
    //write data to the table using php
    ReadDataForLevel();
    ?>
    </table>
</div>


<br><br><br><br>


<div id="main3">
    <img src="DataBase/BackGround/leaderboard2.jpg" alt="Arcade Image">
</div>

<br><br><br><br>

<div id="main4">
    <img src="DataBase/BackGround/leaderboard1.jpg" alt="Arcade Image">
</div>


<br><br><br><br>





</body>

</html>