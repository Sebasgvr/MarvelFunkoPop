<?php
// backend/api/registro.php
// Endpoint para registrar usuarios desde el frontend
header('Content-Type: application/json');

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'tienda_funkos';
$user = 'root';
$pass = '';

// Obtener datos del POST (JSON)
$data = json_decode(file_get_contents('php://input'), true);

// Validar que llegaron todos los campos
if (!isset($data['nombre']) || !isset($data['email']) || !isset($data['password'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan datos: nombre, email y password son obligatorios'
    ]);
    exit;
}

$nombre = trim($data['nombre']);
$email = trim($data['email']);
$password = $data['password'];
$telefono = trim($data['telefono'] ?? '');
$direccion = trim($data['direccion'] ?? '');

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Email inválido'
    ]);
    exit;
}

// Validar contraseña (mínimo 6 caracteres)
if (strlen($password) < 6) {
    echo json_encode([
        'success' => false,
        'message' => 'La contraseña debe tener al menos 6 caracteres'
    ]);
    exit;
}

try {
    // Conectar a la base de datos con PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Verificar si el email ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode([
            'success' => false,
            'message' => 'El email ya está registrado'
        ]);
        exit;
    }

    // Encriptar contraseña
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario
    $stmt = $pdo->prepare("
        INSERT INTO usuarios (nombre, email, contraseña, telefono, direccion)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$nombre, $email, $hash, $telefono, $direccion]);

    $usuario_id = $pdo->lastInsertId();

    echo json_encode([
        'success' => true,
        'message' => 'Usuario registrado correctamente',
        'data' => [
            'id' => $usuario_id,
            'nombre' => $nombre,
            'email' => $email
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al registrar usuario: ' . $e->getMessage()
    ]);
}
?>
