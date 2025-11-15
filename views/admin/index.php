<?php ob_start(); ?> 

<h1 class="nombre-pagina">Administración</h1>

<?php include_once __DIR__ . "/../templates/barra.php"; ?>

<p class="descripcion-pagina">Buscar Citas</p>

<form class="formulario">
    <div class="campo">
        <label for="fecha">Fecha</label>
        <input type="date" id="fecha" name="fecha" value="<?= $fecha; ?>">
    </div>
</form>

<?php if (empty($citas)) : ?>
    <h2>No hay citas para esta fecha</h2>
<?php else : ?>
    <div id="citas-admin">
        <ul class="citas">
            <?php foreach ($citas as $cita):
                $servicios = explode(', ', $cita['servicios']);
                $precios = explode(',', $cita['precios']);
                $total = array_sum($precios);
            ?>
                <li>
                    <p><strong>ID:</strong> <?= $cita['id']; ?></p>
                    <p><strong>Hora:</strong> <?= $cita['hora']; ?></p>
                    <p><strong>Cliente:</strong> <?= $cita['cliente']; ?></p>
                    <p><strong>Email:</strong> <?= $cita['email']; ?></p>
                    <p><strong>Teléfono:</strong> <?= $cita['telefono']; ?></p>

                    <h3>Servicios</h3>
                    <?php foreach ($servicios as $i => $servicio): ?>
                        <p><?= htmlspecialchars($servicio) . "€" . htmlspecialchars($precios[$i]); ?></p>
                    <?php endforeach; ?>

                    <p><strong>Total:</strong> <?= htmlspecialchars($total); ?> €</p>

                    <form action="<?= $_ENV['APP_URL']; ?>/api/eliminar" method="POST" class="form-eliminar">
                        <input type="hidden" name="id" value="<?= $cita['id']; ?>">
                        <input type="submit" class="boton-eliminar" value="Eliminar">
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fechaInput = document.querySelector('#fecha');
        if (fechaInput) {
            fechaInput.addEventListener('input', function(e) {
                const fechaSeleccionada = e.target.value;
                if (fechaSeleccionada) {
                    window.location = `<?= $_ENV['APP_URL']; ?>/admin?fecha=${fechaSeleccionada}`;
                }
            });
        }


        document.querySelectorAll('.form-eliminar').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('¿Deseas eliminar esta cita?')) {
                    form.submit();
                }
            });
        });
    });
</script>

<?php $contenido = ob_get_clean(); ?> 

<?php include_once __DIR__ . "/../layout.php"; ?>