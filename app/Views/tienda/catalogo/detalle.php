<?= $this->extend('tienda/templates/header') ?>

<?= $this->section('content') ?>
<style>
    body {
        background-color: #f5f8fa;
    }

    .sidebar-card {
        background: white;
        border-radius: 16px;
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.03);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .product-image-container {
        border-radius: 16px;
        overflow: hidden;
        background-color: #f6f9fc;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .product-detail-img {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .product-detail-img:hover {
        transform: scale(1.05);
    }

    .price-large {
        font-size: 2rem;
        font-weight: 700;
        color: #2a3547;
    }

    .price-old-large {
        font-size: 1.25rem;
        color: #99a1b7;
        text-decoration: line-through;
        margin-left: 10px;
    }

    .badge-stock {
        background-color: #e6fffa;
        color: #13deb9;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 6px;
    }

    .badge-out {
        background-color: #fdede8;
        color: #fa896b;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 6px;
    }

    .btn-buy-now {
        background-color: #5d87ff;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.2s;
    }

    .btn-buy-now:hover {
        background-color: #4570ea;
        color: white;
        transform: translateY(-2px);
    }

    .btn-add-cart-detail {
        background-color: #ffae1f;
        /* Warning color or Pink as per MatDash often uses secondary */
        /* Let's use a nice Pink/Red for variation or keep it secondary */
        background-color: #fa896b;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.2s;
    }

    .btn-add-cart-detail:hover {
        background-color: #e57c5f;
        color: white;
        transform: translateY(-2px);
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        border: 1px solid #dfe5ef;
        border-radius: 8px;
        overflow: hidden;
        width: 140px;
    }

    .quantity-btn {
        background: white;
        border: none;
        padding: 10px 15px;
        color: #5a6a85;
        transition: background 0.2s;
    }

    .quantity-btn:hover {
        background-color: #f6f9fc;
    }

    .quantity-input {
        border: none;
        text-align: center;
        width: 50px;
        font-weight: 600;
        color: #2a3547;
        -moz-appearance: textfield;
    }

    .quantity-input::-webkit-outer-spin-button,
    .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .nav-tabs-custom .nav-link {
        color: #5a6a85;
        font-weight: 600;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 15px 20px;
    }

    .nav-tabs-custom .nav-link.active {
        color: #5d87ff;
        border-bottom-color: #5d87ff;
        background: transparent;
    }

    .nav-tabs-custom {
        border-bottom: 1px solid #ebf1f6;
    }

    /* Related Products Card Override */
    .product-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
        background: white;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .product-img-wrapper {
        position: relative;
        padding-top: 100%;
        /* 1:1 Aspect Ratio */
        background-color: #f6f9fc;
        overflow: hidden;
    }

    .product-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        padding: 15px;
    }
</style>

<div class="container py-4">
    <div class="sidebar-card p-4">
        <div class="row g-5">
            <!-- Left Column: Image -->
            <div class="col-lg-6">
                <div class="product-image-container mb-4">
                    <img src="<?= $producto['imagen'] ? base_url('uploads/productos/' . $producto['imagen']) : base_url('assets/images/no-image.jpg') ?>"
                        class="product-detail-img" alt="<?= $producto['nombre'] ?>">
                </div>
                <!-- Thumbnails (Static for now as mostly single image) -->
                <div class="d-flex gap-2 justify-content-center">
                    <div style="width: 80px; height: 80px; border-radius: 10px; border: 2px solid #5d87ff; padding: 5px; cursor: pointer;">
                        <img src="<?= $producto['imagen'] ? base_url('uploads/productos/' . $producto['imagen']) : base_url('assets/images/no-image.jpg') ?>"
                            class="w-100 h-100 object-fit-cover rounded">
                    </div>
                    <!-- Placeholder Thumbnails -->
                    <?php for ($i = 0; $i < 3; $i++): ?>
                        <div style="width: 80px; height: 80px; border-radius: 10px; border: 1px solid #dfe5ef; padding: 5px; cursor: pointer; opacity: 0.6;">
                            <img src="<?= $producto['imagen'] ? base_url('uploads/productos/' . $producto['imagen']) : base_url('assets/images/no-image.jpg') ?>"
                                class="w-100 h-100 object-fit-cover rounded">
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Right Column: Details -->
            <div class="col-lg-6">
                <div class="d-flex align-items-center mb-2">
                    <span class="<?= $producto['stock'] > 0 ? 'badge-stock' : 'badge-out' ?> me-3">
                        <?= $producto['stock'] > 0 ? 'En Stock' : 'Agotado' ?>
                    </span>
                    <span class="text-muted small text-uppercase"><?= $producto['marca'] ?? 'Generico' ?></span>
                </div>

                <h2 class="fw-bold text-dark mb-3"><?= $producto['nombre'] ?></h2>
                <div class="d-flex align-items-center mb-4">
                    <div class="text-warning small me-2">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <span class="text-muted small">(15 reseñas)</span>
                </div>

                <div class="mb-4">
                    <?php if ($producto['precio_oferta']): ?>
                        <div class="d-flex align-items-end">
                            <span class="price-large">Gs. <?= number_format($producto['precio_oferta'], 0) ?></span>
                            <span class="price-old-large">Gs. <?= number_format($producto['precio'], 0) ?></span>
                        </div>
                    <?php else: ?>
                        <span class="price-large">Gs. <?= number_format($producto['precio'], 0) ?></span>
                    <?php endif; ?>
                </div>

                <p class="text-muted mb-5 leading-relaxed">
                    <?= character_limiter($producto['descripcion'], 200) ?>
                </p>

                <!-- Selectors -->
                <div class="d-flex align-items-center gap-5 mb-5">
                    <div>
                        <label class="fw-bold text-dark mb-2 d-block">Cantidad</label>
                        <div class="quantity-selector">
                            <button class="quantity-btn" type="button" onclick="updateQty(-1)" <?= $producto['stock'] <= 0 ? 'disabled' : '' ?>>-</button>
                            <input type="number" class="quantity-input" value="<?= $producto['stock'] > 0 ? 1 : 0 ?>" min="1" max="<?= $producto['stock'] ?>" id="cantidad" <?= $producto['stock'] <= 0 ? 'disabled' : '' ?>>
                            <button class="quantity-btn" type="button" onclick="updateQty(1)" <?= $producto['stock'] <= 0 ? 'disabled' : '' ?>>+</button>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex gap-3">
                    <button class="btn-buy-now flex-grow-1" onclick="comprarAhora()" <?= $producto['stock'] <= 0 ? 'disabled' : '' ?>>
                        Comprar Ahora
                    </button>
                    <button class="btn-add-cart-detail flex-grow-1" onclick="agregarAlCarrito(<?= $producto['id'] ?>, document.getElementById('cantidad').value)" <?= $producto['stock'] <= 0 ? 'disabled' : '' ?>>
                        <i class="bi bi-bag-plus me-2"></i>Agregar al Carrito
                    </button>
                </div>

                <div class="mt-4 pt-3 border-top border-light text-muted small">
                    <div class="mb-2"><i class="bi bi-truck me-2"></i>Envío gratis en pedidos mayores a Gs. 100.000</div>
                    <div><i class="bi bi-shield-check me-2"></i>Garantía de devolución de 30 días.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs: Description & Reviews -->
    <div class="sidebar-card p-0 mb-5">
        <ul class="nav nav-tabs nav-tabs-custom px-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab">Descripción</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Reseñas (15)</button>
            </li>
        </ul>
        <div class="tab-content p-4" id="myTabContent">
            <div class="tab-pane fade show active" id="desc" role="tabpanel">
                <h5 class="fw-bold text-dark mb-3">Descripción del Producto</h5>
                <p class="text-muted"><?= $producto['descripcion'] ?></p>
                <p class="text-muted">Unidad de venta: <strong><?= $producto['unidad'] ?></strong></p>
            </div>
            <div class="tab-pane fade" id="reviews" role="tabpanel">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex mb-4">
                            <div class="bg-light rounded-circle p-3 me-3 text-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-person-fill text-muted"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Juan Pérez</h6>
                                <div class="text-warning small mb-1">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <p class="text-muted small mb-0">Excelente producto, llegó muy rápido y en perfectas condiciones.</p>
                            </div>
                        </div>
                        <div class="d-flex mb-4">
                            <div class="bg-light rounded-circle p-3 me-3 text-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-person-fill text-muted"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Maria Gonzalez</h6>
                                <div class="text-warning small mb-1">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                                <p class="text-muted small mb-0">Buena relación calidad-precio. Recomendado.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($relacionados)): ?>
        <h4 class="fw-bold text-dark mb-4">Productos Relacionados</h4>
        <div class="row g-4 mb-5">
            <?php foreach ($relacionados as $rel): ?>
                <div class="col-md-3">
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <a href="<?= base_url('producto/' . $rel['slug']) ?>">
                                <img src="<?= $rel['imagen'] ? base_url('uploads/productos/' . $rel['imagen']) : base_url('assets/images/no-image.jpg') ?>"
                                    class="product-img" alt="<?= $rel['nombre'] ?>">
                            </a>
                        </div>
                        <div class="card-body p-3">
                            <h6 class="fw-bold text-dark mb-1 text-truncate">
                                <a href="<?= base_url('producto/' . $rel['slug']) ?>" class="text-dark text-decoration-none">
                                    <?= $rel['nombre'] ?>
                                </a>
                            </h6>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="fw-bold text-dark">Gs. <?= number_format($rel['precio_oferta'] ?? $rel['precio'], 0) ?></span>
                                <a href="<?= base_url('producto/' . $rel['slug']) ?>" class="btn btn-outline-primary btn-sm rounded-pill p-1 px-2">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    const maxStock = <?= $producto['stock'] ?>;

    function updateQty(change) {
        if (maxStock <= 0) return;

        const input = document.getElementById('cantidad');
        let val = parseInt(input.value) + change;
        if (val < 1) val = 1;
        if (val > maxStock) val = maxStock;
        input.value = val;
    }

    function comprarAhora() {
        if (maxStock <= 0) return;

        const id = <?= $producto['id'] ?>;
        const qty = document.getElementById('cantidad').value;
        const csrfToken = '<?= csrf_token() ?>';
        const csrfHash = document.getElementById('csrf-token').content;

        // Agregar al carrito y redirigir
        const formData = new FormData();
        formData.append('producto_id', id);
        formData.append('cantidad', qty);
        formData.append(csrfToken, csrfHash);

        fetch(BASE_URL + 'carrito/agregar', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = BASE_URL + 'checkout';
                } else {
                    // Show Error Toast (reusing header toast if available, or alert)
                    const errorToastBody = document.getElementById('errorToastBody');
                    if (errorToastBody) {
                        errorToastBody.innerHTML = '<i class="bi bi-exclamation-circle me-2"></i>' + (data.message || 'Error al procesar compra');
                        const errorToastEl = document.getElementById('errorToast');
                        if (errorToastEl) {
                            const toast = new bootstrap.Toast(errorToastEl);
                            toast.show();
                        }
                    } else {
                        alert(data.message || 'Error al procesar compra');
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>

<?= $this->endSection() ?>