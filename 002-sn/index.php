<?php

    require_once 'header.php';

    echo "<div class='center'> Welcome to Blobby's Com Center";

    if($loggedin) {
        echo " $user, you are logged in";
    } else {
        echo " please log in or sign up";
    }

    echo  <<<_END

        </div><br>
        <div class='footer' data-role="footer">

            <h4>Web App from <i><a href='https://github.com/RobinNixon/lpmj6'
            target='_blank'>Learning PHP MySQL & JavaScript</a></i></h4>

        </div>

    _END;

?>