<?php ob_start(); ?> 

<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Nuevo password</p>

<?php
include_once __DIR__ . "/../templates/alertas.php";
?>

<?php if ($error) return; ?>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Tu Nuevo Password" />
    </div>
    <input type="submit" class="boton" value="Guardar Nuevo Password">

</form>
<div class="acciones">
    <a href="<?= $_ENV['APP_URL']; ?>">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="crear-cuenta">Crear cuenta</a>
</div>

<?php $contenido = ob_get_clean(); ?> 

<?php include_once __DIR__ . "/../layout.php"; ?>