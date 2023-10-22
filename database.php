<?php
// PDO = PHP Database Object.

$dataSourceName = "mysql:host=localhost;dbname=world";
$username = "root";
// $password = "pa55word";

try {
    $database = new PDO($dataSourceName, $username, /* $password */);
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
    exit();
}
?>