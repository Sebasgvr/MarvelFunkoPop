<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../Frontend/login.php');
    exit;
}

$host = 'localhost';
$dbname = 'tienda_funkos';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = (int) ($_POST['id'] ?? 0);
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio = (float) ($_POST['precio'] ?? 0);
    $stock = (int) ($_POST['stock'] ?? 0);
    $categoria_id = $_POST['categoria_id'] ? (int) $_POST['categoria_id'] : null;
    $imagen = trim($_POST['imagen'] ?? '');

    if (empty($nombre) || $precio <= 0 || $id <= 0) {
        header('Location: ../admin/editar.php?id=' . $id . '&error=Datos+inválidos');
        exit;
    }

    $stmt = $pdo->prepare("
        UPDATE productos 
        SET nombre = ?, descripcion = ?, precio = ?, stock = ?, categoria_id = ?, imagen = ?
        WHERE id = ?
    ");
    $stmt->execute([$nombre, $descripcion, $precio, $stock, $categoria_id, $imagen, $id]);

    header('Location: ../../admin/index.php?mensaje=Producto+actualizado+correctamente');
    exit;

} catch (PDOException $e) {
    header('Location: ../../admin/editar.php?id=' . $id . '&error=' . urlencode($e->getMessage()));
    exit;
}
?>