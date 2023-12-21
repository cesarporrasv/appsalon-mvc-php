<h1 class="page-name">Reestablecer Contraseña</h1>
<p class="page-description">Ingresa tu nueva contraseña a continuacíon</p>

<?php
     include_once __DIR__ . "/../templates/alerts.php"; 
?>

<?php if($error) return; ?>
<form class="form" method="POST">
    <div class="field">
            <label for="password">Password</label>
            <input 
                type="password"
                id="password"
                name="password"
                placeholder="Tu Nuevo Password"
            />
    </div>

    <input type="submit" class="button" value="Guardar">
</form>

<div class="actions">
    <a href="/">¿Ya tienes una Cuenta? Inicia Sesión</a>
    <a href="/create-account">¿No tienes una Cuenta? Crea una</a>
</div>