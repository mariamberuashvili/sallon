<?php

function debuguar($variable) : void {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function sanitizar($html) : string {
    return htmlspecialchars($html);
}

function ultimo(string $actual, string $proximo) : bool {
    return $actual !== $proximo;
}

function es_Auth() : void {
    if (!isset($_SESSION["login"])) {
       header('Location: ' . $_ENV['APP_URL'] . '/');

        exit;
    }
}

function es_Admin() : void {
    if (!isset($_SESSION["admin"])) {
      header('Location: ' . $_ENV['APP_URL'] . '/');

        exit;
    }
}
