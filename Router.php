<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];


    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {

        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?') ?: '';
        $method = $_SERVER['REQUEST_METHOD'];
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptName !== '' && str_starts_with($currentUrl, $scriptName)) {
            $currentUrl = substr($currentUrl, strlen($scriptName));
        }


        $fn = $method === 'GET'
            ? ($this->getRoutes[$currentUrl] ?? null)
            : ($this->postRoutes[$currentUrl] ?? null);


        if ($fn) {
            call_user_func($fn, $this);
        } else {
            http_response_code(404);
            $this->render('error/404', [
                'titulo' => 'Página no encontrada'
            ]);
        }
    }


    public function render($view, $datos = [])
    {
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once __DIR__ . "/views/{$view}.php";
        include_once __DIR__ . "/views/layout.php";
    }
}
