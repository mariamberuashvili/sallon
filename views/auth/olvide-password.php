<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Recuperar tu password</p>

<?php
include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" action="olvide" method="POST">
    <div class="campo">
        <label for="email">email</label>
        <input type="email" id="email" name="email" placeholder="Tu email" />
    </div>

    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>

<div class="acciones">
    <a href="<?= $_ENV['APP_URL']; ?>">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="crear-cuenta">Crear cuenta</a>
</div>
