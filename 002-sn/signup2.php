<?php // Example 05: signup.php

// Include the 'header.php' file, which likely contains HTML header information and possibly some initial PHP setup.
require_once 'header.php';

// Output a block of JavaScript code. The _END markers are used for multi-line strings.
echo <<<_END
<script>
function checkUser(user)
{
    if (user.value == '')
    {
        $('#used').html('&nbsp;');
        return;
    }
    $.post
    (
        'checkuser.php',
        { user : user.value },
        function(data)
        {
            $('#used').html(data);
        }
    );
}
</script>
_END;

// Initialize error, user, and pass variables as empty strings.
$error = $user = $pass = "";

// If a session user is already set, destroy the session (log out the user).
if (isset($_SESSION['user'])) destroySession();

// Check if the form has been submitted with a username.
if (isset($_POST['user']))
{
    // Sanitize the user input to prevent SQL injection.
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    
    // Check if either the username or password fields are empty.
    if ($user == "" || $pass == "")
    {
        $error = 'Not all fields were entered<br><br>';
    }
    else
    {
        // Query the database to check if the username already exists.
        $result = queryMysql("SELECT * FROM members WHERE user='$user'");
        
        // If the username already exists, set an error message.
        if ($result->rowCount())
        {
            $error = 'That username already exists<br><br>';
        }
        else
        {
            // Insert the new user into the database and prompt the user to log in.
            queryMysql("INSERT INTO members VALUES('$user', '$pass')");
            die('<h4>Account created</h4>Please Log in.</div></body></html>');
        }
    }
}

// Output the signup form HTML.
echo <<<_END
<form method='post' action='signup.php?r=$randstr'>$error
<div data-role='fieldcontain'>
    <label></label>
    Please enter your details to sign up
</div>
<div data-role='fieldcontain'>
    <label>Username</label>
    <input type='text' maxlength='16' name='user' value='$user' onBlur='checkUser(this)'>
    <label></label><div id='used'>&nbsp;</div>
</div>
<div data-role='fieldcontain'>
    <label>Password</label>
    <input type='text' maxlength='16' name='pass' value='$pass'>
</div>
<div data-role='fieldcontain'>
    <label></label> 
    <input data-transition='slide' type='submit' value='Sign Up'>
</div>
</div>
</body>
</html>
_END;

?>
