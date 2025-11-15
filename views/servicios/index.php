<?php ob_start(); ?> 


<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administración de Servicios</p>

<?php
include_once __DIR__ . "/../templates/barra.php";
?>

<ul class="servicios">
    <?php foreach ($servicios as $servicio) { ?>
        <li>
            <p>Nombre: <span><?php echo $servicio->nombre; ?></span> </p>
            <p>Precio: <span>€<?php echo $servicio->precio; ?></span> </p>

            <div class="acciones">
                <a class="boton" href="<?= $_ENV['APP_URL']; ?>/servicios/actualizar?id=<?= $servicio->id; ?>">Actualizar</a>

                <form action="servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?= $servicio->id; ?>">
                    <input type="submit" value="Eliminar" class="boton-eliminar">
                </form>

            </div>
        </li>
    <?php } ?>
</ul>


<?php $contenido = ob_get_clean(); ?> 

<?php include_once __DIR__ . "/../layout.php"; ?>