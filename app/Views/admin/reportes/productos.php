<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Productos Más Vendidos</h5>

        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>Producto</th>
                        <th>Unidades Vendidas</th>
                        <th>Total Ingresos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($productos)): ?>
                        <tr>
                            <td colspan="3" class="text-center">No hay datos disponibles</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($productos as $prod): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= $prod['imagen'] ? base_url('uploads/productos/' . $prod['imagen']) : base_url('assets/images/no-image.jpg') ?>"
                                            class="rounded-circle me-2" width="40" height="40" style="object-fit:cover">
                                        <span><?= $prod['nombre'] ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary rounded-3 fw-semibold">
                                        <?= $prod['total_vendido'] ?> Unidades
                                    </span>
                                </td>
                                <td>S/ <?= number_format($prod['total_ingresos'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>