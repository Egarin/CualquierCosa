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

    .card-title-mat {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2a3547;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #ebf1f6;
    }

    .order-item {
        padding: 15px 0;
        border-bottom: 1px dashed #ebf1f6;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .item-img {
        width: 70px;
        height: 70px;
        border-radius: 12px;
        object-fit: cover;
        background-color: #f6f9fc;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-badge.entregado {
        background-color: #e6fffa;
        color: #13deb9;
    }

    .status-badge.pendiente {
        background-color: #fff8ec;
        color: #ffae1f;
    }

    .status-badge.cancelado {
        background-color: #fdede8;
        color: #fa896b;
    }

    .status-badge.procesando {
        background-color: #ebf3fe;
        color: #5d87ff;
    }

    .info-label {
        font-size: 0.85rem;
        color: #5a6a85;
        margin-bottom: 4px;
    }

    .info-value {
        font-weight: 600;
        color: #2a3547;
    }
</style>

<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Detalles del Pedido #<?= $pedido['codigo'] ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small text-muted">
                    <li class="breadcrumb-item"><a href="<?= base_url('mis-pedidos') ?>" class="text-decoration-none text-muted">Mis Pedidos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">#<?= $pedido['codigo'] ?></li>
                </ol>
            </nav>
        </div>
        <div>
            <?php
            $estadoClass = match ($pedido['estado']) {
                'entregado' => 'entregado',
                'cancelado' => 'cancelado',
                'pendiente' => 'pendiente',
                default => 'procesando'
            };
            ?>
            <span class="status-badge <?= $estadoClass ?> fs-6">
                <?= ucfirst($pedido['estado']) ?>
            </span>
        </div>
    </div>

    <div class="row">
        <!-- Products Column -->
        <div class="col-lg-8">
            <div class="sidebar-card p-4">
                <h5 class="card-title-mat">Productos</h5>
                <div class="order-items-list">
                    <?php foreach ($pedido['detalles'] as $det): ?>
                        <div class="order-item d-flex align-items-center">
                            <img src="<?= $det['imagen'] ? base_url('uploads/productos/' . $det['imagen']) : base_url('assets/images/no-image.jpg') ?>"
                                class="item-img shadow-sm" alt="<?= $det['producto_nombre'] ?>">

                            <div class="ms-3 flex-grow-1">
                                <h6 class="fw-bold text-dark mb-1"><?= $det['producto_nombre'] ?></h6>
                                <small class="text-muted d-block">Cantidad: <?= $det['cantidad'] ?></small>
                            </div>

                            <div class="text-end">
                                <div class="fw-bold text-dark">S/ <?= number_format($det['subtotal'], 2) ?></div>
                                <small class="text-muted">S/ <?= number_format($det['precio_unitario'], 2) ?> c/u</small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-4 pt-3 border-top border-light">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold text-dark">S/ <?= number_format($pedido['subtotal'], 2) ?></span>
                    </div>
                    <?php if ($pedido['costo_envio'] > 0): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Envío</span>
                            <span class="fw-bold text-dark">S/ <?= number_format($pedido['costo_envio'], 2) ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between mt-3 pt-3 border-top border-light">
                        <span class="fs-5 fw-bold text-dark">Total</span>
                        <span class="fs-5 fw-bold text-primary">S/ <?= number_format($pedido['total'], 2) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Column -->
        <div class="col-lg-4">
            <div class="sidebar-card p-4">
                <h5 class="card-title-mat">Información de Entrega</h5>

                <div class="mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-light rounded p-2 me-3 text-primary">
                            <i class="bi bi-truck fs-5"></i>
                        </div>
                        <div>
                            <div class="info-label">Método de Envío</div>
                            <div class="info-value"><?= $pedido['tipo_envio'] == 'delivery' ? 'Delivery' : 'Recojo en tienda' ?></div>
                        </div>
                    </div>

                    <?php if ($pedido['tipo_envio'] == 'delivery' && $pedido['direccion']): ?>
                        <div class="d-flex align-items-start mt-3">
                            <div class="bg-light rounded p-2 me-3 text-primary">
                                <i class="bi bi-geo-alt fs-5"></i>
                            </div>
                            <div>
                                <div class="info-label">Dirección de Entrega</div>
                                <div class="info-value text-break"><?= $pedido['direccion'] ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <h5 class="card-title-mat mt-2">Método de Pago</h5>
                <div class="d-flex align-items-center">
                    <div class="bg-light rounded p-2 me-3 text-primary">
                        <i class="bi bi-credit-card fs-5"></i>
                    </div>
                    <div>
                        <div class="info-label">Pago</div>
                        <div class="info-value"><?= ucfirst($pedido['metodo_pago']) ?></div>
                    </div>
                </div>
            </div>

            <a href="<?= base_url('mis-pedidos') ?>" class="btn btn-outline-primary w-100 rounded-pill mb-3">
                <i class="bi bi-arrow-left me-2"></i>Volver a mis pedidos
            </a>

            <a href="<?= base_url('catalogo') ?>" class="btn btn-primary w-100 rounded-pill">
                <i class="bi bi-cart-plus me-2"></i>Seguir comprando
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>