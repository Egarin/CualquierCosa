<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Pedidos</h6>
                        <h2 class="mt-2 mb-0"><?= $stats['total_pedidos'] ?></h2>
                    </div>
                    <i class="ti ti-shopping-cart fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Ventas</h6>
                        <h2 class="mt-2 mb-0">Gs. <?= number_format($stats['total_ventas'], 0) ?></h2>
                    </div>
                    <i class="ti ti-currency-dollar fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Ticket Promedio</h6>
                        <h2 class="mt-2 mb-0">
                            Gs. <?= $stats['total_pedidos'] > 0 ? number_format($stats['total_ventas'] / $stats['total_pedidos'], 0) : '0' ?>
                        </h2>
                    </div>
                    <i class="ti ti-receipt fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="ti ti-chart-line fs-1 text-primary mb-3"></i>
                <h5>Reporte de Ventas</h5>
                <p class="text-muted">Análisis detallado de ventas por período</p>
                <a href="<?= base_url('admin/reportes/ventas') ?>" class="btn btn-primary">Ver Reporte</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="ti ti-package fs-1 text-success mb-3"></i>
                <h5>Productos Más Vendidos</h5>
                <p class="text-muted">Top de productos con mayor rotación</p>
                <a href="<?= base_url('admin/reportes/productos') ?>" class="btn btn-success">Ver Reporte</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>