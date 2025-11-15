<?php ob_start(); ?> 
<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="formulario" method="POST" action="">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu email" name="email" />
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu Password" name="password" />
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="<?= $_ENV['APP_URL']; ?>olvide">Olvidado mi password</a>
    <a href="<?= $_ENV['APP_URL']; ?>crear-cuenta">Crear cuenta</a>
</div>

<?php $contenido = ob_get_clean(); ?> 

<?php include_once __DIR__ . "/../layout.php"; ?>
