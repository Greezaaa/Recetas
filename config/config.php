<?php
$env = getenv();
$dbserver = $env['DB_SERVER'] ?? 'localhost';
$dbname = $env['DB_NAME'] ?? 'blog_recetas';
$user = $env['DB_USER'] ?? 'root';
$pwd = $env['DB_PASSWORD'] ?? '';
/* Attempt to connect to MySQL database */
try {
    $pdo = new PDO("mysql:host=" . $dbserver . ";dbname=" . $dbname, $user, $pwd);
    // cambiamos idioma de datos al resibir desde la base de datos
    $acentos = $pdo->query("SET NAMES 'utf8'");
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}