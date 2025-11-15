<?php ob_start(); ?> 

<h1 class="nombre-pagina">Confirma tu cuenta</h1>

<p class="descripcion-pagina">Confirmar tu cuenta a tu email.</p>

<?php $contenido = ob_get_clean(); ?> 

<?php include_once __DIR__ . "/../layout.php"; ?>