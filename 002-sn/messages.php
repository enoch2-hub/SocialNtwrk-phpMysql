<?php

    require_once 'header.php';

    if(isset($_GET['view'])) {
        $view = sanitizeString($_GET['view']);
    } else $view = $user;
    
    //Handling Message Submission
    if (isset($_POST['text'])) {
        $text = sanitizeString($_POST['text']);
        if($text != "") {
            $pm = substr(sanitizeString($_POST['pm']), 0, 1);
            $time = time();
            queryMysql("INSERT INTO messages 
                VALUES(NULL, '$user', '$view', '$pm', '$time', '$text')");
        }
    }



    //Displaying the User's Messages
    if($view != ""){
        if ($view == $user) {
            $name1 = $name2 = "Your";
        } else {
            $name1 = "<a href='members.php?view=$view&r=$randstr'>$view</a>'s";
            $name2 = "$view's";
        }

        echo "<h3>$name1 Messages</h3>";
        showProfile($view);

        //Message Form
        echo <<<_END
            <form method="post" action='messages.php?view=$view&r=$randstr'>
                <fieldset data-role="controlgroup" data-type="horizontal">
                    <legend>Type here to leave a Message</legend>
                    
                    <input type="radio" name="pm" id="public" value="0" checked="checked">
                    <label for="public">Public</label>
                    
                    <input type="radio" name="pm" id="private" value="1">
                    <label for="private">Private</label>

                </fieldset>

                <textarea name="text" id=""></textarea>

                <input type="submit" data-transaction="slide" value="Post Message">

            </form><br>

        _END;



        //Erasing Messages
        date_default_timezone_set('UTC');
        if(isset($_GET['erase'])){
            $erase = sanitizeString($_GET['erase']);
            queryMysql("DELETE FROM messages WHERE id='$erase' AND recip='$user'");
        }


        //Displaying Messages
        $query = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
        $result = queryMysql($query);
        $num = $result->rowCount();

        while($row = $result->fetch()) {
            if($row['pm']== 0 || $row['auth'] == $user || $row['recip'] == $user){
                //format and display the msgs's timestamp
                echo date('M js \'y g:ia:', $row['time']);
                //display author of the msg as a link
                echo " <a href='messages.php?view=" . $row['auth'] . 
                    "&r=$randstr'>" . $row['auth']. "</a>";
                //display if msg is public-'wrote' or private-'whispered'
                if($row['pm'] == 0) {
                    echo "wrote: &quot;" . $row['message'] . "&quot; ";
                } else {
                    echo "whispered: <span class ='whisper'&quot;" .$row['message']. "&quot;</span>";
                };
                //if current user=recipient, display an "erase" link to del msg
                if($row['recip'] == $user) {
                    echo "[<a href='messages.php?view=$view&erase=" . $row['id'] . "&r=$randstr'>erase</a>]";
                }
                echo "<br>";
            }
    }

}





    // Handling No Messages
    if(!$num) {
        echo "<br><span class='info'>No Messages yet<br><br>";
    }


echo "<br>
        <a data-role='button' href='messages.php?view=$view&r=$randstr'>
            Refresh messages
        </a>";
?>



</div><br>
</body>
</html>





