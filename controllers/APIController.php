<?php

namespace Controllers;

use Model\Cita;
use Model\DetalleCita;
use Model\Servicio;


class APIController
{
    public static function index()
    {
        $servicios = Servicio::all();

        echo json_encode($servicios);
    }


    public static function guardar()
    {
        
        $cita = new Cita([
            'usuario_id' => $_POST['usuario_id'],
            'fecha' => $_POST['fecha'],
            'hora' => $_POST['hora']
        ]);
        $resultado = $cita->guardar();
        $idCita = $resultado['id'];


        $idServicios = $_POST['servicios'];
        foreach ($idServicios as $idServicio) {
            $detalle = new DetalleCita([
                'cita_id' => $idCita,
                'servicio_id' => $idServicio
            ]);
            $detalle->guardar();
        }

        echo json_encode(['resultado' => $resultado]);
    }


    public static function eliminar()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location: ' . $_ENV['APP_URL'] . '/cita');
        }
    }
}
