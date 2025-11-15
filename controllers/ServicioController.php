<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController
{
    public static function index(Router $router)
    {
        session_start();

        es_Admin();

        $servicios = Servicio::all();

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router)
    {
        session_start();
        es_Admin();

        $servicio = new Servicio;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $resultado = $servicio->guardar();
                if ($resultado) {
                    header('Location: ' . $_ENV['APP_URL'] . '/servicios');
                    exit;
                }
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router)
    {
        session_start();
        es_Admin();

        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            header('Location: ' . $_ENV['APP_URL'] . '/servicios');
            exit;
        }

        $servicio = Servicio::find($id);
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: ' . $_ENV['APP_URL'] . '/servicios');
                exit;
            }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

public static function eliminar(Router $router = null)
{
    session_start();
    es_Admin(); // si quieres controlar permisos

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: ' . $_ENV['APP_URL'] . '/servicios');
            exit;
        }

        $servicio = Servicio::find($id);
        if ($servicio) {
            $servicio->eliminar(); // Método del modelo
        }

        header('Location: ' . $_ENV['APP_URL'] . '/servicios');
        exit;
    }
}


}
