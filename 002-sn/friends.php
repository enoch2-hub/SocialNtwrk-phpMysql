<?php

    require_once 'header.php';

    if(!$loggedin) die("</div></body></html>");

    // Retrieve and Sanitize view Parameter
    if(isset($_GET['view'])) {
        $view = sanitizeString($_GET['view']);
    } else {
        $view = $user;
    }



    //Set display names based on view
    if ($view == $user) {
        $name1 = $name2 = "Your";
        $name3 = "You are";
    } else {
        $name1 = "<a data-transition='slide' href='member.php?view=$view&r=$randstr'>$view</a>'s";
        $name2 = "$view's";
        $name3 = "$view is";
    }



    //Retrieve followers and following
    $followers = array();
    $following = array();
    
    $result = queryMysql("SELECT * FROM friends WHERE user='$view'");
    while($row = $result->fetch()) {
        // $followers[$j] = $row['friend'];
        $followers[] = $row['friend'];
    }

    $result = queryMysql("SELECT * FROM friends WHERE friend='$view'");
    while($row = $result->fetch()) {
        // $following[$j] = $row['user'];
        $following[] = $row['user'];
    }



    //Determine mutual friends
    $mutual = array_intersect($followers, $following);
    $followers = array_diff($followers, $mutual);
    $following = array_diff($following, $mutual);



    //Display Friends, Followers, and Following
    $friends = FALSE;
    echo "<br>";

    if (sizeof($mutual)) {
        echo "<span class='subhead'>$name2 mutual friends</span><ul>";
        foreach($mutual as $friend) {
            echo "<li><a data-transition='slide' 
                href='members.php?view=$friend&r=$randstr'>$friend</a></li>";
        }
        echo "</ul>";
        $friends = TRUE;
    }

    if (sizeof($followers)) {
        echo "<span class='subhead'>$name2 followers</span><ul>";
        foreach($followers as $friend) {
            echo "<li><a data-transition='slide'
                href='members.php?view=$friend&r=$randstr'>$friend</a></li>";
        }
        echo "</ul>";
        $friends = TRUE;
    }

    if (sizeof($following)) {
        echo "<span class='subhead'>$name3 following</span><ul>";
        foreach($mutual as $friend) {
            echo "<li><a data-transition='slide'
                href='members.php?view=$friend&r=$randstr'>$friend</a></li>";
        }
        echo "</ul>";
        $friends = TRUE;
    }

    if(!$friends) echo "<br>You don't have any friends yet.";

?>


        </div><br>
    </body>
</html