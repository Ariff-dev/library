<?php

$host = 'localhost';
$database = 'practica_1';
$username = 'root';
$password = 'dedica88';

$dsn = "mysql:host=$host;dbname=$database";

try {

    $conn = new PDO($dsn, $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    die("Error de conexión: " . $e->getMessage());
}
