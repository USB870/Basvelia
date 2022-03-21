<?php
    define('USER', 'basvelia');
    define('PASSWORD', '');
    define('HOST', 'localhost');
    define('DATABASE', 'my_basvelia');
    try {
        $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
?>
