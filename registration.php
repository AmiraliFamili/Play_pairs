<?php

$title = "Login";
$stylesheet = "DataBase/Registration.css";
include("DataBase/Header.php");

// set Username and Password to "" or null somewhere at the begining ... 

?>


<h1>Login</h1>
<br><br>
<form method="POST" id="Register" action="index.php" onsubmit="return ResolveErrors()">
    <label for="username"></label>
    <input type="text" name="username" id="username" placeholder="Username..." required oninput="checkUsername()"><br>
    <div><span id="username-error"></span></div>

    <label for="password"></label>
    <input type="password" name="password" id="password" placeholder="Password..." required oninput="checkPassword()"><br>
    <div><span id="password-error"></span></div>

    <label for="password"></label>
    <input type="password" name="confpassword" id="confpassword" placeholder="Confirm Password..." required oninput="checkConfPassword()"><br>
    <div><span id="confpassword-error"></span></div><br>

    <br>
    <div id="main">
    <img src="DataBase/BackGround/Registration.jpg" alt="Arcade Image">
</div>

    <br>
    <fieldset>
        <legend>Avatar</legend>
        <figure>
            <br>
            <figcaption>Eyes : </figcaption><br>

            <label for="Closed Eyes">
                <input type="radio" name="eyes" id="Closed Eyes" value="closed">
                <img src="DataBase/emoji/eyes/closed.png" alt="Closed Eyes" width="50px" height="50px" title="This is a picture of closed eyes for forming the avatar of the user">
            </label>

            <label for="Laughing Eyes">
                <input type="radio" name="eyes" id="Laughing Eyes" value="laughing">
                <img src="DataBase/emoji/eyes/laughing.png" alt="Laughing Eyes" width="50px" height="50px" title="This is a picture of laughing eyes for forming the avatar of the user">
            </label>

            <label for="Long Eyes">
                <input type="radio" name="eyes" id="Long Eyes" value="long">
                <img src="DataBase/emoji/eyes/long.png" alt="Long Eyes" width="50px" height="50px" title="This is a picture of long eyes for forming the avatar of the user">
            </label>

            <label for="Normal Eyes">
                <input type="radio" name="eyes" id="Normal Eyes" value="normal">
                <img src="DataBase/emoji/eyes/normal.png" alt="Normal Eyes" width="50px" height="50px" title="This is a picture of normal eyes for forming the avatar of the user">
            </label>
            <label for="Rolling Eyes">
                <input type="radio" name="eyes" id="Rolling Eyes" value="rolling">
                <img src="DataBase/emoji/eyes/rolling.png" alt="Rolling Eyes" width="50px" height="50px" title="This is a picture of rolling eyes for forming the avatar of the user">
            </label>

            <label for="Winking Eyes">
                <input type="radio" name="eyes" id="Winking Eyes" value="winking">
                <img src="DataBase/emoji/eyes/winking.png" alt="Winking Eyes" width="50px" height="50px" title="This is a picture of winking eyes for forming the avatar of the user">
            </label>

            <p id="selected-eye-value"></p>
        </figure>

        <figure>
            <br>
            <figcaption>Mouth :</figcaption><br>

            <label for="Open Mouth">
                <input type="radio" name="mouth" id="Open Mouth" value="open">
                <img src="DataBase/emoji/mouth/open.png" alt="Open mouth" width="50px" height="50px" title="This is a picture of open mouth for forming the avatar of the user">
            </label>

            <label for="Sad Mouth">
                <input type="radio" name="mouth" id="Sad Mouth" value="sad">
                <img src="DataBase/emoji/mouth/sad.png" alt="Sad mouth" width="50px" height="50px" title="This is a picture of sad mouth for forming the avatar of the user">
            </label>

            <label for="Smiling Mouth">
                <input type="radio" name="mouth" id="Smiling Mouth" value="smiling">
                <img src="DataBase/emoji/mouth/smiling.png" alt="Smiling mouth" width="50px" height="50px" title="This is a picture of smiling mouth for forming the avatar of the user">
            </label>

            <label for="Straight Mouth">
                <input type="radio" name="mouth" id="Straight Mouth" value="straight">
                <img src="DataBase/emoji/mouth/straight.png" alt="Straight mouth" width="50px" height="50px" title="This is a picture of straight mouth for forming the avatar of the user">
            </label>

            <label for="Surprise Mouth">
                <input type="radio" name="mouth" id="Surprise Mouth" value="surprise">
                <img src="DataBase/emoji/mouth/surprise.png" alt="Surprise mouth" width="50px" height="50px" title="This is a picture of surprise mouth for forming the avatar of the user">
            </label>

            <label for="Teeth Mouth">
                <input type="radio" name="mouth" id="Teeth Mouth" value="teeth">
                <img src="DataBase/emoji/mouth/teeth.png" alt="Teeth mouth" width="50px" height="50px" title="This is a picture of teeth mouth for forming the avatar of the user">
            </label>

            <p id="selected-mouth-value"></p>
        </figure>

        <figure>
            <br>
            <figcaption>Skin :</figcaption><br>

            <label for="Green Skin">
                <input type="radio" name="skin" id="Green Skin" value="green">
                <img src="DataBase/emoji/skin/green.png" alt="Green Skin" width="50px" height="50px" title="This is a picture of green skin for forming the avatar of the user">
            </label>

            <label for="Red Skin">
                <input type="radio" name="skin" id="Red Skin" value="red">
                <img src="DataBase/emoji/skin/red.png" alt="Red Skin" width="50px" height="50px" title="This is a picture of red skin for forming the avatar of the user">
            </label>

            <label for="Yellow Skin">
                <input type="radio" name="skin" id="Yellow Skin" value="yellow">
                <img src="DataBase/emoji/skin/yellow.png" alt="Yellow Skin" width="50px" height="50px" title="This is a picture of yellow skin for forming the avatar of the user">
            </label>

            <p id="selected-skin-value"></p>


            <br><br><br>
            <canvas id='avatar' width="120" height="120"></canvas>
        </figure>
    </fieldset>

    <br><br><br>
    <button type="submit" name="submit" id="Login" value="Login">Register</button>
    <div><span id="validation-error"></span></div>
</form>

<script>
    function checkUsername() { 
        var username = document.getElementById("username").value;

        if (username.length > 30) {
            document.getElementById("username-error").innerHTML = "Username should be less than 30 characters";
            return false;
        }

        var special_chars = '”!@#%&^*()+={}[]-;:“\'"<>?/';
        for (var i = 0; i < username.length; i++) {
            var char = username.charAt(i);
            if (special_chars.indexOf(char) !== -1) {
                document.getElementById("username-error").innerHTML = "Special characters are not allowed for Username: (”!@#%&^*()+={}[]—;:`\"'<>?/)";
                return false;
            } else if (char === " ") {
                document.getElementById("username-error").innerHTML = "White Spaces are not allowed, Username must be a single word less than 30 Characters";
                return false;
            }
        }

        document.getElementById("username-error").innerHTML = "";
        localStorage.setItem("Username" , username);
        return true;
    }

    function checkPassword() { 
        var Password = document.getElementById("password").value;

        if (Password.length < 8) {
            document.getElementById("password-error").innerHTML = "Password should be 8 Characters Long";
            return false;
        }


        document.getElementById("password-error").innerHTML = "";
        localStorage.setItem("Password", Password);
        return true;
    }

    function checkConfPassword() { 
        var Password = document.getElementById("password").value;
        var confPassword = document.getElementById("confpassword").value;

        if (Password != confPassword) {
            document.getElementById("confpassword-error").innerHTML = "Password and Confirm Password do Not Match !";
            return false;
        }

        document.getElementById("confpassword-error").innerHTML = "";
        return true;
    }

    function ResolveErrors() {
        var isUsernameValid = checkUsername();
        var isPasswordValid = checkPassword();
        var isConfPasswordValid = checkConfPassword();

        if (!isUsernameValid || !isPasswordValid || !isConfPasswordValid) {
            document.getElementById("validation-error").innerHTML = "Please enter the information in the desired format";
            return false;
        }

        return true;
    }
</script>

<script>

    const selectedEyes = new Image();
    selectedEyes.src = `DataBase/emoji/eyes/${localStorage.getItem('Eyes')}.png`;

    const selectedMouth = new Image();
    selectedMouth.src = `DataBase/emoji/mouth/${localStorage.getItem('Mouth')}.png`;

    const selectedSkin = new Image();
    selectedSkin.src = `DataBase/emoji/skin/${localStorage.getItem('Skin')}.png`;

    const canvas = document.getElementById('avatar');
    const ctx = canvas.getContext('2d');

    drawAvatar();

    // Add event listeners to the radio buttons
    const eyes = document.querySelectorAll('input[name="eyes"]');
    eyes.forEach(radio => {
        radio.addEventListener('change', function() {
            selectedEyes.src = `DataBase/emoji/eyes/${this.value}.png`;
            drawAvatar();
            saveData("Eyes");
        });
    });

    const mouth = document.querySelectorAll('input[name="mouth"]');
    mouth.forEach(radio => {
        radio.addEventListener('change', function() {
            selectedMouth.src = `DataBase/emoji/mouth/${this.value}.png`;
            drawAvatar();
            saveData("Mouth");
        });
    });

    const skin = document.querySelectorAll('input[name="skin"]');
    skin.forEach(radio => {
        radio.addEventListener('change', function() {
            selectedSkin.src = `DataBase/emoji/skin/${this.value}.png`;
            drawAvatar();
            saveData("Skin");
        });
    });

    function drawAvatar() {
        // Wait until all images are loaded
        if (selectedEyes.complete && selectedMouth.complete && selectedSkin.complete) {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Draw the skin first
            ctx.drawImage(selectedSkin, 0, 0, canvas.width, canvas.height);

            // Draw the eyes on top of the skin
            ctx.drawImage(selectedEyes, 0, 0, canvas.width, canvas.height);

            // Draw the mouth on top of the eyes and skin
            ctx.drawImage(selectedMouth, 0, 0, canvas.width, canvas.height);
        }
    }

    function saveData(Feature) {
        if (Feature === "Eyes"){
            const selectedEyesValue = document.querySelector('input[name="eyes"]:checked').value;
            localStorage.setItem('Eyes', selectedEyesValue);
        }
        else if (Feature === "Mouth"){
            const selectedMouthValue = document.querySelector('input[name="mouth"]:checked').value;
            localStorage.setItem('Mouth', selectedMouthValue);
        }else if (Feature === "Skin"){
            const selectedSkinValue = document.querySelector('input[name="skin"]:checked').value;
            localStorage.setItem('Skin', selectedSkinValue);
        }else {
            console.log("Something Went Wrong with the saveData()");
        }
        
        }
</script>



</body>

</html>