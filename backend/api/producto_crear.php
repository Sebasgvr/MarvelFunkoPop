<?php
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../Frontend/login.php');
    exit;
}

// Conectar a la base de datos
$host = 'localhost';
$dbname = 'tienda_funkos';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio = (float) ($_POST['precio'] ?? 0);
    $stock = (int) ($_POST['stock'] ?? 0);
    $categoria_id = $_POST['categoria_id'] ? (int) $_POST['categoria_id'] : null;
    $imagen = trim($_POST['imagen'] ?? '');

    // Validar datos
    if (empty($nombre) || $precio <= 0) {
        header('Location: ../admin/agregar.php?error=Nombre+precio+son+obligatorios');
        exit;
    }

    // Insertar producto
    $stmt = $pdo->prepare("
        INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$nombre, $descripcion, $precio, $stock, $categoria_id, $imagen]);

    header('Location: ../../admin/index.php?mensaje=Producto+agregado+correctamente');
    exit;

} catch (PDOException $e) {
    header('Location: ../admin/agregar.php?error=' . urlencode($e->getMessage()));
    exit;
}
?>