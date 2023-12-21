<h1 class="page-name">Crear Cuenta</h1>
<p class="page-description">Llena el siguiente formulario para crearla</p>

<?php
     include_once __DIR__ . "/../templates/alerts.php"; 
?>

 <form class="form" method="POST" action="/create-account">
 
    <div class="field">
        <label for="name">Nombre</label>
        <input 
        type="text"
        id="name"
        name="name"
        placeholder="Tu Nombre"
        value="<?php echo snz($user->name); ?>"
        />
    </div>

    <div class="field">
        <label for="lastname">Apellido</label>
        <input 
        type="text"
        id="lastname"
        name="lastname"
        placeholder="Tu Apellido"
        value="<?php echo snz($user->lastname); ?>"
        />
    </div>

    <div class="field">
        <label for="telephone">Teléfono</label>
        <input 
        type="tel"
        id="telephone"
        name="telephone"
        placeholder="Tu Teléfono"
        value="<?php echo snz($user->telephone); ?>"
        />
    </div>

    <div class="field">
        <label for="email">Email</label>
        <input 
        type="email"
        id="email"
        name="email"
        placeholder="Tu Email"
        value="<?php echo snz($user->email); ?>"
        />
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input 
        type="password"
        id="password"
        name="password"
        placeholder="Tu Password"
        />
    </div>

    <input type="submit" class="button" value="Crear Cuenta">

</form>

<div class="actions">
    <a href="/">¿Ya tienes una Cuenta? Inicia Sesión</a>
    <a href="/forgot-password">Olvidé mi Password</a>
</div>