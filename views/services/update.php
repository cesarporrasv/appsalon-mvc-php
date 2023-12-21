<h1 class="page-name">Actualizar Servicio</h1>
<p class="page-description">Completa los campos para actualizar los servicios</p>

<?php
    include_once __DIR__ . '/../templates/bar.php';
    include_once __DIR__ . '/../templates/alerts.php';
?>

<form method="POST" class="form">
    <?php include_once __DIR__. '/form.php' ?>
    <input type="submit" class="button" value="Actualizar">
</form>