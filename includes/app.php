<?php

require_once __DIR__ . '/../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

require_once __DIR__ . '/funciones.php';


require_once __DIR__ . '/database.php';

use Model\ActiveRecord;


$db = new mysqli(
    $_ENV['DB_HOST'] ?? '127.0.0.1',
    $_ENV['DB_USER'] ?? 'root',
    $_ENV['DB_PASS'] ?? '',
    $_ENV['DB_NAME'] ?? 'salon',
    (int) ($_ENV['DB_PORT'] ?? 3306)
);


ActiveRecord::setDB($db);

