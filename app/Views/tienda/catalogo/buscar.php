<?= $this->extend('tienda/templates/header') ?>

<?= $this->section('content') ?>
<style>
    /* MatDash Style Overrides (Same as Index) */
    body {
        background-color: #f5f8fa;
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
</style>

<div class="container py-4">
    <!-- Header with Breadcrumb/Title Area -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold mb-0 text-dark">
                <?php if ($busqueda): ?>
                    Resultados para "<?= esc($busqueda) ?>"
                <?php else: ?>
                    Todos los productos
                <?php endif; ?>
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small text-muted">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Búsqueda</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="sidebar-card">
                <h5 class="sidebar-title">Categorías</h5>
                <div class="d-flex flex-column">
                    <a href="<?= base_url('catalogo') ?>" class="filter-link">
                        <i class="bi bi-grid"></i>
                        Todas
                    </a>
                    <?php if (isset($categorias)): ?>
                        <?php foreach ($categorias as $cat): ?>
                            <a href="<?= base_url('catalogo/categoria/' . $cat['slug']) ?>" class="filter-link">
                                <i class="bi <?= $cat['icono'] ?? 'bi-tag' ?>"></i>
                                <?= $cat['nombre'] ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <hr class="my-4 border-light">
                <div class="d-grid">
                    <a href="<?= base_url('catalogo') ?>" class="btn btn-outline-primary rounded-pill">
                        Ver todo el catálogo
                    </a>
                </div>
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

            <div class="row g-4">
                <?php if (empty($productos)): ?>
                    <div class="col-12 text-center py-5">
                        <div class="sidebar-card py-5">
                            <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
                            <h5 class="text-muted">No se encontraron productos</h5>
                            <p class="text-muted mb-4">Intenta con otros términos de búsqueda o navega por las categorías.</p>
                            <a href="<?= base_url('catalogo') ?>" class="btn btn-primary rounded-pill px-4">Ir al Catálogo</a>
                        </div>
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
                                                <span class="mat-product-price">Gs. <?= number_format($prod['precio_oferta'], 0) ?></span>
                                                <span class="mat-product-price-old">Gs. <?= number_format($prod['precio'], 0) ?></span>
                                            <?php else: ?>
                                                <span class="mat-product-price">Gs. <?= number_format($prod['precio'], 0) ?></span>
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
<?= $this->endSection() ?>