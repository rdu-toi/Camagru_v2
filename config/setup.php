<?php

$DB_DSN_SHORT = "mysql:host=localhost;charset=utf8";
$DB_NAME = "Camagru";
$DB_USER = "root";
$DB_PASSWORD = "administrator";

//Create database "Camagru"

try {
    $conn = new PDO($DB_DSN_SHORT, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE $DB_NAME";
    $conn->exec($sql);
    echo "Database created successfully<br>";
}
catch(PDOException $e){
    echo "An error occured creating the database 'Camagru' " . $e->getMessage() . "\n";
}

$conn = null;

//Create table "User_info"

try {
    $conn = new PDO("$DB_DSN_SHORT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE `User_info` (
        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(30) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `email` VARCHAR(50),
        `token` VARCHAR(255),
        `status` INT NOT NULL DEFAULT '0',
        `comemail` INT NOT NULL DEFAULT '0'
    )";

    $conn->exec($sql);
    echo "Table User_info created successfully\n";
    }
catch(PDOException $e)
    {
    echo "An error occured creating the table 'User_info' " . $e->getMessage() . "\n";
    }

$conn = null;

//Create table "Gallery"

try {
    $conn = new PDO("$DB_DSN_SHORT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE `Gallery` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `userid` INT(100) NOT NULL,
        `username` VARCHAR(30),
        `photo` MEDIUMTEXT NOT NULL,
        `likes` MEDIUMINT NOT NULL DEFAULT '0'
    )";

    $conn->exec($sql);
    echo "Table Gallery created successfully\n";
    }
catch(PDOException $e)
    {
    echo "An error occured creating the table 'Gallery' " . $e->getMessage() . "\n";
    }

$conn = null;

//Create table "Comments"

try {
    $conn = new PDO("$DB_DSN_SHORT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE Comments (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `photoid` INT(100) NOT NULL,
        `username` VARCHAR(30) NOT NULL,
        `comment` VARCHAR(300)
    )";

    $conn->exec($sql);
    echo "Table Comments created successfully";
    header("Location:../index.php?success=" .urlencode("Camagru database and associated tables successfully created!"));
    exit();
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;