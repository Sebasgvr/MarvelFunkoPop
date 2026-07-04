<?php
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../Frontend/login.php');
    exit;
}

// Verificar que se pasó un ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php?error=ID+no+válido');
    exit;
}

$id = (int) $_GET['id'];

if ($id <= 0) {
    header('Location: index.php?error=ID+no+válido');
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

    // Verificar que el producto existe
    $stmt = $pdo->prepare("SELECT id FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    if (!$stmt->fetch()) {
        header('Location: index.php?error=Producto+no+encontrado');
        exit;
    }

    // Eliminar el producto
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: index.php?mensaje=Producto+eliminado+correctamente');
    exit;

} catch (PDOException $e) {
    header('Location: index.php?error=' . urlencode($e->getMessage()));
    exit;
}
?>