<?php ob_start(); ?> 

<h1 class="nombre-pagina">Confirmar Cuenta</h1>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<div class="acciones">
    <a href="<?= $_ENV['APP_URL']; ?>">Iniciar Sesión</a>
</div>


<?php $contenido = ob_get_clean(); ?> 

<?php include_once __DIR__ . "/../layout.php"; ?>