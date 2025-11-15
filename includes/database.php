<?php
$host = $_ENV['DB_HOST'] ?? null;
$user = $_ENV['DB_USER'] ?? null;
$pass = $_ENV['DB_PASS'] ?? null;
$name = $_ENV['DB_NAME'] ?? null;

if (!$host || !$user || !$name) {
    die("Error: No se cargaron las variables del entorno (.env).");
}

$db = new mysqli($host, $user, $pass, $name);

if ($db->connect_error) {
    die("Error al conectar a la base de datos: " . $db->connect_error);
}

return $db;
