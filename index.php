<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AGS Pops | Coleccionables Marvel Funko Pop</title>
  <meta name="description" content="Tu colección empieza aquí. Funkos originales, ediciones limitadas y los personajes que amas. Todo en un solo lugar.">
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
  
  <!-- Styles -->
  <link rel="stylesheet" href="Frontend/Styles/styles.css">
</head>
<body>
  <!-- ==========================================
       HEADER
       ========================================== -->
  <header class="header">
    <div class="container header-inner">
      <!-- Logo -->
      <a href="/" class="logo">
        <span class="logo-bold">AGS</span>
        <span class="logo-light">Pops</span>
      </a>

      <!-- Navigation -->
      <nav class="nav">
        <a href="/coleccion">Colección</a>
        <a href="/heroes">Héroes</a>
        <a href="/villanos">Villanos</a>
        <a href="/exclusivos">Exclusivos</a>
        <a href="/novedades">Novedades</a>
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
            <a href="Frontend/login.php" class="account-btn-dropdown account-btn-login">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                <polyline points="10 17 15 12 10 7"></polyline>
                <line x1="15" y1="12" x2="3" y2="12"></line>
              </svg>
              Log In
            </a>
            <a href="Frontend/signup.php" class="account-btn-dropdown account-btn-signup">
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
       HERO SECTION
       ========================================== -->
  <section class="hero">
    <div class="hero-pattern"></div>
    <div class="container hero-content">
      <p class="hero-tag">Coleccionables Marvel</p>
      <h1 class="hero-title font-serif">
        Tu colección<br>empieza aquí
      </h1>
      <p class="hero-subtitle">
        Funkos originales, ediciones limitadas y los personajes que amas.<br>
        Todo en un solo lugar.
      </p>
      <div class="hero-buttons">
        <a href="/coleccion" class="btn-primary">
          Explorar Colección
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14"></path>
            <path d="m12 5 7 7-7 7"></path>
          </svg>
        </a>
        <a href="/novedades" class="btn-secondary">
          Ver Novedades
        </a>
      </div>
    </div>
  </section>

  <!-- ==========================================
       FEATURES SECTION
       ========================================== -->
  <section class="features">
    <div class="container">
      <div class="features-grid">
        <div class="feature-item">
          <div class="feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"></path>
              <path d="M15 18H9"></path>
              <path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"></path>
              <circle cx="17" cy="18" r="2"></circle>
              <circle cx="7" cy="18" r="2"></circle>
            </svg>
          </div>
          <h3 class="feature-title">Envío gratis</h3>
          <p class="feature-desc">En compras sobre $50.000</p>
        </div>
        <div class="feature-item">
          <div class="feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
            </svg>
          </div>
          <h3 class="feature-title">100% Original</h3>
          <p class="feature-desc">Productos con licencia oficial</p>
        </div>
        <div class="feature-item">
          <div class="feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
              <path d="M3 3v5h5"></path>
            </svg>
          </div>
          <h3 class="feature-title">Devolución fácil</h3>
          <p class="feature-desc">30 días para cambios</p>
        </div>
        <div class="feature-item">
          <div class="feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 1 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z"></path>
            </svg>
          </div>
          <h3 class="feature-title">Soporte 24/7</h3>
          <p class="feature-desc">Estamos para ayudarte</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================
       CATEGORIES SECTION
       ========================================== -->
  <section class="categories">
    <div class="container">
      <div class="section-header">
        <p class="section-tag">Categorías</p>
        <h2 class="section-title font-serif">Explora por universo</h2>
      </div>

      <div class="categories-grid">
        <!-- Heroes -->
        <a href="/heroes" class="category-card category-card--heroes">
          <p class="category-count">48 productos</p>
          <h3 class="category-name font-serif">Héroes</h3>
          <p class="category-desc">Iron Man, Spider-Man, Thor y más</p>
          <span class="category-link">
            Ver todos
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M7 7h10v10"></path>
              <path d="M7 17 17 7"></path>
            </svg>
          </span>
        </a>

        <!-- Villanos -->
        <a href="/villanos" class="category-card category-card--villanos">
          <p class="category-count">32 productos</p>
          <h3 class="category-name font-serif">Villanos</h3>
          <p class="category-desc">Thanos, Loki, Green Goblin y más</p>
          <span class="category-link">
            Ver todos
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M7 7h10v10"></path>
              <path d="M7 17 17 7"></path>
            </svg>
          </span>
        </a>

        <!-- Exclusivos -->
        <a href="/exclusivos" class="category-card category-card--exclusivos">
          <p class="category-count">16 productos</p>
          <h3 class="category-name font-serif">Exclusivos</h3>
          <p class="category-desc">Ediciones limitadas y chase</p>
          <span class="category-link">
            Ver todos
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M7 7h10v10"></path>
              <path d="M7 17 17 7"></path>
            </svg>
          </span>
        </a>
      </div>
    </div>
  </section>

  <!-- ==========================================
       FEATURED PRODUCTS SECTION
       ========================================== -->
  <section class="featured-products">
    <div class="container">
      <div class="section-header-flex">
        <div>
          <p class="section-tag">Lo más buscado</p>
          <h2 class="section-title font-serif">Productos destacados</h2>
        </div>
        <a href="/coleccion" class="view-all-link">Ver todos los productos</a>
      </div>

      <div class="products-grid">
        <!-- Product 1 -->
        <div class="product-card">
          <div class="product-image">
            <div class="product-placeholder">
              <div class="product-placeholder-inner">
                <span class="product-placeholder-letter">I</span>
              </div>
            </div>
            <span class="product-badge product-badge--nuevo">Nuevo</span>
            <div class="product-actions">
              <button class="action-btn" aria-label="Agregar a favoritos">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                </svg>
              </button>
            </div>
            <div class="add-to-cart-overlay">
              <button class="add-to-cart-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="8" cy="21" r="1"></circle>
                  <circle cx="19" cy="21" r="1"></circle>
                  <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                </svg>
                Agregar al carrito
              </button>
            </div>
          </div>
          <div class="product-info">
            <p class="product-category">Héroes</p>
            <h3 class="product-name">Iron Man Mark LXXXV</h3>
            <p class="product-price">$24.990</p>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="product-card">
          <div class="product-image">
            <div class="product-placeholder">
              <div class="product-placeholder-inner">
                <span class="product-placeholder-letter">T</span>
              </div>
            </div>
            <span class="product-badge product-badge--popular">Popular</span>
            <div class="product-actions">
              <button class="action-btn" aria-label="Agregar a favoritos">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                </svg>
              </button>
            </div>
            <div class="add-to-cart-overlay">
              <button class="add-to-cart-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="8" cy="21" r="1"></circle>
                  <circle cx="19" cy="21" r="1"></circle>
                  <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                </svg>
                Agregar al carrito
              </button>
            </div>
          </div>
          <div class="product-info">
            <p class="product-category">Villanos</p>
            <h3 class="product-name">Thanos Infinity Gauntlet</h3>
            <p class="product-price">$34.990</p>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="product-card">
          <div class="product-image">
            <div class="product-placeholder">
              <div class="product-placeholder-inner">
                <span class="product-placeholder-letter">S</span>
              </div>
            </div>
            <div class="product-actions">
              <button class="action-btn" aria-label="Agregar a favoritos">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                </svg>
              </button>
            </div>
            <div class="add-to-cart-overlay">
              <button class="add-to-cart-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="8" cy="21" r="1"></circle>
                  <circle cx="19" cy="21" r="1"></circle>
                  <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                </svg>
                Agregar al carrito
              </button>
            </div>
          </div>
          <div class="product-info">
            <p class="product-category">Héroes</p>
            <h3 class="product-name">Spider-Man No Way Home</h3>
            <p class="product-price">$19.990</p>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="product-card">
          <div class="product-image">
            <div class="product-placeholder">
              <div class="product-placeholder-inner">
                <span class="product-placeholder-letter">L</span>
              </div>
            </div>
            <span class="product-badge product-badge--chase">Chase</span>
            <div class="product-actions">
              <button class="action-btn" aria-label="Agregar a favoritos">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                </svg>
              </button>
            </div>
            <div class="add-to-cart-overlay">
              <button class="add-to-cart-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="8" cy="21" r="1"></circle>
                  <circle cx="19" cy="21" r="1"></circle>
                  <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                </svg>
                Agregar al carrito
              </button>
            </div>
          </div>
          <div class="product-info">
            <p class="product-category">Exclusivos</p>
            <h3 class="product-name">Loki Variant</h3>
            <p class="product-price">$29.990</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================
       NEW ARRIVALS SECTION
       ========================================== -->
  <section class="new-arrivals">
    <div class="container">
      <div class="section-header-flex">
        <div>
          <p class="section-tag">Recién llegados</p>
          <h2 class="section-title font-serif">Novedades</h2>
        </div>
        <a href="/novedades" class="view-all-link">
          Ver todas las novedades
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14"></path>
            <path d="m12 5 7 7-7 7"></path>
          </svg>
        </a>
      </div>

      <div class="arrivals-grid">
        <!-- Arrival 1 -->
        <a href="/producto/5" class="arrival-item">
          <span class="arrival-number">01</span>
          <div class="arrival-image">
            <span>D</span>
          </div>
          <div class="arrival-info">
            <p class="arrival-category">Héroes</p>
            <h3 class="arrival-name">Doctor Strange Multiverse</h3>
            <p class="arrival-price">$27.990</p>
          </div>
          <span class="arrival-badge">Nuevo</span>
        </a>

        <!-- Arrival 2 -->
        <a href="/producto/6" class="arrival-item">
          <span class="arrival-number">02</span>
          <div class="arrival-image">
            <span>S</span>
          </div>
          <div class="arrival-info">
            <p class="arrival-category">Héroes</p>
            <h3 class="arrival-name">Scarlet Witch</h3>
            <p class="arrival-price">$26.990</p>
          </div>
          <span class="arrival-badge">Nuevo</span>
        </a>

        <!-- Arrival 3 -->
        <a href="/producto/7" class="arrival-item">
          <span class="arrival-number">03</span>
          <div class="arrival-image">
            <span>G</span>
          </div>
          <div class="arrival-info">
            <p class="arrival-category">Villanos</p>
            <h3 class="arrival-name">Green Goblin Classic</h3>
            <p class="arrival-price">$22.990</p>
          </div>
          <span class="arrival-badge">Nuevo</span>
        </a>

        <!-- Arrival 4 -->
        <a href="/producto/8" class="arrival-item">
          <span class="arrival-number">04</span>
          <div class="arrival-image">
            <span>C</span>
          </div>
          <div class="arrival-info">
            <p class="arrival-category">Héroes</p>
            <h3 class="arrival-name">Captain America Sam Wilson</h3>
            <p class="arrival-price">$24.990</p>
          </div>
          <span class="arrival-badge">Nuevo</span>
        </a>
      </div>
    </div>
  </section>

  <!-- ==========================================
       NEWSLETTER SECTION
       ========================================== -->
  <section class="newsletter">
    <div class="container">
      <div class="newsletter-inner">
        <div class="newsletter-text">
          <h2 class="newsletter-title font-serif">Únete a la comunidad</h2>
          <p class="newsletter-desc">
            Suscríbete y recibe novedades, ofertas exclusivas y acceso anticipado a nuevos lanzamientos.
          </p>
        </div>
        <form class="newsletter-form" id="newsletter-form">
          <input 
            type="email" 
            class="newsletter-input" 
            placeholder="Tu correo electrónico" 
            required
            id="newsletter-email"
          >
          <button type="submit" class="newsletter-btn">
            Suscribirse
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 12h14"></path>
              <path d="m12 5 7 7-7 7"></path>
            </svg>
          </button>
        </form>
        <div class="newsletter-success" id="newsletter-success" style="display: none;">
          <div class="newsletter-success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 6 9 17l-5-5"></path>
            </svg>
          </div>
          <span>Gracias por suscribirte</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================
       FOOTER
       ========================================== -->
  <footer class="footer">
    <div class="container">
      <div class="footer-main">
        <!-- Brand -->
        <div class="footer-brand">
          <a href="/" class="footer-logo">
            <span class="footer-logo-bold">AGS</span>
            <span class="footer-logo-light">Pops</span>
          </a>
          <p class="footer-desc">
            Tu tienda de coleccionables Funko Pop de Marvel. Originales, exclusivos y con envío a todo Chile.
          </p>
          <div class="social-links">
            <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Instagram">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
              </svg>
            </a>
            <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Facebook">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
              </svg>
            </a>
            <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Twitter">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>
              </svg>
            </a>
          </div>
        </div>

        <!-- Tienda -->
        <div class="footer-section">
          <h3>Tienda</h3>
          <ul>
            <li><a href="/coleccion">Colección completa</a></li>
            <li><a href="/heroes">Héroes</a></li>
            <li><a href="/villanos">Villanos</a></li>
            <li><a href="/exclusivos">Exclusivos</a></li>
            <li><a href="/novedades">Novedades</a></li>
          </ul>
        </div>

        <!-- Ayuda -->
        <div class="footer-section">
          <h3>Ayuda</h3>
          <ul>
            <li><a href="/faq">Preguntas frecuentes</a></li>
            <li><a href="/envios">Envíos</a></li>
            <li><a href="/devoluciones">Devoluciones</a></li>
            <li><a href="/seguimiento">Seguimiento de pedido</a></li>
            <li><a href="/contacto">Contacto</a></li>
          </ul>
        </div>

        <!-- Empresa -->
        <div class="footer-section">
          <h3>Empresa</h3>
          <ul>
            <li><a href="/nosotros">Sobre nosotros</a></li>
            <li><a href="/blog">Blog</a></li>
            <li><a href="/terminos">Términos y condiciones</a></li>
            <li><a href="/privacidad">Política de privacidad</a></li>
          </ul>
        </div>
      </div>

      <!-- Bottom -->
      <div class="footer-bottom">
        <div class="footer-bottom-inner">
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

  <!-- JavaScript para funcionalidad del newsletter -->
  <script>
    document.getElementById('newsletter-form').addEventListener('submit', function(e) {
      e.preventDefault();
      const email = document.getElementById('newsletter-email').value;
      if (email) {
        document.getElementById('newsletter-form').style.display = 'none';
        document.getElementById('newsletter-success').style.display = 'flex';
      }
    });

    // Account dropdown functionality
    const accountBtn = document.querySelector('.account-btn');
    const accountDropdown = document.querySelector('.account-dropdown');
    const accountMenu = document.querySelector('.account-menu');

    if (accountBtn && accountDropdown) {
      accountBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        accountDropdown.classList.toggle('active');
      });

      // Close dropdown when clicking outside
      document.addEventListener('click', function(e) {
        if (!accountMenu.contains(e.target)) {
          accountDropdown.classList.remove('active');
        }
      });
    }
  </script>
</body>
</html>
