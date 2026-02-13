<?= $this->extend('tienda/templates/header') ?>

<?= $this->section('content') ?>
<style>
    /* MatDash Style Overrides */
    body {
        background-color: #f5f8fa;
        /* Soft gray background like dashboard */
    }

    .sidebar-card {
        background: white;
        border-radius: 16px;
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.03);
        padding: 24px;
        margin-bottom: 24px;
    }

    .sidebar-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #2a3547;
    }

    .filter-link {
        display: flex;
        align-items: center;
        padding: 10px 16px;
        color: #5a6a85;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s;
        margin-bottom: 4px;
        font-weight: 500;
    }

    .filter-link:hover,
    .filter-link.active {
        background-color: #ecf2ff;
        color: #5d87ff;
    }

    .filter-link i {
        font-size: 1.2rem;
        margin-right: 12px;
    }

    .mat-product-card {
        background: white;
        border-radius: 16px;
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
    }

    .mat-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .mat-card-img-wrapper {
        position: relative;
        padding-top: 100%;
        /* 1:1 Aspect Ratio */
        background-color: #f6f9fc;
        overflow: hidden;
    }

    .mat-card-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* or contain depending on image style */
        padding: 20px;
        transition: transform 0.3s;
    }

    .mat-product-card:hover .mat-card-img {
        transform: scale(1.05);
    }

    .btn-add-circle {
        position: absolute;
        bottom: 15px;
        right: 15px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #5d87ff;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(93, 135, 255, 0.3);
        transition: all 0.2s;
        z-index: 2;
    }

    .btn-add-circle:hover {
        background: #4570ea;
        transform: scale(1.1);
    }

    .mat-card-body {
        padding: 20px;
    }

    .mat-product-title {
        font-size: 1rem;
        font-weight: 600;
        color: #2a3547;
        margin-bottom: 8px;
        display: block;
        text-decoration: none;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .mat-product-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2a3547;
    }

    .mat-product-price-old {
        font-size: 0.9rem;
        color: #99a1b7;
        text-decoration: line-through;
        margin-left: 8px;
    }

    .rating-stars {
        color: #ffc107;
        font-size: 0.85rem;
    }

    .search-input-mat {
        background: white;
        border: 1px solid #dfe5ef;
        border-radius: 12px;
        padding: 12px 20px;
        padding-left: 45px;
        width: 100%;
        transition: all 0.2s;
    }

    .search-input-mat:focus {
        border-color: #5d87ff;
        box-shadow: 0 0 0 4px rgba(93, 135, 255, 0.1);
        outline: none;
    }

    .search-icon-wrapper {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #7c8fac;
    }

    /* Custom Scrollbar for sidebar if needed */
    .sidebar-content::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-content::-webkit-scrollbar-thumb {
        background-color: #e1e4e8;
        border-radius: 3px;
    }
</style>

<div class="container py-4">
    <!-- Header with Breadcrumb/Title Area -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold mb-0 text-dark">Tienda</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small text-muted">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Catálogo</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 d-flex justify-content-md-end mt-3 mt-md-0">
            <!-- Optional Top Actions -->
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="sidebar-card">
                <h5 class="sidebar-title">Filtrar por Categoría</h5>
                <div class="d-flex flex-column">
                    <a href="<?= base_url('catalogo') ?>" class="filter-link <?= !isset($categoria_actual) ? 'active' : '' ?>">
                        <i class="bi bi-grid"></i>
                        Todas
                    </a>
                    <?php foreach ($categorias as $cat): ?>
                        <a href="<?= base_url('catalogo/categoria/' . $cat['slug']) ?>"
                            class="filter-link <?= isset($categoria_actual) && $categoria_actual['id'] == $cat['id'] ? 'active' : '' ?>">
                            <i class="bi <?= $cat['icono'] ?? 'bi-tag' ?>"></i>
                            <?= $cat['nombre'] ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <hr class="my-4 border-light">

                <h5 class="sidebar-title">Ordenar Por</h5>
                <div class="d-flex flex-column gap-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sort" id="sortNew"
                            onchange="location.href='<?= current_url() ?>?orden=nombre'" checked>
                        <label class="form-check-label text-muted" for="sortNew">Nuevos</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sort" id="sortPriceAsc"
                            onchange="location.href='<?= current_url() ?>?orden=precio_asc'">
                        <label class="form-check-label text-muted" for="sortPriceAsc">Precio: Bajo a Alto</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sort" id="sortPriceDesc"
                            onchange="location.href='<?= current_url() ?>?orden=precio_desc'">
                        <label class="form-check-label text-muted" for="sortPriceDesc">Precio: Alto a Bajo</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sort" id="sortPromo"
                            onchange="location.href='<?= current_url() ?>?orden=promo'">
                        <label class="form-check-label text-muted" for="sortPromo">En Oferta</label>
                    </div>
                </div>
            </div>

            <!-- Optional Banner Sidebar -->
            <div class="sidebar-card bg-primary text-white text-center p-4 d-none d-lg-block">
                <i class="bi bi-bag-heart fs-1 mb-3"></i>
                <h5 class="fw-bold text-white mb-2">Ofertas Especiales</h5>
                <p class="small opacity-75 mb-3">¡Hasta 50% de descuento en productos seleccionados!</p>
                <button class="btn btn-white text-primary btn-sm rounded-pill fw-bold w-100">Ver Ofertas</button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Search & Filters Bar -->
            <div class="sidebar-card p-3 mb-4 d-flex flex-wrap align-items-center gap-3">
                <form action="<?= base_url('catalogo/buscar') ?>" method="GET" class="flex-grow-1 position-relative">
                    <div class="search-icon-wrapper">
                        <i class="bi bi-search"></i>
                    </div>
                    <input type="text" name="q" class="search-input-mat" placeholder="Buscar producto..." value="<?= isset($_GET['q']) ? esc($_GET['q']) : '' ?>">
                </form>
            </div>

            <h5 class="fw-bold mb-4 text-dark">Productos (<?= count($productos) ?>)</h5>

            <div class="row g-4">
                <?php if (empty($productos)): ?>
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-box-seam fs-1 text-muted d-block mb-3"></i>
                        <h5 class="text-muted">No se encontraron productos</h5>
                        <a href="<?= base_url('catalogo') ?>" class="btn btn-primary mt-2 rounded-pill">Ver todo</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($productos as $prod): ?>
                        <div class="col-sm-6 col-lg-4 col-xl-4">
                            <div class="mat-product-card">
                                <div class="mat-card-img-wrapper">
                                    <a href="<?= base_url('producto/' . $prod['slug']) ?>">
                                        <img src="<?= $prod['imagen'] ? base_url('uploads/productos/' . $prod['imagen']) : base_url('assets/images/no-image.jpg') ?>"
                                            class="mat-card-img" alt="<?= $prod['nombre'] ?>">
                                    </a>
                                    <?php if ($prod['precio_oferta']): ?>
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-3 rounded-pill">-<?= round((1 - $prod['precio_oferta'] / $prod['precio']) * 100) ?>%</span>
                                    <?php endif; ?>

                                    <button class="btn-add-circle" onclick="agregarAlCarrito(<?= $prod['id'] ?>)" title="Agregar al carrito">
                                        <i class="bi bi-bag-plus"></i>
                                    </button>
                                </div>

                                <div class="mat-card-body">
                                    <a href="<?= base_url('producto/' . $prod['slug']) ?>" class="mat-product-title" title="<?= $prod['nombre'] ?>">
                                        <?= $prod['nombre'] ?>
                                    </a>

                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                        <div>
                                            <?php if ($prod['precio_oferta']): ?>
                                                <span class="mat-product-price">S/ <?= number_format($prod['precio_oferta'], 2) ?></span>
                                                <span class="mat-product-price-old">S/ <?= number_format($prod['precio'], 2) ?></span>
                                            <?php else: ?>
                                                <span class="mat-product-price">S/ <?= number_format($prod['precio'], 2) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="rating-stars">
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

<!-- Scripts for Radio Buttons State -->
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