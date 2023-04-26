<?php
session_start();

//header('Content-Type : application/json');

$title = "LeaderBoard";
$stylesheet = "DataBase/Leaderboard.css";
include("DataBase/Header.php");

?>

<div id="main">
    <h1>Leaderboard</h1>
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

    // Create an empty list to store the entries
    $entries = [];

    // Loop through the array and decode each line of JSON data
    $FileExists = false;
    foreach ($FileData as $line) {
        $entry = json_decode($line, true); // true parameter returns array instead of object

        // Add the decoded entry to the list

        $scores = json_decode($entry['Scores'], true);
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
            $FileExists = true;
        }
    }

    if (!$FileExists) {
        fwrite($file, json_encode($data) . PHP_EOL);
    }

    fclose($file);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    WriteData();
}
function ReadData()
{
    $filename = 'GameData.txt';

    // Read all lines from the file into an array
    $data = file($filename, FILE_IGNORE_NEW_LINES);

    // Create an empty list to store the entries
    $entries = [];

    // Loop through the array and decode each line of JSON data
    foreach ($data as $line) {
        $entry = json_decode($line, true); // true parameter returns array instead of object

        // Add the decoded entry to the list
        $entries[] = $entry;
    }

    // Sort the entries by Level (descending), Score (descending), and Time (ascending)
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
    }
}

function ResetData()
{
    $filename = 'GameData.txt';
    file_put_contents($filename, '');
}

function ReadDataForLevel()
{
    $filename = 'GameData.txt';

    // Read all lines from the file into an array
    $data = file($filename, FILE_IGNORE_NEW_LINES);

    // Create an empty list to store the entries
    $entries = [];

    // Loop through the array and decode each line of JSON data
    foreach ($data as $line) {
        $entry = json_decode($line, true); // true parameter returns array instead of object

        // Add the decoded entry to the list
        $entries[] = $entry;
    }

    // Sort the entries by Level (descending), Score (descending), and Time (ascending)

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
        $maxscore = 0;
        $BestResult = [];
        foreach ($entries as $entry) {
            $level = json_decode($entry["Level"], true);
            if ($level == $i) {
                $scores = json_decode($entry['Scores'], true);
                if ($scores[$i - 1] > $maxscore) {
                    $maxscore = $scores[$i - 1];
                    $Result = true;
                    $BestResult = $entry;
                }
            }
        }
        if ($Result) {
            $BestResult['Scores'] = json_encode([$scores[$i - 1]]);
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
        $scores = json_decode($entry['Scores'], true);
        $totalScores = 0;
        foreach ($scores as $score) {
            $totalScores += $score;
        }
        $attempts = $entry['Attempts'];
        $level = $entry['Level'];
        $username = $entry['Username'];
        echo "<tr><td>$level</td><td>$totalScores</td><td>$username</td><td>$time</td><td>$attempts</td></tr>";
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
        ReadData();
        ?>
    </table>
</div>
<br><br><br><br>
<div id="LevelTable">
    <table>
        <caption>Best Scores Per Level</caption>
    <?php
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