<?php
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../Frontend/login.php');
    exit;
}

// Obtener categorías para el select
$host = 'localhost';
$dbname = 'tienda_funkos';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
    <title>Agregar Producto - Administración</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        h1 { color: #1C2541; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        input[type="submit"] { background: #6B8E23; color: white; border: none; padding: 12px; font-weight: bold; cursor: pointer; }
        input[type="submit"]:hover { background: #55711c; }
        .btn-volver { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #1C2541; color: white; text-decoration: none; border-radius: 4px; }
        .mensaje-error { padding: 10px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h1>➕ Agregar Producto</h1>

    <?php if (isset($error)): ?>
        <div class="mensaje-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="../backend/api/producto_crear.php" method="POST">
        <label>Nombre del producto *</label>
        <input type="text" name="nombre" required>

        <label>Descripción</label>
        <textarea name="descripcion" rows="3"></textarea>

        <label>Precio *</label>
        <input type="number" name="precio" step="0.01" required>

        <label>Stock *</label>
        <input type="number" name="stock" value="0" required>

        <label>Categoría</label>
        <select name="categoria_id">
            <option value="">Sin categoría</option>
            <?php foreach ($categorias as $c): ?>
                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['nombre'], ENT_QUOTES, 'UTF-8'); ?></option>
            <?php endforeach; ?>
        </select>

        <label>URL de imagen (opcional)</label>
        <input type="text" name="imagen" placeholder="https://ejemplo.com/imagen.jpg">

        <input type="submit" value="Guardar Producto">
    </form>

    <a href="index.php" class="btn-volver">← Volver al panel</a>
</body>
</html>
