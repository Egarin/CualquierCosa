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
                        <div id="contenedor-direcciones">
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
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mt-3">
                            <a href="javascript:void(0)" onclick="mostrarModalDireccion()" class="text-primary fw-bold text-decoration-none small">
                                <i class="bi bi-plus-circle me-1"></i>Agregar nueva dirección
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="checkout-card">
                    <div class="card-header-mat">
                        <h5 class="card-title-mat"><i class="bi bi-credit-card me-2 text-primary"></i>Método de Pago</h5>
                    </div>
                    <div class="card-body-mat">
                        <div class="row g-3">
                            <div class="col-md-3">
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
                            <div class="col-md-3">
                                <div class="form-check-card">
                                    <input class="form-check-input-hidden" type="radio" name="metodo_pago" value="qr" id="pagoQR">
                                    <label class="custom-radio-label" for="pagoQR">
                                        <i class="bi bi-check-circle-fill check-indicator"></i>
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <i class="bi bi-qr-code radio-icon"></i>
                                            <span class="fw-bold text-dark d-block">QR</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check-card">
                                    <input class="form-check-input-hidden" type="radio" name="metodo_pago" value="transferencia" id="pagoTransferencia" onclick="mostrarModalTransferencia()">
                                    <label class="custom-radio-label" for="pagoTransferencia">
                                        <i class="bi bi-check-circle-fill check-indicator"></i>
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <i class="bi bi-bank radio-icon"></i>
                                            <span class="fw-bold text-dark d-block">Transferencia</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
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
                                        <?= formato_moneda($precio * $item['cantidad']) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="summary-item">
                            <span>Subtotal</span>
                            <span class="fw-bold text-dark"><?= formato_moneda($subtotal) ?></span>
                        </div>
                        <div class="summary-item" id="costo-envio">
                            <span>Envío</span>
                            <span class="fw-bold text-success" id="monto-envio"><?= formato_moneda($costo_envio) ?></span>
                        </div>

                        <div class="summary-total">
                            <span>Total</span>
                            <span class="text-primary" id="total-pedido"><?= formato_moneda($subtotal + $costo_envio) ?></span>
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

<!-- Modal Transferencia Bancaria -->
<div class="modal fade" id="modalTransferencia" tabindex="-1" aria-labelledby="modalTransferenciaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 16px;">
            <div class="modal-header border-bottom-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark" id="modalTransferenciaLabel">
                    <i class="bi bi-bank text-primary me-2"></i>Datos para Transferencia
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="bg-light rounded-3 p-3 mb-4">
                    <div class="mb-3">
                        <label class="small text-muted d-block mb-1">Nombre del Banco</label>
                        <div class="fw-bold text-dark">Banco Itaú / Continental</div>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted d-block mb-1">Nombre de la Cuenta</label>
                        <div class="fw-bold text-dark">MiniMarket S.A.</div>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted d-block mb-1">Documento / Alias</label>
                        <div class="fw-bold text-dark">80012345-6 / minimarket.py</div>
                    </div>
                    <div class="mb-0">
                        <label class="small text-muted d-block mb-1">Número de Cuenta</label>
                        <div class="fw-bold text-primary fs-5">123456789</div>
                    </div>
                </div>

                <div class="alert alert-info border-0 mb-0 d-flex align-items-start shadow-none" style="background-color: #ecf2ff; color: #5d87ff;">
                    <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                    <div>
                        Cunado realice la transferencia, por favor envíe el comprobante al número WhatsApp: <strong>09876564534</strong>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pb-4 px-4">
                <button type="button" class="btn btn-primary w-100 py-2 fw-bold" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Dirección -->
<div class="modal fade" id="modalDireccion" tabindex="-1" aria-labelledby="modalDireccionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 16px;">
            <div class="modal-header border-bottom-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark" id="modalDireccionLabel">
                    <i class="bi bi-geo-alt text-primary me-2"></i>Nueva Dirección
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formDireccion">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Alias (Ej: Casa, Oficina)</label>
                        <input type="text" name="alias" class="form-control" placeholder="Nombre para esta dirección" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Dirección Completa</label>
                        <textarea name="direccion" class="form-control" rows="2" placeholder="Calle, número, barrio..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Referencia</label>
                        <textarea name="referencia" class="form-control" rows="1" placeholder="Ej: Frente a la plaza, portón azul..."></textarea>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="es_principal" id="esPrincipal" checked>
                        <label class="form-check-label small" for="esPrincipal">Establecer como dirección principal</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pb-4 px-4">
                <button type="button" class="btn btn-light w-100 py-2 fw-bold me-2" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btnGuardarDireccion" onclick="guardarDireccion()" class="btn btn-primary w-100 py-2 fw-bold">Guardar Dirección</button>
            </div>
        </div>
    </div>
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
            montoEnvio.textContent = 'Gs. ' + Number(costoEnvio).toLocaleString('es-PY').replace(/,/g, '.');
            montoEnvio.classList.remove('text-success'); // Remueve color verde de "Gratis" si aplica
            totalPedido.textContent = 'Gs. ' + Number(subtotal + costoEnvio).toLocaleString('es-PY').replace(/,/g, '.');
        } else {
            seccion.style.display = 'none';
            montoEnvio.textContent = 'Gratis';
            montoEnvio.classList.add('text-success'); // Añade color verde
            totalPedido.textContent = 'Gs. ' + Number(subtotal).toLocaleString('es-PY').replace(/,/g, '.');
        }
    }

    function mostrarModalTransferencia() {
        const modal = new bootstrap.Modal(document.getElementById('modalTransferencia'));
        modal.show();
    }

    function mostrarModalDireccion() {
        const modal = new bootstrap.Modal(document.getElementById('modalDireccion'));
        modal.show();
    }

    function guardarDireccion() {
        const form = document.getElementById('formDireccion');
        const formData = new FormData(form);
        const btn = document.getElementById('btnGuardarDireccion');

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';

        fetch(BASE_URL + 'direcciones/guardar', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Actualizar token CSRF
                if (data.csrf_name && data.csrf_hash) {
                    const meta = document.getElementById('csrf-token');
                    if (meta) {
                        meta.name = data.csrf_name;
                        meta.content = data.csrf_hash;
                    }
                    // También actualizar el campo oculto en el formulario
                    const csrfInput = document.querySelector(`input[name="${data.csrf_name}"]`);
                    if (csrfInput) csrfInput.value = data.csrf_hash;
                }

                if (data.success) {
                    // Actualizar lista de direcciones
                    actualizarListaDirecciones(data.direcciones, data.id);

                    // Cerrar modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalDireccion'));
                    modal.hide();
                    form.reset();

                    // Notificar éxito (si tienes un sistema de toasts)
                    showToast('Dirección guardada correctamente');
                } else {
                    showToast(data.message || 'Error al guardar la dirección', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error de conexión', 'error');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = 'Guardar Dirección';
            });
    }

    function actualizarListaDirecciones(direcciones, nuevoId) {
        const contenedor = document.getElementById('contenedor-direcciones');
        if (!direcciones || direcciones.length === 0) return;

        let html = '<div class="d-flex flex-column gap-2">';
        direcciones.forEach(dir => {
            const checked = dir.id == nuevoId ? 'checked' : '';
            const alias = dir.alias || 'Dirección';
            const badge = dir.es_principal == 1 ? '<span class="badge bg-primary rounded-pill ms-2 text-uppercase" style="font-size: 0.65rem;">Principal</span>' : '';

            html += `
                <label class="border rounded-3 p-3 d-flex align-items-center cursor-pointer hover-bg-light transition-base">
                    <input class="form-check-input me-3" type="radio" name="direccion_id" value="${dir.id}" ${checked}>
                    <div>
                        <div class="fw-bold text-dark">
                            ${alias} ${badge}
                        </div>
                        <div class="small text-muted">${dir.direccion}</div>
                    </div>
                </label>
            `;
        });
        html += '</div>';
        contenedor.innerHTML = html;
    }
</script>
<?= $this->endSection() ?>