<?php
function createAvatars(){
    
    $Alleyes = array("closed", "laughing", "long", "normal", "rolling", "winking");
    $Allmouth = array("open", "sad", "smiling", "straight", "surprise", "teeth");
    $Allskin = array("green", "red", "yellow");

    $counter = 0;
    foreach ($Alleyes as $eyes) {
        foreach ($Allmouth as $mouth) {
            foreach ($Allskin as $skin) {
                // Set the image paths
                $eyesPath = "DataBase/emoji/eyes/$eyes.png";
                $mouthPath = "DataBase/emoji/mouth/$mouth.png";
                $skinPath = "DataBase/emoji/skin/$skin.png";

                // Create a new image from the selected eyes, mouth, and skin
                $avatar = imagecreatetruecolor(500, 500);
                imagesavealpha($avatar, true);
                $trans_color = imagecolorallocatealpha($avatar, 0, 0, 0, 127);
                imagefill($avatar, 0, 0, $trans_color);

                $skinImg = imagecreatefrompng($skinPath);
                $eyesImg = imagecreatefrompng($eyesPath);
                $mouthImg = imagecreatefrompng($mouthPath);

                imagealphablending($avatar, true);
                imagesavealpha($avatar, true);

                // Enable alpha blending for the eye image
                imagealphablending($eyesImg, true);
                imagesavealpha($eyesImg, true);

                // Enable alpha blending for the mouth image
                imagealphablending($mouthImg, true);
                imagesavealpha($mouthImg, true);

                // Enable alpha blending for the skin image
                imagealphablending($skinImg, true);
                imagesavealpha($skinImg, true);

                if ($mouth == "surprise") {
                    $mouthImg = imagescale($mouthImg, 500, 500);
                }

                imagecopy($avatar, $skinImg, 0, 0, 0, 0, 500, 500);
                imagecopy($avatar, $eyesImg, 0, 0, 0, 0, 500, 500);
                imagecopy($avatar, $mouthImg, 0, 0, 0, 0, 500, 500);



                // Save the new image to the avatars folder
                $counter++;
                imagepng($avatar, "DataBase/emoji/avatars/avatar$counter.png");

                // Destroy the images
                imagedestroy($avatar);
                imagedestroy($skinImg);
                imagedestroy($eyesImg);
                imagedestroy($mouthImg);
            }
        }
    }
}
