<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Salón' ?></title>
    <link rel="stylesheet" href="<?= $_ENV['APP_URL']; ?>/build/css/app.css">
</head>

<body>
    <div class="contenedor-app">
        <div class="imagen"></div>

        <div class="app">
            <?= $contenido ?? '' ?>

            <footer class="footer">
                <p>© <?= date('Y'); ?> Salón</p>
            </footer>
        </div>
    </div>

    <script>
        const APP_URL = "<?= $_ENV['APP_URL']; ?>";
    </script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= $_ENV['APP_URL']; ?>/build/js/buscador.js"></script>
    <script src="<?= $_ENV['APP_URL']; ?>/build/js/app.js"></script>
</body>

</html>