<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Reporte de Ventas Diarias</h5>
        <div class="mb-4">
            <form action="" method="get" class="d-flex gap-2 align-items-end">
                <div>
                    <label class="form-label">Fecha Inicio</label>
                    <input type="date" name="inicio" class="form-control" value="<?= $fecha_inicio ?>">
                </div>
                <div>
                    <label class="form-label">Fecha Fin</label>
                    <input type="date" name="fin" class="form-control" value="<?= $fecha_fin ?>">
                </div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>Fecha</th>
                        <th>Cantidad Pedidos</th>
                        <th>Total Ventas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ventas)): ?>
                        <tr>
                            <td colspan="3" class="text-center">No hay ventas en este período</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($ventas as $venta): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($venta['fecha'])) ?></td>
                                <td><?= $venta['cantidad'] ?></td>
                                <td>S/ <?= number_format($venta['total'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>