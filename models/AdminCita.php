<?php

namespace Model;

class AdminCita extends ActiveRecord
{
    protected static $tabla = "citas";
    protected static $columnasDB = ["id", "hora", "fecha", "usuario_id"];

    public static function obtenerCitasPorFecha($fecha)
    {
        $fecha = self::$db->escape_string($fecha);

        $consulta = "
            SELECT 
                citas.id,
                citas.hora,
                citas.fecha,
                CONCAT(usuarios.nombre, ' ', usuarios.apellido) AS cliente,
                usuarios.email,
                usuarios.telefono,
                GROUP_CONCAT(servicios.nombre SEPARATOR ', ') AS servicios,
                GROUP_CONCAT(servicios.precio SEPARATOR ',') AS precios
            FROM citas
            LEFT JOIN usuarios ON citas.usuario_id = usuarios.id
            LEFT JOIN detallecita ON detallecita.cita_id = citas.id
            LEFT JOIN servicios ON servicios.id = detallecita.servicio_id
            WHERE citas.fecha = '{$fecha}'
            GROUP BY citas.id
            ORDER BY citas.hora ASC
        ";

        $resultado = self::$db->query($consulta);
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = $registro;
        }
        $resultado->free();
        return $array;
    }
}
