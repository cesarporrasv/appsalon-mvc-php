<h1 class="page-name">Servicios</h1>
<p class="page-description">Administracion de Servicios</p>

<?php
include_once __DIR__ . '/../templates/bar.php';
?>

<ul class="services">
    <?php foreach ($services as $service) { ?>
        <li>
            <p>Nombre: <span><?php echo $service->name; ?></span></p>
            <p>Precio: <span>$<?php echo $service->price; ?></span></p>

            <div class="actions">
                <a class="button" href="/services/update?id=<?php echo $service->id; ?>">Actualizar</a>

                <form action="/services/delete" method="POST">
                    <input type="hidden" name="id" value="<?php echo $service->id; ?>">

                    <input class="delete-button" type="submit" value="Eliminar">
                </form>
            </div>
        </li>
    <?php } ?>
</ul>