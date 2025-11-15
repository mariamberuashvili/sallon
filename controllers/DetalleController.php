<?php


namespace Controllers;


use MVC\Router;


class DetalleController
{
    public static function index(Router $router)
    {

        session_start();

        es_Auth();


        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'id' => $_SESSION['id'] ?? null
        ]);
    }
}
