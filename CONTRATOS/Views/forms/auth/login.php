<?php $title = "Iniciar Sesión"; ob_start(); ?>

<div class="login-form">
    <h2>Iniciar Sesión</h2>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="username">Nombre de Usuario</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Ingresar</button>
    </form>
    <div class="links">
        <a href="forgot_password.php">¿Olvidaste tu contraseña?</a>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
include '../layouts/auth.php';
?>