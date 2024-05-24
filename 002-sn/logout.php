<?php

    require_once 'header.php';

    if(isset($_SESSION['user'])) {
        destroySession();
        
        header('Location: '. 'index.php?r=$randstr');

    //the rest is no use, coz the header redirects the page
        echo "<br>
            <div class='center'>
                You've been logged out. Please 
                <a data-transition='slide' href='index.php?r=$randstr'>
                Click here</a>
                to refresh the screen
            </div>";
    } else {
        echo "<div class='center'>You cannot log out because you are
        not logged in</div>";
    }

?>


        </div>
    <body>
</html>