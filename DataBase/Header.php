<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Amirali Famili">
    <link rel="stylesheet" href="StyleSheet.css">
    <link rel="icon" type="image/x-icon" href="DataBase/BackGround/calm.png">
    <?php
    if (isset($stylesheet)) {
        echo '<link rel="stylesheet" href="' . $stylesheet . '">';
    }

    /*
    This is the header of the website and it is used in all webpages useing include keyword 
    It contains thenavbar and it will create the avatar icon for navbar if the user has registered and built one 
    It also contains hyperlinks in navbar which is designed for easier navigation through out the website 
    */

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
            </script> 
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
                    AvatarContext.clearRect(0, 0, AvatarCanvasImage.width, AvatarCanvasImage.height);
                    AvatarContext.drawImage(AvatarSkin, 0, 0, AvatarCanvasImage.width,AvatarCanvasImage.height);
                    AvatarContext.drawImage(AvatarEyes, 0, 0, AvatarCanvasImage.width, AvatarCanvasImage.height);
                    AvatarContext.drawImage(AvatarMouth, 0, 0, AvatarCanvasImage.width, AvatarCanvasImage.height);
                    // Here we draw the avatar in canvas in the correct order 
                }
            }
        }

        function updateAvatar() { // This function is used to make sure that the avatar image will be updated 
            if (localStorage.getItem('Eyes') && localStorage.getItem('Mouth') && localStorage.getItem('Skin')) {
                AvatarEyes.src = `DataBase/emoji/eyes/${localStorage.getItem('Eyes')}.png`;
                AvatarMouth.src = `DataBase/emoji/mouth/${localStorage.getItem('Mouth')}.png`;
                AvatarSkin.src = `DataBase/emoji/skin/${localStorage.getItem('Skin')}.png`;
                drawAvatar();
            }
        }

        updateAvatar();

        // Listen for changes in the local storage and call updateAvatar when changes are detected
        window.addEventListener('storage', updateAvatar);
    </script>