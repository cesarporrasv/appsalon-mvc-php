<div class="bar">
    <p><span>Bienvenido: </span><?php echo $name ?? '' ?></p>
    <a class="button" href="/logout">Cerrar Sesión</a>
</div>

<?php if (isset($_SESSION['admin'])) { ?>
    <div class="services-bar">
        <a class="button" href="/admin">Ver Citas</a>
        <a class="button" href="/services">Ver Servicios</a>
        <a class="button" href="/services/create">Nuevo Servicio</a>
    </div>
<?php } ?>