<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Amirali Famili">
    <link rel="stylesheet" href="StyleSheet.css">
    <?php
    if (isset($stylesheet)) {
        echo '<link rel="stylesheet" href="' . $stylesheet . '">';
    }

     /*
                <script>
                if (localStorage.getItem("Username") && localStorage.getItem("Password")){
                    // add Leaderboard link
                    const leaderboardLink = document.createElement("a");
                    leaderboardLink.href = "leaderboard.php";
                    leaderboardLink.name = "leaderboard";
                    leaderboardLink.style.float = "right";
                    leaderboardLink.innerHTML = "Leaderboard";
                    document.querySelector(".topnav").appendChild(leaderboardLink);

                }else{
                    const registerLink = document.createElement("a");
                    registerLink.href = "registration.php";
                    registerLink.name = "register";
                    registerLink.style.float = "right";
                    registerLink.innerHTML = "Register";
                    document.querySelector(".topnav").appendChild(registerLink);
                }
            </script> */
    ?>
    <link rel="icon" href="DataBase/gamer.png" type="image/x-icon">
    <title><?= $title ?></title>
</head>

<body>
    <div class="topnav">
    <canvas id="AVATAR" width="40px" height="40px"></canvas>
        <b>
            <a href="index.php" name="home">Home</a>
            <a href="pairs.php" name="memory" style="float: right;">Play Pairs</a>
            <a href="leaderboard.php" name="leaderboard" style="float: right;">Leaderboard</a>
            <a href="registration.php" name="register" style="float: right;">Register</a>


        </b>
    </div>


    <script>
        
        const AvatarEyes = new Image();
        const AvatarMouth = new Image();
        const AvatarSkin = new Image();
        const AvatarCanvasImage = document.getElementById('AVATAR');
        const AvatarContext = AvatarCanvasImage.getContext('2d');

        if (localStorage.getItem('Eyes') && localStorage.getItem('Mouth') && localStorage.getItem('Skin')) {

            AvatarEyes.src = `DataBase/emoji/eyes/${localStorage.getItem('Eyes')}.png`;
            AvatarMouth.src = `DataBase/emoji/mouth/${localStorage.getItem('Mouth')}.png`;
            AvatarSkin.src = `DataBase/emoji/skin/${localStorage.getItem('Skin')}.png`;

            function drawAvatar() {
                if (AvatarEyes.complete && AvatarMouth.complete && AvatarSkin.complete) {
                    // There is a problem with loading the images , they are not loaded right after the page is redirected
                    console.log("Avatar Created");
                    AvatarContext.clearRect(0, 0, AvatarCanvasImage.width, AvatarCanvasImage.height);

                    // Draw the skin first
                    AvatarContext.drawImage(AvatarSkin, 0, 0, AvatarCanvasImage.width,AvatarCanvasImage.height);

                    // Draw the eyes on top of the skin
                    AvatarContext.drawImage(AvatarEyes, 0, 0, AvatarCanvasImage.width, AvatarCanvasImage.height);

                    // Draw the mouth on top of the eyes and skin
                    AvatarContext.drawImage(AvatarMouth, 0, 0, AvatarCanvasImage.width, AvatarCanvasImage.height);
                }
            }
        }

        function updateAvatar() {
            if (localStorage.getItem('Eyes') && localStorage.getItem('Mouth') && localStorage.getItem('Skin')) {
                AvatarEyes.src = `DataBase/emoji/eyes/${localStorage.getItem('Eyes')}.png`;
                AvatarMouth.src = `DataBase/emoji/mouth/${localStorage.getItem('Mouth')}.png`;
                AvatarSkin.src = `DataBase/emoji/skin/${localStorage.getItem('Skin')}.png`;
                drawAvatar();
            }
        }

        // Call updateAvatar when the page is loaded
        updateAvatar();

        // Listen for changes in the local storage and call updateAvatar when changes are detected
        window.addEventListener('storage', updateAvatar);
    </script>