<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../Frontend/login.php');
    exit;
}

$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: index.php?error=ID+no+válido');
    exit;
}

$host = 'localhost';
$dbname = 'tienda_funkos';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener producto
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch();

    if (!$producto) {
        header('Location: index.php?error=Producto+no+encontrado');
        exit;
    }

    // Obtener categorías
    $stmt = $pdo->query("SELECT * FROM categorias ORDER BY nombre");
    $categorias = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Error de conexión: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto - Administración</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        h1 { color: #1C2541; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        input[type="submit"] { background: #A94A42; color: white; border: none; padding: 12px; font-weight: bold; cursor: pointer; }
        input[type="submit"]:hover { background: #8f3f38; }
        .btn-volver { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #1C2541; color: white; text-decoration: none; border-radius: 4px; }
        .mensaje-error { padding: 10px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h1>✏️ Editar Producto</h1>

    <?php if (isset($error)): ?>
        <div class="mensaje-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="../backend/api/producto_editar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

        <label>Nombre del producto *</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label>Descripción</label>
        <textarea name="descripcion" rows="3"><?php echo htmlspecialchars($producto['descripcion'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>

        <label>Precio *</label>
        <input type="number" name="precio" step="0.01" value="<?php echo $producto['precio']; ?>" required>

        <label>Stock *</label>
        <input type="number" name="stock" value="<?php echo $producto['stock']; ?>" required>

        <label>Categoría</label>
        <select name="categoria_id">
            <option value="">Sin categoría</option>
            <?php foreach ($categorias as $c): ?>
                <option value="<?php echo $c['id']; ?>" <?php echo ($c['id'] == $producto['categoria_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($c['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>URL de imagen</label>
        <input type="text" name="imagen" value="<?php echo htmlspecialchars($producto['imagen'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="https://ejemplo.com/imagen.jpg">

        <input type="submit" value="Actualizar Producto">
    </form>

    <a href="index.php" class="btn-volver">← Volver al panel</a>
</body>
</html>