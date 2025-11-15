<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{

    public static function login(Router $router): void
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                /** @var Usuario|null $usuario */
                $usuario = Usuario::where('email', $auth->email);

                if (!$usuario) {
                    Usuario::setAlerta('error', 'El usuario no existe');
                } else {
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {

                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . ' ' . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;



                        if ($usuario->admin == 1) {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: ' . $_ENV['APP_URL'] . '/admin');
                        } else {
                            header('Location: ' . $_ENV['APP_URL'] . '/cita');
                        }
                        exit;
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }


    public static function logout(): void
    {
        session_start();
        $_SESSION = [];
        header('Location: ' . $_ENV['APP_URL']);
        exit;
    }


    public static function olvide(Router $router): void
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                /** @var Usuario|null $usuario */
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario && $usuario->confirmado == 1) {
                    $usuario->crearToken();
                    $usuario->guardar();

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito', 'Revisa tu correo electrónico para las instrucciones');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no está confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }


    public static function recuperar(Router $router): void
    {
        $alertas = [];
        $error = false;

        $token = $_GET['token'] ?? null;
        /** @var Usuario|null $usuario */
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if (empty($alertas) && !$error) {

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if ($resultado['resultado']) {
                    header('Location: ' . $_ENV['APP_URL']);
                    exit;
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router)
    {
        $usuario = new Usuario;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if (empty($alertas)) {

                if ($usuario->existeUsuario()) {
                    $alertas = Usuario::getAlertas();
                } else {

                    $usuario->hashPassword();


                    $usuario->crearToken();


                    $resultado = $usuario->guardar();

                    if ($resultado['resultado']) {

                        $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                        $email->enviarConfirmacion();


                        header('Location: ' . $_ENV['APP_URL'] . '/mensaje');
                        exit;
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }


    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);
    }


    public static function confirmar(Router $router): void
    {
        $alertas = [];
        $token = $_GET['token'] ?? null;
        $usuario = null;

        if (!$token) {
            Usuario::setAlerta('error', 'Token no válido o inexistente');
        } else {
            /** @var Usuario|null $usuario */
            $usuario = Usuario::where('token', $token);
        }

        if (is_null($usuario)) {
            if (empty(Usuario::getAlertas())) {
                Usuario::setAlerta('error', 'Token no válido');
            }
        } else {

            $usuario->confirmado = 1;
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', ['alertas' => $alertas]);
    }
}
