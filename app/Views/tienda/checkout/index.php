<?= $this->extend('tienda/templates/header') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <h2 class="mb-4"><i class="bi bi-credit-card me-2"></i>Finalizar Compra</h2>

    <form action="<?= base_url('checkout/procesar') ?>" method="POST">
        <div class="row">
            <div class="col-lg-8">
                <!-- Tipo de Envío -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Tipo de Entrega</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check card p-3">
                                    <input class="form-check-input" type="radio" name="tipo_envio" value="delivery" id="delivery" checked onchange="toggleDireccion(true)">
                                    <label class="form-check-label w-100" for="delivery">
                                        <i class="bi bi-truck me-2"></i><strong>Delivery</strong>
                                        <p class="mb-0 text-muted small">Entrega en 24-48 horas</p>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check card p-3">
                                    <input class="form-check-input" type="radio" name="tipo_envio" value="pickup" id="pickup" onchange="toggleDireccion(false)">
                                    <label class="form-check-label w-100" for="pickup">
                                        <i class="bi bi-shop me-2"></i><strong>Recojo en Tienda</strong>
                                        <p class="mb-0 text-muted small">Retira tu pedido gratis</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dirección -->
                <div class="card border-0 shadow-sm mb-4" id="seccion-direccion">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Dirección de Entrega</h5>
                        <?php if (!empty($direcciones)): ?>
                            <?php foreach ($direcciones as $dir): ?>
                            <div class="form-check card p-3 mb-2">
                                <input class="form-check-input" type="radio" name="direccion_id" value="<?= $dir['id'] ?>" id="dir<?= $dir['id'] ?>" <?= $dir['es_principal'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="dir<?= $dir['id'] ?>">
                                    <strong><?= $dir['alias'] ?: 'Dirección' ?></strong>
                                    <?php if ($dir['es_principal']): ?><span class="badge bg-primary ms-2">Principal</span><?php endif; ?>
                                    <p class="mb-0 text-muted"><?= $dir['direccion'] ?></p>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                No tienes direcciones guardadas. <a href="#">Agregar dirección</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Método de Pago -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Método de Pago</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-check card p-3 text-center">
                                    <input class="form-check-input" type="radio" name="metodo_pago" value="efectivo" id="pagoEfectivo" checked>
                                    <label class="form-check-label" for="pagoEfectivo">
                                        <i class="bi bi-cash-coin fs-2 d-block mb-2"></i>Efectivo
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check card p-3 text-center">
                                    <input class="form-check-input" type="radio" name="metodo_pago" value="yape" id="pagoYape">
                                    <label class="form-check-label" for="pagoYape">
                                        <i class="bi bi-phone fs-2 d-block mb-2"></i>Yape
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check card p-3 text-center">
                                    <input class="form-check-input" type="radio" name="metodo_pago" value="tarjeta" id="pagoTarjeta">
                                    <label class="form-check-label" for="pagoTarjeta">
                                        <i class="bi bi-credit-card fs-2 d-block mb-2"></i>Tarjeta
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notas -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Notas Adicionales</h5>
                        <textarea name="notas" class="form-control" rows="3" placeholder="Instrucciones especiales para la entrega..."></textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Resumen</h5>
                        
                        <?php foreach ($items as $item): 
                            $precio = $item['precio_oferta'] ?? $item['precio'];
                        ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted"><?= character_limiter($item['nombre'], 20) ?> x<?= $item['cantidad'] ?></span>
                            <span>S/ <?= number_format($precio * $item['cantidad'], 2) ?></span>
                        </div>
                        <?php endforeach; ?>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>S/ <?= number_format($subtotal, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2" id="costo-envio">
                            <span>Envío</span>
                            <span id="monto-envio">S/ <?= number_format($costo_envio, 2) ?></span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5">Total</span>
                            <span class="h5 text-primary" id="total-pedido">S/ <?= number_format($subtotal + $costo_envio, 2) ?></span>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg">
                            Confirmar Pedido<i class="bi bi-arrow-right ms-2"></i>
                        </button>
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
        montoEnvio.textContent = 'S/ ' + costoEnvio.toFixed(2);
        totalPedido.textContent = 'S/ ' + (subtotal + costoEnvio).toFixed(2);
    } else {
        seccion.style.display = 'none';
        montoEnvio.textContent = 'Gratis';
        totalPedido.textContent = 'S/ ' + subtotal.toFixed(2);
    }
}
</script>
<?= $this->endSection() ?>