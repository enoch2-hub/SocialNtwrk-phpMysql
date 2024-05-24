<!-- Functions.php -->

<?php

    $host = 'localhost';
    $data = 'robinsnest';
    $user = 'robinsnest';
    $pass = 'password';
    $chrs = 'utf8mb4';
    $attr = "mysql:host=$host;dbname=$data;charset=$chrs";
    $opts = [
        PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=> PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES  => false,
    ];

    try {
        $pdo = new PDO($attr, $user, $pass, $opts);
    } catch(\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
    
    function createTable($name, $query) {
        queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
        echo "Table '$name' created or already exists.<br>";
    }
    
    function queryMysql($query) {
        global $pdo;
        return $pdo->query($query);
    }

    function destroySession() {
        $_SESSION=array();
        if(session_id() != "" || isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-2592000, '/');
        } else {
            session_destroy();
        }
    }

    function sanitizeString($var) {
        global $pdo;
        $var = strip_tags($var);//prevents users from injecting HTML or JS
        $var = htmlentities($var);//prevents special charactersto HTML entities
        
        // if(get_magic_quotes_gpc())//checks if the magic quotes feature is enabled 
        // // which automatically escape special characters in input data 
        // //(by adding backslashes before quotes).
        // {
        //     $var = stripcslashes($var);
        // } 
        $result = $pdo->quote($var);// Quote the string for use in a SQL query, adding single quotes
        return str_replace("'", "", $result);//Remove the added single quotes
    }
    // The sanitizeString function:
    //     1-Removes any HTML and PHP tags to prevent HTML/JavaScript injection.
    //     2-Converts special characters to HTML entities.
    //     3-Checks and removes magic quotes if enabled.
    //     4-Uses the PDO quote method to escape the string for SQL safety.
    //     5-Removes the quotes added by the quote method to return a clean, escaped string.

    function showProfile2($user) {
        if(file_exists("$user.jpg")) {
            echo "<img src='$user.jpg' style='float:left; border-radius=10rem;'>";
        } 
        global $pdo;
        $result = $pdo->query("SELECT * FROM profiles WHERE user='$user'");

        while ($row = $result->fetch()) {
            die(stripslashes($row['text']) . "<br style='clear:left;'> <br>");
        }

        echo "<p>Nothing to see here, yet</p><br>";
    }


    function showProfile($user) {
        if (file_exists("$user.jpg")) {
            echo "<img src='$user.jpg' style='float:left;'>";
        }
    
        global $pdo;
        // Use a prepared statement to avoid SQL injection
        $stmt = $pdo->prepare("SELECT * FROM profiles WHERE user = :user");
        $stmt->execute(['user' => $user]);
    
        if ($row = $stmt->fetch()) {
            echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
        } else {
            echo "<p>Nothing to see here, yet</p><br>";
        }
    }
    
    


?>