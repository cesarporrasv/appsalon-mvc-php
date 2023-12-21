<h1 class="page-name">Olvidé mi Contraseña</h1>
<p class="page-description">Recupera tu contraseña escribiendo tu Email</p>

<?php
     include_once __DIR__ . "/../templates/alerts.php"; 
?>

<form class="form" method="POST" action="/forgot-password">

<div class="field">
        <label for="email">Email</label>
        <input 
        type="email" 
        id="email" 
        placeholder="Tu Email" 
        name="email" 
        />
    </div>

    <input type="submit" class="button" value="Recuperar Contraseña">

</form>

<div class="actions">
    <a href="/">¿Ya tienes una Cuenta? Inicia Sesión</a>
    <a href="/create-account">¿No tienes una Cuenta? Crea una</a>
</div>