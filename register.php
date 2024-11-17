<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registerStyle.css">
    <title>registroMrBigotes</title>
</head>
<body>
    <div class="form-container">
        <form id="registerForm" action="process_register.php" method="POST"> <!-- Enlace a la página de procesamiento -->
            <h2>Registro de Cliente</h2>    
            <label for="nombre">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono">

            <label for="direccion">Dirección de Envío:</label>
            <textarea id="direccion" name="direccion" required></textarea>

            <button id="register-btn" type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>