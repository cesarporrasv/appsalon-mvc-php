<h1 class="page-name">Login</h1>
<p class="page-description">inicia sesión con tu cuenta</p>

<?php
     include_once __DIR__ . "/../templates/alerts.php"; 
?>

<form class="form" method="POST" action="/">
    <div class="field">
        <label for="email">Email</label>
        <input 
        type="email" 
        id="email" 
        placeholder="Tu Email" 
        name="email" 
        />
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input 
        type="password" 
        id="password" 
        placeholder="Tu Password" 
        name="password" 
        />
    </div>

    <input type="submit" class="button" value="Iniciar Sesión">
</form>

<div class="actions">
    <a href="/create-account">¿No tienes una Cuenta? Crea una</a>
    <a href="/forgot-password">Olvidé mi Password</a>
</div>