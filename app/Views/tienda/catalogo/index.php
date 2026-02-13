<?= $this->extend('tienda/templates/header') ?>

<?= $this->section('content') ?>
<style>
    /* MatDash Inspired Store Styles */
    :root {
        --mat-primary: #5D87FF;
        --mat-primary-dark: #4570EA;
        --mat-secondary: #49BEFF;
        --mat-dark: #2A3547;
        --mat-muted: #5A6A85;
        --mat-light: #ECF2FF;
        --mat-border: #DFE5EF;
        --mat-font: 'Plus Jakarta Sans', 'Inter', sans-serif;
    }

    body {
        background-color: #F4F6F9;
        /* Slightly off-white for depth */
        color: var(--mat-dark);
        font-family: var(--mat-font);
    }

    /* Sidebar Styles */
    .sidebar-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 24px 0 rgba(34, 41, 47, 0.05);
        border: none;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .sidebar-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--mat-border);
        background: white;
    }

    .sidebar-title {
        font-size: 0.9rem;
        font-weight: 700;
        margin: 0;
        color: var(--mat-dark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .category-list {
        padding: 12px;
    }

    .category-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        color: var(--mat-muted);
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.2s ease-in-out;
        margin-bottom: 4px;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .category-item:hover {
        background-color: var(--mat-light);
        color: var(--mat-primary);
        transform: translateX(3px);
    }

    .category-item.active {
        background: linear-gradient(45deg, var(--mat-primary) 0%, var(--mat-primary-dark) 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(93, 135, 255, 0.2);
    }

    .category-count {
        font-size: 0.75rem;
        padding: 2px 8px;
        border-radius: 10px;
        background-color: rgba(0, 0, 0, 0.06);
        color: inherit;
        font-weight: 600;
    }

    .category-item.active .category-count {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .category-icon {
        width: 24px;
        display: inline-block;
        text-align: center;
        margin-right: 8px;
    }

    /* Custom Radio for Sorting */
    .sort-option {
        display: flex;
        align-items: center;
        padding: 12px 24px;
        cursor: pointer;
        transition: 0.2s;
        border-left: 3px solid transparent;
    }

    .sort-option:hover {
        background-color: #f8f9fa;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        margin-right: 12px;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--mat-primary);
        border-color: var(--mat-primary);
    }

    .sort-option:has(.form-check-input:checked) {
        border-left-color: var(--mat-primary);
        background-color: #FBFDFF;
    }

    .sort-label {
        font-size: 0.95rem;
        color: var(--mat-muted);
        font-weight: 500;
        cursor: pointer;
    }

    .form-check-input:checked~.sort-label {
        color: var(--mat-dark);
        font-weight: 600;
    }

    /* Product Card */
    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.02);
        border: 1px solid transparent;
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        border-color: var(--mat-light);
    }

    .product-img-wrap {
        position: relative;
        padding-top: 100%;
        /* Square */
        overflow: hidden;
        background: #fff;
    }

    .product-img {
        position: absolute;
        top: 15px;
        left: 15px;
        width: calc(100% - 30px);
        height: calc(100% - 30px);
        object-fit: contain;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-img {
        transform: scale(1.08);
    }

    .badge-promo {
        position: absolute;
        top: 16px;
        left: 16px;
        background: #FA896B;
        color: white;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 8px;
        z-index: 2;
        box-shadow: 0 4px 8px rgba(250, 137, 107, 0.3);
    }

    .action-btn-overlay {
        position: absolute;
        bottom: 15px;
        right: 15px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.3s ease;
        z-index: 3;
    }

    .product-card:hover .action-btn-overlay {
        opacity: 1;
        transform: translateX(0);
    }

    .btn-icon-action {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: white;
        color: var(--mat-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 1.1rem;
    }

    .btn-icon-action:hover {
        background: var(--mat-primary);
        color: white;
        transform: scale(1.1);
    }

    .btn-icon-action.btn-cart {
        background: var(--mat-primary);
        color: white;
    }

    .btn-icon-action.btn-cart:hover {
        background: var(--mat-primary-dark);
    }

    .product-info {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-category {
        font-size: 0.75rem;
        color: var(--mat-muted);
        text-transform: uppercase;
        font-weight: 700;
        margin-bottom: 6px;
        letter-spacing: 0.5px;
    }

    .product-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--mat-dark);
        margin-bottom: auto;
        /* Push price to bottom */
        line-height: 1.5;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.2s;
    }

    .product-title:hover {
        color: var(--mat-primary);
    }

    .product-price-section {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px dashed var(--mat-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .price-wrap {
        display: flex;
        flex-direction: column;
    }

    .price-current {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--mat-dark);
    }

    .price-old {
        font-size: 0.8rem;
        color: var(--mat-muted);
        text-decoration: line-through;
    }

    /* Search Bar */
    .search-hero {
        position: relative;
        margin-bottom: 30px;
    }

    .search-input-lg {
        width: 100%;
        padding: 18px 25px;
        padding-left: 60px;
        border-radius: 16px;
        border: none;
        background: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        font-size: 1.05rem;
        transition: all 0.3s;
    }

    .search-input-lg:focus {
        box-shadow: 0 8px 30px rgba(93, 135, 255, 0.15);
        outline: none;
    }

    .search-icon-lg {
        position: absolute;
        left: 24px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.4rem;
        color: var(--mat-primary);
    }

    /* Promo Banner */
    .promo-banner {
        background: linear-gradient(135deg, #5D87FF 0%, #4570EA 100%);
        border-radius: 16px;
        padding: 32px;
        color: white;
        position: relative;
        overflow: hidden;
        text-align: center;
        margin-top: 24px;
        box-shadow: 0 10px 30px rgba(93, 135, 255, 0.3);
    }

    .promo-deco-1 {
        position: absolute;
        top: -30px;
        right: -30px;
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
    }

    .promo-deco-2 {
        position: absolute;
        bottom: -20px;
        left: -20px;
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
</style>

<div class="container py-5">
    <!-- Header Area -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h2 class="fw-bold mb-3" style="color: var(--mat-dark);">Catálogo de Productos</h2>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <!-- Search Widget (Mobile/Desktop) -->
            <div class="sidebar-card d-lg-none">
                <div class="p-3">
                    <form action="<?= base_url('catalogo/buscar') ?>" method="GET" class="position-relative">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" name="q" class="form-control rounded-pill ps-5 border-0 bg-light" placeholder="Buscar..." value="<?= isset($_GET['q']) ? esc($_GET['q']) : '' ?>">
                    </form>
                </div>
            </div>

            <!-- Categories Widget -->
            <div class="sidebar-card">
                <div class="sidebar-header">
                    <h5 class="sidebar-title"><i class="bi bi-grid-fill me-2 text-primary"></i> Categorías</h5>
                </div>
                <div class="category-list">
                    <a href="<?= base_url('catalogo') ?>" class="category-item <?= !isset($categoria_actual) ? 'active' : '' ?>">
                        <span><span class="category-icon"><i class="bi bi-shop"></i></span> Todas</span>
                    </a>
                    <?php foreach ($categorias as $cat): ?>
                        <a href="<?= base_url('catalogo/categoria/' . $cat['slug']) ?>"
                            class="category-item <?= isset($categoria_actual) && $categoria_actual['id'] == $cat['id'] ? 'active' : '' ?>">
                            <span><span class="category-icon"><i class="bi <?= $cat['icono'] ?? 'bi-tag' ?>"></i></span> <?= $cat['nombre'] ?></span>
                            <span class="category-count"><?= $cat['total_productos'] ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Sort Widget -->
            <div class="sidebar-card">
                <div class="sidebar-header">
                    <h5 class="sidebar-title"><i class="bi bi-sort-down me-2 text-primary"></i> Ordenar</h5>
                </div>
                <div class="d-flex flex-column py-2">
                    <label class="sort-option">
                        <input class="form-check-input" type="radio" name="sort" onchange="location.href='<?= current_url() ?>?orden=nombre'" checked>
                        <span class="sort-label">Más Nuevos</span>
                    </label>
                    <label class="sort-option">
                        <input class="form-check-input" type="radio" name="sort" onchange="location.href='<?= current_url() ?>?orden=precio_asc'">
                        <span class="sort-label">Precio: Bajo a Alto</span>
                    </label>
                    <label class="sort-option">
                        <input class="form-check-input" type="radio" name="sort" onchange="location.href='<?= current_url() ?>?orden=precio_desc'">
                        <span class="sort-label">Precio: Alto a Bajo</span>
                    </label>
                    <label class="sort-option">
                        <input class="form-check-input" type="radio" name="sort" onchange="location.href='<?= current_url() ?>?orden=promo'">
                        <span class="sort-label">En Oferta</span>
                    </label>
                </div>
            </div>

            <!-- Promo Widget -->
            <div class="promo-banner d-none d-lg-block">
                <div class="promo-deco-1"></div>
                <div class="promo-deco-2"></div>
                <i class="bi bi-bag-heart-fill fs-1 mb-3 d-block"></i>
                <h5 class="fw-bold mb-2">Ofertas del Mes</h5>
                <p class="small opacity-90 mb-4">Descubre nuestros descuentos especiales por tiempo limitado.</p>
                <a href="<?= base_url('catalogo?orden=promo') ?>" class="btn btn-light rounded-pill text-primary fw-bold w-100 shadow-sm">Ver Ofertas</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Hero Search -->
            <div class="search-hero d-none d-lg-block">
                <form action="<?= base_url('catalogo/buscar') ?>" method="GET">
                    <i class="bi bi-search search-icon-lg"></i>
                    <input type="text" name="q" class="search-input-lg" placeholder="¿Qué estás buscando hoy?" value="<?= isset($_GET['q']) ? esc($_GET['q']) : '' ?>">
                </form>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="fw-bold text-dark mb-0">
                    <?php if (isset($categoria_actual)): ?>
                        Mostrando <?= $categoria_actual['nombre'] ?> <span class="text-muted fw-normal">(<?= count($productos) ?>)</span>
                    <?php else: ?>
                        Todos los Productos <span class="text-muted fw-normal">(<?= count($productos) ?>)</span>
                    <?php endif; ?>
                </h5>
            </div>

            <div class="row g-4">
                <?php if (empty($productos)): ?>
                    <div class="col-12">
                        <div class="text-center py-5 bg-white rounded-4 shadow-sm border-0">
                            <div class="mb-3">
                                <div class="bg-light-primary d-inline-block p-4 rounded-circle text-primary">
                                    <i class="bi bi-search fs-1"></i>
                                </div>
                            </div>
                            <h4 class="fw-bold text-dark">No encontramos resultados</h4>
                            <p class="text-muted">Intenta ajustar tu búsqueda o filtros.</p>
                            <a href="<?= base_url('catalogo') ?>" class="btn btn-primary rounded-pill px-4 mt-2">Ver todo el catálogo</a>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($productos as $prod): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="product-card">
                                <div class="product-img-wrap">
                                    <?php if ($prod['precio_oferta']): ?>
                                        <div class="badge-promo">
                                            -<?= round((1 - $prod['precio_oferta'] / $prod['precio']) * 100) ?>%
                                        </div>
                                    <?php endif; ?>

                                    <a href="<?= base_url('producto/' . $prod['slug']) ?>">
                                        <img src="<?= $prod['imagen'] ? base_url('uploads/productos/' . $prod['imagen']) : base_url('assets/images/no-image.jpg') ?>"
                                            class="product-img" alt="<?= $prod['nombre'] ?>">
                                    </a>

                                    <div class="action-btn-overlay">
                                        <button class="btn-icon-action btn-cart" onclick="agregarAlCarrito(<?= $prod['id'] ?>)" title="Agregar al carrito">
                                            <i class="bi bi-bag-plus-fill"></i>
                                        </button>
                                        <a href="<?= base_url('producto/' . $prod['slug']) ?>" class="btn-icon-action" title="Ver detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="product-info">
                                    <div class="product-category"><?= $prod['categoria_nombre'] ?? 'General' ?></div>
                                    <a href="<?= base_url('producto/' . $prod['slug']) ?>" class="product-title" title="<?= $prod['nombre'] ?>">
                                        <?= $prod['nombre'] ?>
                                    </a>

                                    <div class="product-price-section">
                                        <div class="price-wrap">
                                            <?php if ($prod['precio_oferta']): ?>
                                                <span class="price-current"><?= formato_moneda($prod['precio_oferta']) ?></span>
                                                <span class="price-old"><?= formato_moneda($prod['precio']) ?></span>
                                            <?php else: ?>
                                                <span class="price-current"><?= formato_moneda($prod['precio']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-warning small">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-half"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const sort = urlParams.get('orden');
        if (sort) {
            const radio = document.querySelector(`input[name="sort"][onchange*="${sort}"]`);
            if (radio) radio.checked = true;
        }
    });
</script>

<?= $this->endSection() ?>