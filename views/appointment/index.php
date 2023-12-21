<h1 class="page-name">Crear Nueva Cita</h1>
<p class="page-description">Elige tu Servicios y coloca tus datos</p>

<?php
    include_once __DIR__ . '/../templates/bar.php';
?>

<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-step="1">Servicios</button>
        <button type="button" data-step="2">Informacion Cita</button>
        <button type="button" data-step="3">Resumen</button>
    </nav>

    <div id="step-1" class="section">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div id="services" class="services-list"></div>
    </div>

    <div id="step-2" class="section">
        <h2>Tus Datos y Cita</h2>
        <p class="text-center">Inserta tus datos y fecha de cita</p>

        <form class="form">
            <div class="field">
                <label for="name">Nombre</label>
                <input 
                    id="name"
                    type="text"
                    placeholder="Tu Nombre"
                    value="<?php echo $name; ?>"
                    disabled
                />
            </div>

            <div class="field">
                <label for="date">Fecha</label>
                <input 
                    id="date"
                    type="date"
                    min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                />
            </div>

            <div class="field">
                <label for="time">Hora</label>
                <input 
                    id="time"
                    type="time"
                />
            </div>

            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form>
    </div>

    <div id="step-3" class="section summary-content">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la información sea correcta</p>
    </div>

    <div class="pagination">
        <button
            id="previous"
            class="button"
        >&laquo; Anterior</button>

        <button
            id="next"
            class="button"
        >Siguiente &raquo;</button>
    </div>
</div>

<?php
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";
?>