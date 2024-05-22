<?php

    require_once 'header.php';


    if(!$loggedin) {
        die("</div></body></html>");
    } else {
        echo "<h3>Your Profile</h3>";
    }

    $result = queryMysql("SELECT * FROM profiles WHERE user=$user");
    
    if(isset($_POST['text'])) {
        $text = sanitizeString($_POST['text']);
        $text = preg_replace('/\s\s+/', ' ', $text);
        
        if($result->rowCount()){
            queryMysql("UPDATE profiles SET text='$text' where user='$user'");
        } else {
            queryMysql("INSERT INTO profiles VALUES('$user', '$text')");
        }
    }




    










echo <<<_END
    <form data-ajax='false' method='post'
        action='profile.php?r=$randstr' enctype='multipart/form-data'>

        <h3>Enter or edit your details and/or upload an image</h3>
        <textarea name='text'>$text</textarea>
        <br>
        Image: <input type='file' name='image' size='14'>
        <input type='submit' value='Save Profile'>
    <form/>


_END;

?>