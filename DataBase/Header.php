

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Amirali Famili">
    <link rel="stylesheet" href="StyleSheet.css">
    <?php
    if(isset($stylesheet)){
        echo '<link rel="stylesheet" href="'.$stylesheet.'">';
    }
    ?>
    <link rel="icon" href="DataBase/gamer.png" type="image/x-icon">
    <title><?=$title?></title>
</head>
<body>
    <div class="topnav">
        <b>
            <a href="index.php" name="home">Home</a>
            <a href="pairs.php" name="memory" style="float: right;">Play Paris</a>
            <a href="leaderboard.php" name="leaderboard" style="float: right;">Leaderboard</a>
            <a href="registration.php" name="register" style="float: right;">Register</a>
        </b>
      </div>
