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

    function destroySesssion() {
        $_SESSION=array();
        if(session_id() != "" || isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-2592000, '/');
        } else {
            session_destroy();
        }
    }

    function sanitizeString($var) {

    }

    function showProfile($user) {
        
    }


?>