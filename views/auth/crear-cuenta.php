<?php ob_start(); ?> 

<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente el formulario.</p>

<?php
include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="crear-cuenta">

    <div class="campo">
        <label for="nombre">Nombre</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Tu Nombre"
            value="<?php echo sanitizar($usuario->nombre); ?>"
            autocomplete="given-name" />
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Tu Apellido"
            value="<?php echo sanitizar($usuario->apellido); ?>"
            autocomplete="family-name" />
    </div>

    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input
            type="tel"
            id="telefono"
            name="telefono"
            placeholder="Tu Teléfono"
            value="<?php echo sanitizar($usuario->telefono); ?>"
            autocomplete="tel" />
    </div>

    <div class="campo">
        <label for="email">E-mail</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="Tu E-mail"
            value="<?php echo sanitizar($usuario->email); ?>"
            autocomplete="email" />
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Tu Password"
            autocomplete="new-password" />
    </div>

    <input type="submit" value="Crear Cuenta" class="boton">

</form>
<div class="acciones">
    <a href="<?= $_ENV['APP_URL']; ?>">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="<?= $_ENV['APP_URL']; ?>olvide">¿Olvidaste tu password?</a>
</div>

<?php $contenido = ob_get_clean(); ?> 

<?php include_once __DIR__ . "/../layout.php"; ?>