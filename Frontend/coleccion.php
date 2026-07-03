<?php
session_start();
$usuarioNombre = $_SESSION['usuario_nombre'] ?? null;
$usuarioId     = $_SESSION['usuario_id']     ?? null;

$fallbackProducts = [
  ['id' => 1, 'nombre' => 'Iron Man Mark LXXXV', 'categoria' => 'Heroes', 'precio' => 24990, 'imagen' => '', 'etiqueta' => 'Nuevo'],
  ['id' => 2, 'nombre' => 'Thanos Infinity Gauntlet', 'categoria' => 'Villanos', 'precio' => 34990, 'imagen' => '', 'etiqueta' => 'Popular'],
  ['id' => 3, 'nombre' => 'Spider-Man No Way Home', 'categoria' => 'Heroes', 'precio' => 19990, 'imagen' => '', 'etiqueta' => ''],
  ['id' => 4, 'nombre' => 'Loki Variant', 'categoria' => 'Exclusivos', 'precio' => 29990, 'imagen' => '', 'etiqueta' => 'Chase'],
  ['id' => 5, 'nombre' => 'Doctor Strange Multiverse', 'categoria' => 'Heroes', 'precio' => 27990, 'imagen' => '', 'etiqueta' => 'Nuevo'],
  ['id' => 6, 'nombre' => 'Scarlet Witch', 'categoria' => 'Heroes', 'precio' => 26990, 'imagen' => '', 'etiqueta' => 'Nuevo'],
  ['id' => 7, 'nombre' => 'Green Goblin Classic', 'categoria' => 'Villanos', 'precio' => 22990, 'imagen' => '', 'etiqueta' => 'Nuevo'],
  ['id' => 8, 'nombre' => 'Captain America Sam Wilson', 'categoria' => 'Heroes', 'precio' => 24990, 'imagen' => '', 'etiqueta' => '']
];

function firstAvailableColumn(array $columns, array $options) {
  foreach ($options as $option) {
    if (in_array($option, $columns, true)) {
      return $option;
    }
  }
  return null;
}

function normalizeProduct(array $row, array $map) {
  return [
    'id' => $map['id'] && isset($row[$map['id']]) ? $row[$map['id']] : '',
    'nombre' => $map['nombre'] && isset($row[$map['nombre']]) ? $row[$map['nombre']] : 'Producto Marvel',
    'categoria' => $map['categoria'] && isset($row[$map['categoria']]) ? $row[$map['categoria']] : 'Coleccionables',
    'precio' => $map['precio'] && isset($row[$map['precio']]) ? (float) $row[$map['precio']] : 0,
    'imagen' => $map['imagen'] && isset($row[$map['imagen']]) ? $row[$map['imagen']] : '',
    'etiqueta' => $map['etiqueta'] && isset($row[$map['etiqueta']]) ? $row[$map['etiqueta']] : ''
  ];
}

function loadProductsFromDatabase() {
  $host = getenv('DB_HOST') ?: 'localhost';
  $dbname = getenv('DB_NAME') ?: 'marvel_funkopop';
  $user = getenv('DB_USER') ?: 'root';
  $password = getenv('DB_PASS') ?: '';

  try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $user, $password, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $columns = $pdo->query('DESCRIBE productos')->fetchAll(PDO::FETCH_COLUMN);
    if (!$columns) {
      return [];
    }

    $map = [
      'id' => firstAvailableColumn($columns, ['id', 'id_producto', 'producto_id']),
      'nombre' => firstAvailableColumn($columns, ['nombre', 'name', 'titulo', 'producto']),
      'categoria' => firstAvailableColumn($columns, ['categoria', 'category', 'tipo']),
      'precio' => firstAvailableColumn($columns, ['precio', 'price', 'valor']),
      'imagen' => firstAvailableColumn($columns, ['imagen', 'image', 'foto', 'url_imagen']),
      'etiqueta' => firstAvailableColumn($columns, ['etiqueta', 'badge', 'estado', 'tag'])
    ];

    $selectColumns = array_values(array_unique(array_filter($map)));
    if (!$map['nombre'] || !$selectColumns) {
      return [];
    }

    $orderColumn = $map['id'] ?: $map['nombre'];
    $query = 'SELECT `' . implode('`, `', $selectColumns) . '` FROM productos ORDER BY `' . $orderColumn . '` DESC';
    $rows = $pdo->query($query)->fetchAll();

    return array_map(function ($row) use ($map) {
      return normalizeProduct($row, $map);
    }, $rows);
  } catch (Throwable $error) {
    return [];
  }
}

function formatPrice($price) {
  return '$' . number_format((float) $price, 0, ',', '.');
}

function normalizeText($text) {
  $text = strtolower((string) $text);
  $converted = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
  return $converted !== false ? $converted : $text;
}

function productBadgeClass($label) {
  $normalized = normalizeText($label);
  if (strpos($normalized, 'popular') !== false) {
    return 'product-badge--popular';
  }
  if (strpos($normalized, 'chase') !== false || strpos($normalized, 'exclus') !== false) {
    return 'product-badge--chase';
  }
  return 'product-badge--nuevo';
}

$search = trim($_GET['buscar'] ?? '');
$selectedCategory = trim($_GET['categoria'] ?? '');
$selectedPrice = trim($_GET['precio'] ?? '');
$products = loadProductsFromDatabase();
$usingFallbackProducts = empty($products);

if ($usingFallbackProducts) {
  $products = $fallbackProducts;
}

$categories = array_values(array_unique(array_filter(array_map(function ($product) {
  return $product['categoria'];
}, $products))));
sort($categories);

$filteredProducts = array_values(array_filter($products, function ($product) use ($search, $selectedCategory, $selectedPrice) {
  $matchesSearch = $search === '' || strpos(normalizeText($product['nombre'] . ' ' . $product['categoria']), normalizeText($search)) !== false;
  $matchesCategory = $selectedCategory === '' || $product['categoria'] === $selectedCategory;
  $price = (float) $product['precio'];
  $matchesPrice = true;

  if ($selectedPrice === 'hasta-25000') {
    $matchesPrice = $price <= 25000;
  } elseif ($selectedPrice === '25000-30000') {
    $matchesPrice = $price > 25000 && $price <= 30000;
  } elseif ($selectedPrice === 'mas-30000') {
    $matchesPrice = $price > 30000;
  }

  return $matchesSearch && $matchesCategory && $matchesPrice;
}));
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Colección | AGS Pops</title>
  <meta name="description" content="Explora y filtra nuestra amplia colección de figuras Funko Pop de Marvel. Encuentra tus héroes y villanos favoritos.">
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
  
  <!-- Styles -->
  <link rel="stylesheet" href="Styles/styles.css?v=1.2">
  <link rel="stylesheet" href="Styles/coleccion.css?v=1.2">
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
        <a href="coleccion.php" class="active">Colección</a>
      </nav>

      <!-- Icons -->
      <div class="header-icons">
        <button class="icon-btn" aria-label="Buscar" onclick="document.getElementById('buscar').focus();">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.3-4.3"></path>
          </svg>
        </button>

        <!-- Wishlist Icon -->
        <button class="icon-btn wishlist-header-btn" id="wishlist-header-btn" aria-label="Mis favoritos">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
          </svg>
          <span class="wishlist-badge" id="wishlist-badge" style="display:none;">0</span>
        </button>

        <!-- Account -->
        <div class="account-menu">
          <button class="icon-btn account-btn" aria-label="Mi cuenta">
            <?php if ($usuarioNombre): ?>
              <span class="user-greeting">Hola, <?php echo htmlspecialchars(explode(' ', $usuarioNombre)[0], ENT_QUOTES, 'UTF-8'); ?></span>
            <?php else: ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <?php endif; ?>
          </button>
          <div class="account-dropdown">
            <?php if ($usuarioNombre): ?>
              <div class="account-user-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span><?php echo htmlspecialchars($usuarioNombre, ENT_QUOTES, 'UTF-8'); ?></span>
              </div>
              <a href="logout.php" class="account-btn-dropdown account-btn-logout">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                  <polyline points="16 17 21 12 16 7"></polyline>
                  <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                Cerrar sesión
              </a>
            <?php else: ?>
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
            <?php endif; ?>
          </div>
        </div>

        <!-- Cart Icon -->
        <button class="icon-btn cart-header-btn" id="cart-header-btn" aria-label="Carrito de compras">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="8" cy="21" r="1"></circle>
            <circle cx="19" cy="21" r="1"></circle>
            <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
          </svg>
          <span class="cart-badge" id="cart-badge">0</span>
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
       MAIN CONTENT: COLLECTION PAGE
       ========================================== -->
  <main class="collection-page">
    <div class="container">
      
      <!-- Section Header -->
      <div class="collection-header-section">
        <div class="collection-title-wrap">
          <p class="section-tag">Explorar productos</p>
          <h1 class="section-title font-serif">Colección Marvel</h1>
        </div>
        <div class="collection-stats">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <rect width="7" height="9" x="3" y="3" rx="1"></rect>
            <rect width="7" height="5" x="14" y="3" rx="1"></rect>
            <rect width="7" height="9" x="14" y="12" rx="1"></rect>
            <rect width="7" height="5" x="3" y="16" rx="1"></rect>
          </svg>
          <span><?php echo count($filteredProducts); ?> de <?php echo count($products); ?> productos</span>
        </div>
      </div>

      <!-- PREMIUM FILTERS PANEL -->
      <div class="filters-panel">
        <form class="collection-filters-form" method="GET" action="coleccion.php">
          
          <!-- Search Bar -->
          <div class="filter-group">
            <label for="buscar">Buscar Funko</label>
            <div class="search-bar-wrap">
              <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.3-4.3"></path>
              </svg>
              <input 
                type="search" 
                id="buscar" 
                name="buscar" 
                placeholder="Buscar por nombre o categoría..." 
                value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>"
              >
            </div>
          </div>

          <!-- Category Filter -->
          <div class="filter-group">
            <label for="categoria">Categoría</label>
            <div class="custom-select-wrap">
              <select id="categoria" name="categoria">
                <option value="">Todas las categorías</option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $selectedCategory === $category ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Price Filter -->
          <div class="filter-group">
            <label for="precio">Rango de Precio</label>
            <div class="custom-select-wrap">
              <select id="precio" name="precio">
                <option value="">Cualquier precio</option>
                <option value="hasta-25000" <?php echo $selectedPrice === 'hasta-25000' ? 'selected' : ''; ?>>Hasta $25.000</option>
                <option value="25000-30000" <?php echo $selectedPrice === '25000-30000' ? 'selected' : ''; ?>>$25.000 a $30.000</option>
                <option value="mas-30000" <?php echo $selectedPrice === 'mas-30000' ? 'selected' : ''; ?>>Más de $30.000</option>
              </select>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="filter-group">
            <div class="filter-button-group">
              <button type="submit" class="btn-filter-apply">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                </svg>
                Filtrar
              </button>
              <a href="coleccion.php" class="btn-filter-reset" title="Limpiar filtros">
                Limpiar
              </a>
            </div>
          </div>

        </form>
      </div>


      <!-- PRODUCTS GRID -->
      <?php if (empty($filteredProducts)): ?>
        <!-- Empty State -->
        <div class="no-results-card">
          <div class="no-results-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"></circle>
              <path d="m21 21-4.3-4.3"></path>
              <line x1="8" x2="14" y1="11" y2="11"></line>
            </svg>
          </div>
          <h3 class="font-serif">Sin resultados</h3>
          <p>No encontramos figuras Funko Pop que coincidan con los criterios de búsqueda actuales. Intenta limpiar los filtros o realizar otra búsqueda.</p>
          <a href="coleccion.php" class="btn-filter-apply btn-primary">
            Ver toda la colección
          </a>
        </div>
      <?php else: ?>
        <div class="products-grid collection-products-grid">
          <?php foreach ($filteredProducts as $product): ?>
            <?php
              $productName = (string) $product['nombre'];
              $productInitial = strtoupper(substr(normalizeText($productName), 0, 1));
              $productImage = trim((string) $product['imagen']);
              $productLabel = trim((string) $product['etiqueta']);
            ?>
            <article class="product-card"
              data-id="<?php echo (int)$product['id']; ?>"
              data-nombre="<?php echo htmlspecialchars($productName, ENT_QUOTES, 'UTF-8'); ?>"
              data-precio="<?php echo (float)$product['precio']; ?>"
              data-inicial="<?php echo htmlspecialchars($productInitial, ENT_QUOTES, 'UTF-8'); ?>"
              data-imagen="<?php echo htmlspecialchars($productImage, ENT_QUOTES, 'UTF-8'); ?>">
              <div class="product-image">
                <?php if ($productImage !== ''): ?>
                  <img src="<?php echo htmlspecialchars($productImage, ENT_QUOTES, 'UTF-8'); ?>"
                       alt="<?php echo htmlspecialchars($productName, ENT_QUOTES, 'UTF-8'); ?>"
                       class="product-photo"
                       onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                  <div class="product-placeholder" style="display:none;">
                    <div class="product-placeholder-inner">
                      <span class="product-placeholder-letter"><?php echo htmlspecialchars($productInitial, ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                  </div>
                <?php else: ?>
                  <div class="product-placeholder">
                    <div class="product-placeholder-inner">
                      <span class="product-placeholder-letter"><?php echo htmlspecialchars($productInitial, ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                  </div>
                <?php endif; ?>

                <?php if ($productLabel !== ''): ?>
                  <span class="product-badge <?php echo productBadgeClass($productLabel); ?>">
                    <?php echo htmlspecialchars($productLabel, ENT_QUOTES, 'UTF-8'); ?>
                  </span>
                <?php endif; ?>

                <div class="product-actions">
                  <button class="action-btn wishlist-btn" type="button" aria-label="Agregar a favoritos">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                    </svg>
                  </button>
                </div>
                <div class="add-to-cart-overlay">
                  <button class="add-to-cart-btn" type="button">
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
                <p class="product-category"><?php echo htmlspecialchars($product['categoria'], ENT_QUOTES, 'UTF-8'); ?></p>
                <h3 class="product-name"><?php echo htmlspecialchars($productName, ENT_QUOTES, 'UTF-8'); ?></h3>
                <p class="product-price"><?php echo formatPrice($product['precio']); ?></p>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    </div>
  </main>

  <!-- ==========================================
       FOOTER
       ========================================== -->
  <footer class="footer">
    <div class="container">
      <div class="footer-main">
        <!-- Brand -->
        <div class="footer-brand">
          <a href="../index.php" class="footer-logo">
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
            <li><a href="coleccion.php">Colección completa</a></li>
            <li><a href="coleccion.php?categoria=Heroes">Héroes</a></li>
            <li><a href="coleccion.php?categoria=Villanos">Villanos</a></li>
            <li><a href="coleccion.php?categoria=Exclusivos">Exclusivos</a></li>
            <li><a href="../index.php#novedades">Novedades</a></li>
          </ul>
        </div>

        <!-- Ayuda -->
        <div class="footer-section">
          <h3>Ayuda</h3>
          <ul>
            <li><a href="#">Preguntas frecuentes</a></li>
            <li><a href="#">Envíos</a></li>
            <li><a href="#">Devoluciones</a></li>
            <li><a href="#">Seguimiento de pedido</a></li>
            <li><a href="#">Contacto</a></li>
          </ul>
        </div>

        <!-- Empresa -->
        <div class="footer-section">
          <h3>Empresa</h3>
          <ul>
            <li><a href="#">Sobre nosotros</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Términos y condiciones</a></li>
            <li><a href="#">Política de privacidad</a></li>
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

  <!-- ==========================================
       WISHLIST PANEL (left sidebar)
       ========================================== -->
  <div class="side-panel-overlay" id="side-overlay"></div>

  <aside class="side-panel wishlist-panel" id="wishlist-panel" aria-label="Lista de favoritos">
    <div class="side-panel-header">
      <div class="side-panel-title">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#A94A42" stroke="#A94A42" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
        </svg>
        <span>Mis Favoritos</span>
      </div>
      <button class="side-panel-close" id="wishlist-close" aria-label="Cerrar favoritos">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" x2="6" y1="6" y2="18"></line>
          <line x1="6" x2="18" y1="6" y2="18"></line>
        </svg>
      </button>
    </div>
    <div class="side-panel-body" id="wishlist-body">
      <!-- JS populated -->
    </div>
  </aside>

  <!-- ==========================================
       CART PANEL (right sidebar)
       ========================================== -->
  <aside class="side-panel cart-panel" id="cart-panel" aria-label="Carrito de compras">
    <div class="side-panel-header">
      <div class="side-panel-title">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1C2541" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="8" cy="21" r="1"></circle>
          <circle cx="19" cy="21" r="1"></circle>
          <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
        </svg>
        <span>Carrito</span>
      </div>
      <button class="side-panel-close" id="cart-close" aria-label="Cerrar carrito">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" x2="6" y1="6" y2="18"></line>
          <line x1="6" x2="18" y1="6" y2="18"></line>
        </svg>
      </button>
    </div>
    <div class="side-panel-body" id="cart-body">
      <!-- JS populated -->
    </div>
    <div class="cart-panel-footer" id="cart-footer" style="display:none;">
      <div class="cart-total-row">
        <span>Total</span>
        <span class="cart-total-amount" id="cart-total">$0</span>
      </div>
      <button class="checkout-btn" id="checkout-btn" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
        </svg>
        Finalizar compra
      </button>
    </div>
  </aside>

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
        <a href="coleccion.php" class="mobile-drawer-link active">Colección</a>
      </nav>
      <div class="mobile-drawer-footer">
        <?php if ($usuarioNombre): ?>
          <span class="mobile-user-name">Hola, <?php echo htmlspecialchars($usuarioNombre, ENT_QUOTES, 'UTF-8'); ?></span>
          <a href="logout.php" class="mobile-drawer-btn btn-login-mobile">Cerrar sesión</a>
        <?php else: ?>
          <a href="login.php" class="mobile-drawer-btn btn-login-mobile">Iniciar Sesión</a>
          <a href="signup.php" class="mobile-drawer-btn btn-signup-mobile">Registrarse</a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
  // ─── HELPERS ───────────────────────────────────────────────────────────
  const WISH_KEY = 'ags_wishlist';
  const CART_KEY = 'ags_cart';

  function getWishlist()  { try { return JSON.parse(localStorage.getItem(WISH_KEY)) || []; } catch { return []; } }
  function getCart()      { try { return JSON.parse(localStorage.getItem(CART_KEY))  || []; } catch { return []; } }
  function saveWishlist(w){ localStorage.setItem(WISH_KEY, JSON.stringify(w)); }
  function saveCart(c)    { localStorage.setItem(CART_KEY,  JSON.stringify(c)); }

  function formatPrice(n) {
    return '$' + Number(n).toLocaleString('es-CL');
  }

  // ─── PRODUCT THUMBNAIL ─────────────────────────────────────────────────
  function productThumb(item) {
    if (item.imagen) {
      return `<img src="${item.imagen}" alt="${item.nombre}" class="sp-item-img" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
              <div class="sp-item-img sp-item-placeholder" style="display:none;">${item.inicial}</div>`;
    }
    return `<div class="sp-item-img sp-item-placeholder">${item.inicial}</div>`;
  }

  // ─── BADGES ────────────────────────────────────────────────────────────
  function updateBadges() {
    const wCount  = getWishlist().length;
    const cCount  = getCart().reduce((s, i) => s + i.cantidad, 0);
    const wBadge  = document.getElementById('wishlist-badge');
    const cBadge  = document.getElementById('cart-badge');
    if (wBadge) { wBadge.textContent = wCount; wBadge.style.display = wCount > 0 ? 'flex' : 'none'; }
    if (cBadge) { cBadge.textContent = cCount > 0 ? cCount : '0'; }
  }

  // ─── PANELS ────────────────────────────────────────────────────────────
  const overlay      = document.getElementById('side-overlay');
  const wishPanel    = document.getElementById('wishlist-panel');
  const cartPanel    = document.getElementById('cart-panel');

  function openPanel(panel) {
    closeAllPanels();
    panel.classList.add('open');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
  function closeAllPanels() {
    wishPanel.classList.remove('open');
    cartPanel.classList.remove('open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }
  overlay.addEventListener('click', closeAllPanels);
  document.getElementById('wishlist-close').addEventListener('click', closeAllPanels);
  document.getElementById('cart-close').addEventListener('click', closeAllPanels);

  // ─── WISHLIST RENDER ───────────────────────────────────────────────────
  function renderWishlist() {
    const body = document.getElementById('wishlist-body');
    const list = getWishlist();
    if (list.length === 0) {
      body.innerHTML = `
        <div class="sp-empty">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
          </svg>
          <p>Aún no tienes favoritos</p>
          <small>Haz clic en el corazón de un producto para guardarlo aquí</small>
        </div>`;
      return;
    }
    body.innerHTML = list.map(item => `
      <div class="sp-item" data-id="${item.id}">
        <div class="sp-item-thumb">${productThumb(item)}</div>
        <div class="sp-item-info">
          <p class="sp-item-name">${item.nombre}</p>
          <p class="sp-item-price">${formatPrice(item.precio)}</p>
        </div>
        <button class="sp-remove-btn" data-panel="wish" data-id="${item.id}" aria-label="Eliminar de favoritos">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
            <path d="M10 11v6"></path><path d="M14 11v6"></path>
            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
          </svg>
        </button>
      </div>`).join('');
    body.querySelectorAll('[data-panel="wish"]').forEach(btn => {
      btn.addEventListener('click', () => { removeFromWishlist(+btn.dataset.id); });
    });
  }

  // ─── CART RENDER ───────────────────────────────────────────────────────
  function renderCart() {
    const body   = document.getElementById('cart-body');
    const footer = document.getElementById('cart-footer');
    const list   = getCart();
    if (list.length === 0) {
      body.innerHTML = `
        <div class="sp-empty">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle>
            <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
          </svg>
          <p>Tu carrito está vacío</p>
          <small>Agrega productos desde la colección</small>
        </div>`;
      footer.style.display = 'none';
      return;
    }
    const total = list.reduce((s, i) => s + i.precio * i.cantidad, 0);
    body.innerHTML = list.map(item => `
      <div class="sp-item" data-id="${item.id}">
        <div class="sp-item-thumb">${productThumb(item)}</div>
        <div class="sp-item-info">
          <p class="sp-item-name">${item.nombre}</p>
          <p class="sp-item-price">${formatPrice(item.precio)}</p>
          <div class="sp-qty-controls">
            <button class="sp-qty-btn" data-action="minus" data-id="${item.id}">&#8722;</button>
            <span class="sp-qty-count">${item.cantidad}</span>
            <button class="sp-qty-btn" data-action="plus"  data-id="${item.id}">&#43;</button>
          </div>
        </div>
        <button class="sp-remove-btn" data-panel="cart" data-id="${item.id}" aria-label="Eliminar del carrito">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
            <path d="M10 11v6"></path><path d="M14 11v6"></path>
            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
          </svg>
        </button>
      </div>`).join('');
    document.getElementById('cart-total').textContent = formatPrice(total);
    footer.style.display = 'flex';
    body.querySelectorAll('[data-panel="cart"]').forEach(btn => {
      btn.addEventListener('click', () => { removeFromCart(+btn.dataset.id); });
    });
    body.querySelectorAll('.sp-qty-btn').forEach(btn => {
      btn.addEventListener('click', () => { changeQty(+btn.dataset.id, btn.dataset.action); });
    });
  }

  // ─── WISHLIST ACTIONS ──────────────────────────────────────────────────
  function toggleWishlist(product) {
    let list = getWishlist();
    const idx = list.findIndex(p => p.id === product.id);
    if (idx >= 0) { list.splice(idx, 1); }
    else          { list.push(product); }
    saveWishlist(list);
    updateBadges();
    updateWishlistButtons();
    renderWishlist();
  }
  function removeFromWishlist(id) {
    saveWishlist(getWishlist().filter(p => p.id !== id));
    updateBadges(); updateWishlistButtons(); renderWishlist();
  }

  // ─── CART ACTIONS ──────────────────────────────────────────────────────
  function addToCart(product) {
    let list = getCart();
    const idx = list.findIndex(p => p.id === product.id);
    if (idx >= 0) { list[idx].cantidad += 1; }
    else          { list.push({ ...product, cantidad: 1 }); }
    saveCart(list);
    updateBadges(); renderCart();
    openPanel(cartPanel);
  }
  function removeFromCart(id) {
    saveCart(getCart().filter(p => p.id !== id));
    updateBadges(); renderCart();
  }
  function changeQty(id, action) {
    let list = getCart();
    const idx = list.findIndex(p => p.id === id);
    if (idx < 0) return;
    if (action === 'plus')  { list[idx].cantidad += 1; }
    if (action === 'minus') { list[idx].cantidad -= 1; if (list[idx].cantidad <= 0) list.splice(idx, 1); }
    saveCart(list);
    updateBadges(); renderCart();
  }

  // ─── UPDATE HEART BUTTONS ─────────────────────────────────────────────
  function updateWishlistButtons() {
    const list = getWishlist();
    document.querySelectorAll('.product-card').forEach(card => {
      const id  = +card.dataset.id;
      const btn = card.querySelector('.wishlist-btn');
      if (!btn) return;
      const inList = list.some(p => p.id === id);
      btn.classList.toggle('wishlist-btn--active', inList);
      const path = btn.querySelector('path');
      if (path) { path.setAttribute('fill', inList ? '#A94A42' : 'none'); path.setAttribute('stroke', inList ? '#A94A42' : 'currentColor'); }
    });
  }

  // ─── PRODUCT CARD EVENTS ──────────────────────────────────────────────
  document.querySelectorAll('.product-card').forEach(card => {
    const id      = +card.dataset.id;
    const nombre  = card.dataset.nombre;
    const precio  = +card.dataset.precio;
    const inicial = card.dataset.inicial;
    const imagen  = card.dataset.imagen;
    const product = { id, nombre, precio, inicial, imagen };

    const wishBtn = card.querySelector('.wishlist-btn');
    if (wishBtn) wishBtn.addEventListener('click', e => { e.stopPropagation(); toggleWishlist(product); });

    const cartBtn = card.querySelector('.add-to-cart-btn');
    if (cartBtn) cartBtn.addEventListener('click', e => { e.stopPropagation(); addToCart(product); });
  });

  // ─── HEADER ICON EVENTS ───────────────────────────────────────────────
  document.getElementById('wishlist-header-btn').addEventListener('click', () => { renderWishlist(); openPanel(wishPanel); });
  document.getElementById('cart-header-btn').addEventListener('click',    () => { renderCart();     openPanel(cartPanel);  });

  // ─── CHECKOUT ─────────────────────────────────────────────────────────
  document.getElementById('checkout-btn').addEventListener('click', () => {
    closeAllPanels();
    setTimeout(() => {
      alert('✅ Compra finalizada. ¡Muchas gracias por confiar en nosotros!');
      saveCart([]);
      updateBadges();
    }, 300);
  });

  // ─── ACCOUNT DROPDOWN ─────────────────────────────────────────────────
  const accountBtn      = document.querySelector('.account-btn');
  const accountDropdown = document.querySelector('.account-dropdown');
  const accountMenu     = document.querySelector('.account-menu');
  if (accountBtn && accountDropdown) {
    accountBtn.addEventListener('click', e => { e.stopPropagation(); accountDropdown.classList.toggle('active'); });
    document.addEventListener('click', e => { if (!accountMenu.contains(e.target)) accountDropdown.classList.remove('active'); });
  }

  // ─── MOBILE DRAWER ────────────────────────────────────────────────────
  const mobileMenuToggle   = document.getElementById('mobile-menu-toggle');
  const mobileDrawer       = document.getElementById('mobile-drawer');
  const mobileDrawerClose  = document.getElementById('mobile-drawer-close');
  const mobileDrawerOverlay= document.getElementById('mobile-drawer-overlay');
  const mobileDrawerLinks  = document.querySelectorAll('.mobile-drawer-link');

  function openMobileDrawer()  { mobileDrawer.classList.add('active'); mobileMenuToggle.setAttribute('aria-expanded','true');  document.body.style.overflow='hidden'; }
  function closeMobileDrawer() { mobileDrawer.classList.remove('active'); mobileMenuToggle.setAttribute('aria-expanded','false'); document.body.style.overflow=''; }
  if (mobileMenuToggle && mobileDrawer) {
    mobileMenuToggle.addEventListener('click', openMobileDrawer);
    mobileDrawerClose.addEventListener('click', closeMobileDrawer);
    mobileDrawerOverlay.addEventListener('click', closeMobileDrawer);
    mobileDrawerLinks.forEach(l => l.addEventListener('click', closeMobileDrawer));
  }

  // ─── INIT ─────────────────────────────────────────────────────────────
  updateBadges();
  updateWishlistButtons();
  </script>
</body>
</html>
