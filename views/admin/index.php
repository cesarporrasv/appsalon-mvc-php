<h1 class="page-name">Panel de Administración</h1>

<?php

use Model\Appointment;

include_once __DIR__ . '/../templates/bar.php';
?>

<h2>Buscar Citas</h2>
<div class="search">
    <form class="form">
        <div class="field">
            <label for="date">Fecha</label>
            <input 
                type="date" 
                id="date" 
                name="date" 
                value="<?php echo $date; ?>"
            />
        </div>
    </form>
</div>

<?php
    if(count($appointments) === 0) {
        echo "<h2>No hay citas para esta fecha</h2>";
    }
?>

<div id="admin-appointments">
    <ul class="appointments">
        <?php
        $appointmentId = '';
        foreach ($appointments as $key => $appointment) {
            if ($appointmentId !== $appointment->id) {
                $total = 0;
        ?>
                <li>
                    <p>ID: <span><?php echo $appointment->id; ?></p>
                    <p>Hora: <span><?php echo $appointment->time; ?></p>
                    <p>Cliente: <span><?php echo $appointment->customer; ?></p>
                    <p>Email: <span><?php echo $appointment->email; ?></p>
                    <p>Teléfono: <span><?php echo $appointment->telephone; ?></p>

                    <h3>Servicios</h3>
                <?php
                $appointmentId = $appointment->id;
            } // Fin de if 
            $total += $appointment->price;
                ?>
                <p class="service"><?php echo $appointment->service . " " . "$" . $appointment->price; ?></p>

                <?php
                $current = $appointment->id;
                $next = $appointments[$key + 1]->id ?? 0;

                if (theLast($current, $next)) { ?>
                    <p class="total">Total: <span>$ <?php echo $total; ?></span></p>

                    <form action="/api/delete" method="POST">
                        <input type="hidden" name="id" value="<?php echo $appointment->id; ?>">
                        <input type="submit" class="delete-button" value="eliminar">
                    </form>

            <?php }
            } // Fin de foreach
            ?>
    </ul>
</div>

<?php  
    $script = "<script src='build/js/searcher.js'></script>"
 ?>