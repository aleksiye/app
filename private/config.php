<?php
session_start();
try {
    $conn = new PDO("mysql:host=" . $_SERVER['DB_HOST'] . ";dbname=" . $_SERVER['DB_NAME'] . ";charset=utf8", $_SERVER['DB_USER'], $_SERVER['DB_PASS']);

    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    echo $ex->getMessage();
}