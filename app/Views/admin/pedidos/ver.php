<?= $this->extend('templates/admin_header') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h4 class="card-title">Pedido #<?= $pedido['codigo'] ?></h4>
                        <p class="text-muted mb-0">
                            <i class="ti ti-calendar me-1"></i>
                            <?= date('d/m/Y H:i', strtotime($pedido['created_at'])) ?>
                        </p>
                    </div>
                    <span class="badge bg-<?=
                                            $pedido['estado'] == 'entregado' ? 'success' : ($pedido['estado'] == 'cancelado' ? 'danger' : 'warning')
                                            ?> fs-6 px-3 py-2">
                        <?= ucfirst($pedido['estado']) ?>
                    </span>
                </div>

                <h6 class="fw-semibold mb-3">Productos</h6>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedido['detalles'] as $det): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= $det['imagen'] ? base_url('uploads/productos/' . $det['imagen']) : base_url('assets/images/no-image.jpg') ?>"
                                                class="rounded" width="40" height="40" style="object-fit: cover;">
                                            <span class="ms-2"><?= $det['producto_nombre'] ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center"><?= $det['cantidad'] ?></td>
                                    <td class="text-end"><?= formato_moneda($det['precio_unitario']) ?></td>
                                    <td class="text-end"><?= formato_moneda($det['subtotal']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-group-divider">
                            <tr>
                                <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                <td class="text-end"><?= formato_moneda($pedido['subtotal']) ?></td>
                            </tr>
                            <?php if ($pedido['costo_envio'] > 0): ?>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Envío:</strong></td>
                                    <td class="text-end"><?= formato_moneda($pedido['costo_envio']) ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="3" class="text-end">
                                    <h5 class="mb-0">Total:</h5>
                                </td>
                                <td class="text-end">
                                    <h5 class="mb-0 text-primary"><?= formato_moneda($pedido['total']) ?></h5>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Información del Cliente</h6>
                <p class="mb-1"><strong><?= $pedido['cliente_nombre'] ?></strong></p>
                <p class="text-muted mb-1"><i class="ti ti-mail me-1"></i><?= $pedido['cliente_email'] ?></p>
                <p class="text-muted"><i class="ti ti-phone me-1"></i><?= $pedido['cliente_telefono'] ?></p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Detalles de Entrega</h6>
                <p class="mb-2">
                    <span class="badge bg-<?= $pedido['tipo_envio'] == 'delivery' ? 'primary' : 'secondary' ?>">
                        <?= ucfirst($pedido['tipo_envio']) ?>
                    </span>
                </p>
                <?php if ($pedido['tipo_envio'] == 'delivery' && $pedido['direccion']): ?>
                    <p class="mb-1"><strong>Dirección:</strong></p>
                    <p class="text-muted"><?= $pedido['direccion'] ?></p>
                    <?php if ($pedido['referencia']): ?>
                        <p class="small text-muted"><strong>Ref:</strong> <?= $pedido['referencia'] ?></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="text-muted">Retiro en tienda</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Método de Pago</h6>
                <p class="mb-0">
                    <i class="ti ti-credit-card me-2"></i>
                    <?= ucfirst($pedido['metodo_pago']) ?>
                </p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>