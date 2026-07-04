<?php
// Iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'path' => '/tienda_funkos/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// Destruir la sesión
session_unset();
session_destroy();

// Redirigir a la página de colección (o index)
header('Location: coleccion.php');
exit;
?>