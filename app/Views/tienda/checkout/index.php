<?= $this->extend('tienda/templates/header') ?>

<?= $this->section('content') ?>
<style>
    /* MatDash Inspired Checkout Styles */
    body {
        background-color: #f5f8fa;
        color: #5a6a85;
    }

    .checkout-card {
        background: white;
        border-radius: 16px;
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.03);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .card-header-mat {
        padding: 24px;
        border-bottom: 1px solid #ebf1f6;
    }

    .card-title-mat {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2a3547;
        margin-bottom: 0;
    }

    .card-body-mat {
        padding: 24px;
    }

    /* Custom Radio Cards */
    .form-check-card {
        position: relative;
    }

    .form-check-input-hidden {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .custom-radio-label {
        display: block;
        background: white;
        border: 2px solid #ebf1f6;
        border-radius: 12px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        height: 100%;
    }

    .custom-radio-label:hover {
        border-color: #dbe4f7;
    }

    .form-check-input-hidden:checked+.custom-radio-label {
        border-color: #5d87ff;
        background-color: #ecf2ff;
    }

    .form-check-input-hidden:checked+.custom-radio-label .radio-icon {
        color: #5d87ff;
    }

    .form-check-input-hidden:checked+.custom-radio-label .check-indicator {
        display: block;
    }

    .radio-icon {
        font-size: 2rem;
        color: #5a6a85;
        margin-bottom: 12px;
        transition: color 0.2s;
    }

    .check-indicator {
        position: absolute;
        top: 15px;
        right: 15px;
        color: #5d87ff;
        font-size: 1.2rem;
        display: none;
    }

    .section-title {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #2a3547;
        margin-bottom: 16px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 0.95rem;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px dashed #dfe5ef;
        font-weight: 700;
        font-size: 1.2rem;
        color: #2a3547;
    }

    .order-product-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px dashed #ebf1f6;
    }

    .order-product-item:last-child {
        border-bottom: none;
    }

    .btn-mat-primary {
        background-color: #5d87ff;
        border-color: #5d87ff;
        color: white;
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 600;
        width: 100%;
        transition: all 0.2s;
    }

    .btn-mat-primary:hover {
        background-color: #4570ea;
        border-color: #4570ea;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(93, 135, 255, 0.2);
    }
</style>

<div class="container py-4">
    <!-- Header -->
    <div class="mb-4">
        <h4 class="fw-bold text-dark mb-1">Finalizar Compra</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small text-muted">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('carrito') ?>" class="text-decoration-none text-muted">Carrito</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
    </div>

    <form action="<?= base_url('checkout/procesar') ?>" method="POST">
        <div class="row g-4">
            <!-- Left Column: Forms -->
            <div class="col-lg-8">

                <!-- Shipping Method -->
                <div class="checkout-card">
                    <div class="card-header-mat">
                        <h5 class="card-title-mat"><i class="bi bi-truck me-2 text-primary"></i>Tipo de Entrega</h5>
                    </div>
                    <div class="card-body-mat">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check-card">
                                    <input class="form-check-input-hidden" type="radio" name="tipo_envio" value="delivery" id="delivery" checked onchange="toggleDireccion(true)">
                                    <label class="custom-radio-label" for="delivery">
                                        <i class="bi bi-check-circle-fill check-indicator"></i>
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <i class="bi bi-truck radio-icon"></i>
                                            <span class="fw-bold text-dark d-block">Delivery</span>
                                            <span class="small text-muted">Entrega a domicilio</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check-card">
                                    <input class="form-check-input-hidden" type="radio" name="tipo_envio" value="pickup" id="pickup" onchange="toggleDireccion(false)">
                                    <label class="custom-radio-label" for="pickup">
                                        <i class="bi bi-check-circle-fill check-indicator"></i>
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <i class="bi bi-shop radio-icon"></i>
                                            <span class="fw-bold text-dark d-block">Recojo en Tienda</span>
                                            <span class="small text-muted">Retira gratis en local</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="checkout-card" id="seccion-direccion">
                    <div class="card-header-mat">
                        <h5 class="card-title-mat"><i class="bi bi-geo-alt me-2 text-primary"></i>Dirección de Entrega</h5>
                    </div>
                    <div class="card-body-mat">
                        <?php if (!empty($direcciones)): ?>
                            <div class="d-flex flex-column gap-2">
                                <?php foreach ($direcciones as $dir): ?>
                                    <label class="border rounded-3 p-3 d-flex align-items-center cursor-pointer hover-bg-light transition-base">
                                        <input class="form-check-input me-3" type="radio" name="direccion_id" value="<?= $dir['id'] ?>" <?= $dir['es_principal'] ? 'checked' : '' ?>>
                                        <div>
                                            <div class="fw-bold text-dark">
                                                <?= $dir['alias'] ?: 'Dirección' ?>
                                                <?php if ($dir['es_principal']): ?>
                                                    <span class="badge bg-primary rounded-pill ms-2 text-uppercase" style="font-size: 0.65rem;">Principal</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="small text-muted"><?= $dir['direccion'] ?></div>
                                        </div>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning border-0 bg-warning-subtle text-warning-emphasis mb-0">
                                <i class="bi bi-exclamation-triangle me-2"></i>No tienes direcciones guardadas.
                                <a href="#" class="fw-bold text-warning-emphasis text-decoration-underline">Agregar nueva dirección</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="checkout-card">
                    <div class="card-header-mat">
                        <h5 class="card-title-mat"><i class="bi bi-credit-card me-2 text-primary"></i>Método de Pago</h5>
                    </div>
                    <div class="card-body-mat">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-check-card">
                                    <input class="form-check-input-hidden" type="radio" name="metodo_pago" value="efectivo" id="pagoEfectivo" checked>
                                    <label class="custom-radio-label" for="pagoEfectivo">
                                        <i class="bi bi-check-circle-fill check-indicator"></i>
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <i class="bi bi-cash-coin radio-icon"></i>
                                            <span class="fw-bold text-dark d-block">Efectivo</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check-card">
                                    <input class="form-check-input-hidden" type="radio" name="metodo_pago" value="yape" id="pagoYape">
                                    <label class="custom-radio-label" for="pagoYape">
                                        <i class="bi bi-check-circle-fill check-indicator"></i>
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <i class="bi bi-qr-code radio-icon"></i>
                                            <span class="fw-bold text-dark d-block">Yape</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check-card">
                                    <input class="form-check-input-hidden" type="radio" name="metodo_pago" value="tarjeta" id="pagoTarjeta">
                                    <label class="custom-radio-label" for="pagoTarjeta">
                                        <i class="bi bi-check-circle-fill check-indicator"></i>
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <i class="bi bi-credit-card-2-front radio-icon"></i>
                                            <span class="fw-bold text-dark d-block">Tarjeta</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="checkout-card">
                    <div class="card-body-mat">
                        <label class="section-title">Notas Adicionales</label>
                        <textarea name="notas" class="form-control" rows="3"
                            style="background-color: #f8f9fa; border-color: #ebf1f6;"
                            placeholder="Instrucciones especiales para la entrega..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column: Summary -->
            <div class="col-lg-4">
                <div class="checkout-card sticky-top" style="top: 20px;">
                    <div class="card-header-mat bg-primary text-white">
                        <h5 class="card-title-mat text-white"><i class="bi bi-receipt me-2"></i>Resumen del Pedido</h5>
                    </div>
                    <div class="card-body-mat">
                        <div class="mb-4">
                            <?php foreach ($items as $item):
                                $precio = $item['precio_oferta'] ?? $item['precio'];
                            ?>
                                <div class="order-product-item">
                                    <div class="d-flex align-items-center flex-grow-1 overflow-hidden">
                                        <div class="bg-light rounded p-2 me-3 flex-shrink-0">
                                            <i class="bi bi-box-seam text-primary"></i>
                                        </div>
                                        <div class="text-truncate">
                                            <div class="text-dark fw-bold text-truncate"><?= character_limiter($item['nombre'], 20) ?></div>
                                            <div class="small text-muted">Cant: <?= $item['cantidad'] ?></div>
                                        </div>
                                    </div>
                                    <div class="fw-bold text-dark ms-2">
                                        Gs. <?= number_format($precio * $item['cantidad'], 0) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="summary-item">
                            <span>Subtotal</span>
                            <span class="fw-bold text-dark">Gs. <?= number_format($subtotal, 0) ?></span>
                        </div>
                        <div class="summary-item" id="costo-envio">
                            <span>Envío</span>
                            <span class="fw-bold text-success" id="monto-envio">Gs. <?= number_format($costo_envio, 0) ?></span>
                        </div>

                        <div class="summary-total">
                            <span>Total</span>
                            <span class="text-primary" id="total-pedido">Gs. <?= number_format($subtotal + $costo_envio, 0) ?></span>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-mat-primary btn-lg shadow-sm">
                                Confirmar Pedido <i class="bi bi-arrow-right ms-2"></i>
                            </button>

                            <p class="text-center small text-muted mt-3 mb-0">
                                <i class="bi bi-shield-lock me-1"></i>Pago 100% Seguro
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleDireccion(mostrar) {
        const seccion = document.getElementById('seccion-direccion');
        const montoEnvio = document.getElementById('monto-envio');
        const totalPedido = document.getElementById('total-pedido');
        const subtotal = <?= $subtotal ?>;
        const costoEnvio = <?= $costo_envio ?>;

        if (mostrar) {
            seccion.style.display = 'block';
            montoEnvio.textContent = 'Gs. ' + Math.round(costoEnvio);
            montoEnvio.classList.remove('text-success'); // Remueve color verde de "Gratis" si aplica
            totalPedido.textContent = 'Gs. ' + Math.round(subtotal + costoEnvio);
        } else {
            seccion.style.display = 'none';
            montoEnvio.textContent = 'Gratis';
            montoEnvio.classList.add('text-success'); // Añade color verde
            totalPedido.textContent = 'Gs. ' + Math.round(subtotal);
        }
    }
</script>
<?= $this->endSection() ?>