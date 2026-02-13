<?= $this->extend('tienda/templates/header') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
            <li class="breadcrumb-item active"><?= $categoria['nombre'] ?></li>
        </ol>
    </nav>

    <div class="d-flex align-items-center mb-4">
        <div class="category-icon me-3" style="background-color: <?= $categoria['color'] ?>; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <i class="bi <?= $categoria['icono'] ?> fs-3 text-white"></i>
        </div>
        <div>
            <h2 class="mb-0"><?= $categoria['nombre'] ?></h2>
            <p class="text-muted mb-0"><?= count($productos) ?> productos</p>
        </div>
    </div>

    <?php if (empty($productos)): ?>
        <div class="text-center py-5">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <h4 class="mt-3">No hay productos en esta categoría</h4>
            <a href="<?= base_url('catalogo') ?>" class="btn btn-primary">Ver otras categorías</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($productos as $prod): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="product-card position-relative">
                        <img src="<?= $prod['imagen'] ? base_url('uploads/productos/' . $prod['imagen']) : base_url('assets/images/no-image.jpg') ?>"
                            class="product-img w-100" alt="<?= $prod['nombre'] ?>">

                        <div class="card-body p-3">
                            <h5 class="card-title mt-1 mb-2"><?= character_limiter($prod['nombre'], 35) ?></h5>

                            <div class="d-flex align-items-center mb-3">
                                <?php if ($prod['precio_oferta']): ?>
                                    <span class="price-original me-2"><?= formato_moneda($prod['precio']) ?></span>
                                    <span class="price-tag"><?= formato_moneda($prod['precio_oferta']) ?></span>
                                <?php else: ?>
                                    <span class="price-tag"><?= formato_moneda($prod['precio']) ?></span>
                                <?php endif; ?>
                            </div>

                            <button class="btn btn-primary btn-add-cart w-100" onclick="agregarAlCarrito(<?= $prod['id'] ?>)">
                                <i class="bi bi-cart-plus me-2"></i>Agregar
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>