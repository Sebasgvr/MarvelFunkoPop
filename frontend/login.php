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

// Si ya está logueado, redirigir a coleccion.php
if (isset($_SESSION['usuario_id'])) {
    header('Location: coleccion.php');
    exit;
}

$authError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Conexión a la base de datos
    $host = 'localhost';
    $dbname = 'tienda_funkos';
    $dbuser = 'root';
    $dbpass = '';

    try {
        $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $dbuser, $dbpass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        $stmt = $pdo->prepare('SELECT id, nombre, contraseña FROM usuarios WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['contraseña'])) {
            // Guardar datos en sesión
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nombre'] = $user['nombre'];
            // Redirigir a coleccion.php después de guardar la sesión
header('Location: coleccion.php');
exit;
            // Redirigir (solo se ejecuta si se elimina el exit de arriba)
            header('Location: coleccion.php');
            exit;
        } else {
            $authError = 'Email o contraseña incorrectos.';
        }
    } catch (Throwable $e) {
        $authError = 'Error de conexión. Intenta más tarde.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<!DOCTYPE html>

<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión | AGS Pops</title>
  <meta name="description" content="Inicia sesión en tu cuenta de AGS Pops para gestionar tus colecciones y pedidos.">
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
  
  <!-- Styles -->
  <link rel="stylesheet" href="Styles/login.css?v=1.2">
</head>
<body>
  <!-- ==========================================
       HEADER
       ========================================== -->
  <header class="header">
    <div class="container header-inner">
      <!-- Logo -->
      <a href="../index.php" class="logo">
        <span class="logo-bold">AGS</span>
        <span class="logo-light">Pops</span>
      </a>

      <!-- Navigation -->
      <nav class="nav">
        <a href="../index.php">Inicio</a>
        <a href="coleccion.php">Colección</a>
      </nav>

      <!-- Icons -->
      <div class="header-icons">
        <a href="coleccion.php" class="icon-btn" aria-label="Buscar">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.3-4.3"></path>
          </svg>
        </a>
        <!-- Account Dropdown -->
        <div class="account-menu">
          <button class="icon-btn account-btn" aria-label="Mi cuenta">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
          </button>
          <div class="account-dropdown">
            <a href="login.php" class="account-btn-dropdown account-btn-login">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                <polyline points="10 17 15 12 10 7"></polyline>
                <line x1="15" y1="12" x2="3" y2="12"></line>
              </svg>
              Log In
            </a>
            <a href="signup.php" class="account-btn-dropdown account-btn-signup">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <line x1="20" y1="8" x2="20" y2="14"></line>
                <line x1="23" y1="11" x2="17" y2="11"></line>
              </svg>
              Sign Up
            </a>
          </div>
        </div>
        <button class="icon-btn" aria-label="Carrito de compras">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="8" cy="21" r="1"></circle>
            <circle cx="19" cy="21" r="1"></circle>
            <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
          </svg>
          <span class="cart-badge">0</span>
        </button>
        <!-- Mobile Menu Toggle -->
        <button class="icon-btn mobile-menu-btn mobile-menu-toggle" id="mobile-menu-toggle" aria-label="Abrir menú" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="4" x2="20" y1="12" y2="12"></line>
            <line x1="4" x2="20" y1="6" y2="6"></line>
            <line x1="4" x2="20" y1="18" y2="18"></line>
          </svg>
        </button>
      </div>
    </div>
  </header>

  <!-- ==========================================
       AUTH WRAPPER (LOGIN CARD)
       ========================================== -->
  <main class="auth-wrapper">
    <div class="auth-card">
      <div class="auth-header">
        <h1 class="auth-title">¡Hola de nuevo!</h1>
        <p class="auth-subtitle">Ingresa tus credenciales para acceder a tu cuenta</p>
      </div>

      <!-- Alert for feedback (errors/success) -->
      <div id="auth-alert" class="auth-alert" style="display: none;">
        <!-- Icon and message inserted dynamically -->
      </div>

      <form class="auth-form" id="login-form" method="POST" action="">
        <div class="form-group">
          <label for="email" class="form-label">Correo electrónico</label>
          <input 
            type="email" 
            id="email" 
            name="email" 
            class="form-input" 
            placeholder="ejemplo@correo.com" 
            required
            autocomplete="email"
          >
        </div>

        <div class="form-group">
          <label for="password" class="form-label">Contraseña</label>
          <div class="input-wrapper">
            <input 
              type="password" 
              id="password" 
              name="password" 
              class="form-input" 
              placeholder="Tu contraseña" 
              required
              autocomplete="current-password"
            >
            <button type="button" class="input-icon-btn" id="toggle-password" aria-label="Mostrar contraseña">
              <!-- Eye Icon -->
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                <circle cx="12" cy="12" r="3"></circle>
              </svg>
            </button>
          </div>
        </div>

        <div class="form-options">
          <label class="checkbox-group">
            <input type="checkbox" name="remember" class="checkbox-input">
            <span>Recordarme</span>
          </label>
          <a href="#" class="forgot-password-link">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="auth-btn-submit">
          <span>Iniciar sesión</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
            <polyline points="10 17 15 12 10 7"></polyline>
            <line x1="15" y1="12" x2="3" y2="12"></line>
          </svg>
        </button>
      </form>

      <div class="auth-footer">
        <span>¿No tienes una cuenta? </span>
        <a href="signup.php" class="auth-link">Regístrate aquí</a>
      </div>
    </div>
  </main>

  <!-- ==========================================
       MOBILE DRAWER MENU
       ========================================== -->
  <div class="mobile-drawer" id="mobile-drawer">
    <div class="mobile-drawer-overlay" id="mobile-drawer-overlay"></div>
    <div class="mobile-drawer-content">
      <div class="mobile-drawer-header">
        <a href="../index.php" class="logo">
          <span class="logo-bold">AGS</span>
          <span class="logo-light">Pops</span>
        </a>
        <button class="icon-btn mobile-menu-close" id="mobile-drawer-close" aria-label="Cerrar menú">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" x2="6" y1="6" y2="18"></line>
            <line x1="6" x2="18" y1="6" y2="18"></line>
          </svg>
        </button>
      </div>
      <nav class="mobile-drawer-nav">
        <a href="../index.php" class="mobile-drawer-link">Inicio</a>
        <a href="coleccion.php" class="mobile-drawer-link">Colección</a>
      </nav>
      <div class="mobile-drawer-footer">
        <a href="login.php" class="mobile-drawer-btn btn-login-mobile">Iniciar Sesión</a>
        <a href="signup.php" class="mobile-drawer-btn btn-signup-mobile">Registrarse</a>
      </div>
    </div>
  </div>

  <!-- ==========================================
       FOOTER
       ========================================== -->
  <footer class="footer">
    <div class="container">
      <div class="footer-bottom" style="border-top: none;">
        <div class="footer-bottom-inner" style="padding: 1.5rem 0;">
          <p class="copyright">2024 AGS Pops. Todos los derechos reservados.</p>
          <div class="payment-methods">
            <span>Métodos de pago:</span>
            <div class="payment-badges">
              <span class="payment-badge">Visa</span>
              <span class="payment-badge">Mastercard</span>
              <span class="payment-badge">WebPay</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- ==========================================
       JAVASCRIPT FOR INTERACTION
       ========================================== -->
 <script>
    // Password visibility toggle
    const togglePasswordBtn = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');

    if (togglePasswordBtn && passwordInput) {
      togglePasswordBtn.addEventListener('click', function() {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        
        if (isPassword) {
          togglePasswordBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
              <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
              <path d="M6.61 6.61A13.52 13.52 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
              <line x1="2" y1="2" x2="22" y2="22"></line>
            </svg>
          `;
          togglePasswordBtn.setAttribute('aria-label', 'Ocultar contraseña');
        } else {
          togglePasswordBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          `;
          togglePasswordBtn.setAttribute('aria-label', 'Mostrar contraseña');
        }
      });
    }

    // Account dropdown toggle in header
    const accountBtn = document.querySelector('.account-btn');
    const accountDropdown = document.querySelector('.account-dropdown');
    const accountMenu = document.querySelector('.account-menu');

    if (accountBtn && accountDropdown) {
      accountBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        accountDropdown.classList.toggle('active');
      });

      document.addEventListener('click', function(e) {
        if (accountMenu && !accountMenu.contains(e.target)) {
          accountDropdown.classList.remove('active');
        }
      });
    }

    // Mobile drawer toggle functionality
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileDrawer = document.getElementById('mobile-drawer');
    const mobileDrawerClose = document.getElementById('mobile-drawer-close');
    const mobileDrawerOverlay = document.getElementById('mobile-drawer-overlay');
    const mobileDrawerLinks = document.querySelectorAll('.mobile-drawer-link');

    function openMobileDrawer() {
      mobileDrawer.classList.add('active');
      mobileMenuToggle.setAttribute('aria-expanded', 'true');
      document.body.style.overflow = 'hidden';
    }

    function closeMobileDrawer() {
      mobileDrawer.classList.remove('active');
      mobileMenuToggle.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    }

    if (mobileMenuToggle && mobileDrawer) {
      mobileMenuToggle.addEventListener('click', openMobileDrawer);
      mobileDrawerClose.addEventListener('click', closeMobileDrawer);
      mobileDrawerOverlay.addEventListener('click', closeMobileDrawer);
      
      mobileDrawerLinks.forEach(link => {
        link.addEventListener('click', closeMobileDrawer);
      });
    }
</script>
</body>
</html>