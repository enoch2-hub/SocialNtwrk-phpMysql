<?php

    require_once 'header.php';


    if(!$loggedin) {
        die("</div></body></html>");
    } else {
        echo "<h3>Your Profile</h3>";
    }

    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");
    

    //Handling Profile Text Submission
    if(isset($_POST['text'])) {
        $text = sanitizeString($_POST['text']);
        $text = preg_replace('/\s\s+/', ' ', $text);
        
        if($result->rowCount())//check if the user already has a profile
        {
            queryMysql("UPDATE profiles SET text='$text' where user='$user'");//updates the text if the profile exists.
        } else {
            queryMysql("INSERT INTO profiles VALUES('$user', '$text')");//inserts new profile record with the users text.
        }
    }
    //Retrieving existing profile text
    else {
        if($result->rowCount()){//checks if profile exists
            $row = $result->fetch();//fetches profile row
            $text = stripslashes($row['text']);//extracts the text, removing slashes
        } else {
            $text = "";
        }
    }

    $text = stripslashes(preg_replace('/\s\s+/', ' ', $text));


    // Handling Profile Image Upload
    if(isset($_FILES['image']['name'])) {//Checks if an image has been uploaded.
        $saveto = "$user.jpg";// Sets the file path to save the image as username.jpg.
        move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
        $typeok = TRUE;

        switch($_FILES['image']['type'])
        {
            case "image/gif":   $src = imagecreatefromgif($saveto); break;
            case "image/jpeg":  // Both regular and progressive jpegs
            case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
            case "image/png":   $src = imagecreatefrompng($saveto); break;
            default:            $typeok= FALSE; break;
        }

        if($typeok) // If img type is valid, resizes img to a max of 100px with aspect ratio.
        {
            list($w, $h) = getimagesize($saveto);

            $max = 100;
            $tw  = $w;
            $th  = $h;

            if ($w > $h && $max < $w) {
                $th = $max / $w * $h;
                $tw = $max;
            } elseif($h > $w && $max < $h) {
                $tw = $max / $h * $w;
                $th = $max;
            } elseif($max > $w) {
                $tw = $th = $max;
            }

            $tmp = imagecreatetruecolor($tw, $th);
            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
            imageconvolution($tmp, array(array(-1, -1, -1),
                array(-1, 16, -1), array(-1,-1,-1)), 8, 0);//enhances img quality.
            imagejpeg($tmp, $saveto);//saves resampled image.
            imagedestroy($tmp);
            imagedestroy($src);
        }
    }

    showProfile($user);

echo <<<_END
    <form data-ajax='false' method='post'
        action='profile.php?r=$randstr' enctype='multipart/form-data'>

        <h3>Enter or edit your details and/or upload an image</h3>
        
        <textarea name='text'>$text</textarea>
        <br>
        Image: <input type='file' name='image' size='14'>
        <input type='submit' value='Save Profile'>
        
    </form>
    </div><br>
    </body>
    </html>

_END;

?>