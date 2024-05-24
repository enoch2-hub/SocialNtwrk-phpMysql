<?php

    require_once 'header.php';

    if(!$loggedin) die("</div><body></html>");


    //View a specific members profile
    if(isset($_GET['view']))
    {
        $view = sanitizeString($_GET['view']);

        if($view == $user) $name = "Your";
        else $name = "$view's";

        echo "<h3>$name Profile</h3>";
        showProfile($view);
        echo "<a data-role='button' data-transition='slide'
            href='messages.php?view=$view&r=$randstr'>
            View $name messages </a>";
    }

    //Add a friend    
    if(isset($_GET['add']))
    {
        $add = sanitizeString($_GET['add']);
        $result = queryMySql("SELECT * FROM friends 
            WHERE user='$add' AND friend='$user' ");
        if(!$result->rowCount()) {
            queryMysql("INSERT INTO friends VALUES ('$add', '$user')");
        }
    } //Remove a friend
    elseif (isset($_GET['remove'])) {
        $remove = sanitizeString($_GET['remove']);
        queryMySql("DELETE FROM friends
        WHERE user='$remove' AND friend='$user'");
    }
    //Display all members
    $result = queryMySql("SELECT user FROM members ORDER BY user");
    $num = $result->rowCount();

    //List members with follow unfollow options
    while ($row = $result->fetch()) {
        if ($row['user'] == $user) continue;
    
        echo "<li class='members'><a data-transition='slide' 
            href='members.php?view=" . $row['user'] . 
            "&$randstr'>" . $row['user'] . "</a>";
        $follow = "follow";
    
        $result1 = queryMysql("SELECT * FROM friends 
            WHERE user='" . $row['user'] . "' AND friend='$user'");
        $t1 = $result1->rowCount();
    
        $result1 = queryMysql("SELECT * FROM friends 
            WHERE user='$user' AND friend='" . $row['user'] . "'");
        $t2 = $result1->rowCount();
    
        if (($t1 + $t2) > 1) {
            echo " &harr; is a mutual friend";
        } elseif ($t1) {
            echo " &larr; you are following";
        } elseif ($t2) {
            echo " &rarr; is following you";
            $follow = "recip";
        }
    
        if (!$t1) {
            echo " [<a data-transition='slide' 
                href='members.php?add=" . $row['user'] . "&r=$randstr'>$follow</a>]";
        } else {
            echo " [<a data-transition='slide' 
                href='members.php?remove=" . $row['user'] . "&r=$randstr'>drop</a>]";
        }
    }
    



?>
</ul></div>
</body>
</html>