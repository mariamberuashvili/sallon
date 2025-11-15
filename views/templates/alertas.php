<?php if (!empty($alertas)): ?>
    <?php foreach ($alertas as $key => $mensajes): ?>
        <?php foreach ($mensajes as $mensaje): ?>
            <div class="alerta <?php echo htmlspecialchars($key); ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>