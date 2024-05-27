<!-- signup -->

<?php

    require_once 'header.php';


echo <<<_END

    <script>
        function checkUser(user) {
            if(user.value == '') {
                $('#used').html('&nbsp;')
                return
            } else {
                $.post(
                    'checkUser.php',
                    {user:user.value},
                    function(data){
                        $('#used').html(data)
                    }
                );
            }
        }
    </script>
    
        
_END;

    // Initialize error, user, and pass variables as empty strings.
    $error = $user = $pass = "";
    // If a session user is already set, destroy the session (log out the user).
    if (isset($_SESSION['user'])) {
        destroySession();
    };

    // Check if the form has been submitted with a username.
    if(isset($_POST['user'])){
        // Sanitize the user input to prevent SQL injection.
        $user = sanitizeString($_POST['user']);
        $pass = sanitizeString($_POST['pass']);

        // Check if either the username or password fields are empty, and display error.
        if($user == "" || $pass == "") {
            $error = 'Not all fields were entered<br><br>';
        } else {
            // Query the database to check if the username already exists.
            $result = queryMysql("SELECT * FROM members WHERE user='$user'");

            // If the username already exists, set an error message.
            if($result->rowCount()) {
                $error = 'That username already exists<br>';
            } else {
                // Insert the new user into the database and prompt the user to log in.
                queryMysql("INSERT INTO members VALUES('$user','$pass')");
                die('<h4>Account created</h4>Please Log in.</div></body></html>');
            }
        }
    }




    echo <<<_END
    <form method="post" action="signup.php?r=$randstr" class='signuplogin-form'>
        $error

        <div data-role="fieldcontain">
            <label for="">Please enter your details</label>
        </div>


    <div data-role="fieldcontain">
        <label for="">Username</label>
        <input type="text" maxlength="16" name="user" 
        value="$user" onBlur='checkUser(this)'>

        <label for=""></label><div id="used">&nbsp;</div>
    _END;


    // if(isset($_POST['user'])){
    //     echo `<label for=""></label><div id="used">&nbsp;</div>`;
    // }

      
    echo <<<_END

    </div>

    <div data-role="fieldcontain">
        <label for="">Password</label>
        <input class='password' type="password" maxlength="16" name="pass" value="$pass">
    </div>

    <div data-role="fieldcontain">
        <label for=""></label>
        <input type="submit" data-transition="slide" value="Sign Up">
    </div>

</form>

_END;

?>



