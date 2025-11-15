<h1><?= $titulo ?? 'Error 404' ?></h1>
<p>La página que buscas no existe.</p>
<a href="<?= $_ENV['APP_URL'] ?>">Regresar al inicio</a>