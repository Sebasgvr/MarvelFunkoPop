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
  <link rel="stylesheet" href="Styles/login.css">
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
        <a href="../index.php#coleccion">Colección</a>
        <a href="../index.php#heroes">Héroes</a>
        <a href="../index.php#villanos">Villanos</a>
        <a href="../index.php#exclusivos">Exclusivos</a>
        <a href="../index.php#novedades">Novedades</a>
      </nav>

      <!-- Icons -->
      <div class="header-icons">
        <button class="icon-btn" aria-label="Buscar">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.3-4.3"></path>
          </svg>
        </button>
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


  
</body>
</html>