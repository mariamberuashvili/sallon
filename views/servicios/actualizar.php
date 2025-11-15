<h1 class="nombre-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Modifica del formulario</p>

<?php
include_once __DIR__ . "/../templates/barra.php";
include_once __DIR__ . "/../templates/alertas.php";
?>

<form action="<?= $_ENV['APP_URL']; ?>/servicios/actualizar?id=<?= $servicio->id ?>" method="POST" class="formulario">
    <?php include_once __DIR__ . "/formulario.php"; ?>
    <input type="submit" class="boton" value="Actualizar">
</form>