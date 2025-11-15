<?php ob_start(); ?> 

<h1><?= $titulo ?? 'Error 404' ?></h1>
<p>La página que buscas no existe.</p>
<a href="<?= $_ENV['APP_URL'] ?>">Regresar al inicio</a>

<?php $contenido = ob_get_clean(); ?> 

<?php include_once __DIR__ . "/../layout.php"; ?>