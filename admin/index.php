<?php
session_start();

// Verificar que el usuario sea admin (opcional)
// Por ahora solo verificamos que esté logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../Frontend/login.php');
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
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Obtener todos los productos
    $stmt = $pdo->query("SELECT * FROM productos ORDER BY id DESC");
    $productos = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Error de conexión: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración - AGS Pops</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1200px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        h1 { color: #1C2541; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #1C2541; color: white; }
        tr:hover { background: #f1f1f1; }
        .btn { display: inline-block; padding: 8px 16px; margin: 2px; text-decoration: none; border-radius: 4px; }
        .btn-agregar { background: #6B8E23; color: white; }
        .btn-editar { background: #A94A42; color: white; }
        .btn-eliminar { background: #c0392b; color: white; }
        .btn-volver { background: #1C2541; color: white; }
        .mensaje { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .mensaje-exito { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .mensaje-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .acciones { display: flex; gap: 5px; flex-wrap: wrap; }
    </style>
</head>
<body>
    <h1>📦 Administración de Productos</h1>
    <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Admin', ENT_QUOTES, 'UTF-8'); ?></p>

    <div style="margin: 20px 0; display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="agregar.php" class="btn btn-agregar">➕ Agregar Producto</a>
        <a href="../index.php" class="btn btn-volver">🏠 Ir a la tienda</a>
        <a href="../Frontend/logout.php" class="btn btn-eliminar">🚪 Cerrar sesión</a>
    </div>

    <?php if (isset($_GET['mensaje'])): ?>
        <div class="mensaje mensaje-exito"><?php echo htmlspecialchars($_GET['mensaje'], ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="mensaje mensaje-error"><?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="mensaje mensaje-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (empty($productos)): ?>
        <p>No hay productos cargados. <a href="agregar.php">Agregá el primero</a>.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $p): ?>
                <tr>
                    <td><?php echo $p['id']; ?></td>
                    <td><?php echo htmlspecialchars($p['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>$<?php echo number_format($p['precio'], 0, ',', '.'); ?></td>
                    <td><?php echo $p['stock']; ?></td>
                    <td><?php echo htmlspecialchars($p['categoria_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo $p['imagen'] ? '✅' : '❌'; ?></td>
                    <td>
                        <div class="acciones">
                            <a href="editar.php?id=<?php echo $p['id']; ?>" class="btn btn-editar">✏️ Editar</a>
                            <a href="eliminar.php?id=<?php echo $p['id']; ?>" class="btn btn-eliminar" onclick="return confirm('¿Seguro que querés eliminar este producto?')">🗑️ Eliminar</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>Total: <?php echo count($productos); ?> productos</p>
    <?php endif; ?>
</body>
</html>