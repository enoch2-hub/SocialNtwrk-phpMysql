<!-- signup -->



<?php

    require_once 'header.php';


echo <<<_END

    <script>
        function checkUser(user) {
            if(user.value=== '') {
                $('#used').html('&nbsp;')
                return
            } else {
                $.post('checkuser.php')
            }
        
_END;



echo <<<_END

<form action="POST" action="signup.php?r=$randstr">$error

    <div data-role="fieldcontain">
        <label for="">Please enter your details</label>
    </div>

    <div data-role="fieldcontain">
        <label for="">Username</label>
        <input type="text" maxlength="16" name="user" 
        value="$user" onBlur="checkUser(this)">
        <label for=""></label><div id="used">&nbsp;</div>
    </div>

    <div data-role="fieldcontain">
        <label for="">Password</label>
        <input type="password" maxlength="16" name="pass" value="$pass">
    </div>

    <div data-role="fieldcontain">
        <label for=""></label>
        <input type="submit" data-transition="slide" value="Sign Up">
    </div>

</form>


_END;

?>