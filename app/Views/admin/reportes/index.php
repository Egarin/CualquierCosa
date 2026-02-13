<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<style>
    .report-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    .stat-card {
        border-radius: 12px;
        overflow: hidden;
        border: none;
        color: white;
        position: relative;
    }

    .stat-card .card-body {
        position: relative;
        z-index: 2;
    }

    .stat-icon {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 8rem;
        opacity: 0.2;
        transform: rotate(-15deg);
        z-index: 1;
    }

    .bg-gradient-primary {
        background: linear-gradient(45deg, #5d87ff, #4570ea);
    }

    .bg-gradient-success {
        background: linear-gradient(45deg, #13deb9, #0bb291);
    }

    .bg-gradient-info {
        background: linear-gradient(45deg, #539bff, #2a7be4);
    }

    .report-icon-circle {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }
</style>

<div class="row mb-5">
    <div class="col-12">
        <h4 class="fw-bold mb-0">Panel de Reportes</h4>
        <p class="text-muted">Resumen general y análisis detallado</p>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card stat-card bg-gradient-primary h-100 shadow-sm">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div>
                    <h6 class="text-white opacity-75 mb-1 text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.8rem;">Total Pedidos</h6>
                    <h2 class="display-6 fw-bold mb-0 text-white"><?= $stats['total_pedidos'] ?></h2>
                </div>
                <div class="mt-3">
                    <span class="badge bg-white bg-opacity-25 rounded-pill fw-normal px-3">Histórico</span>
                </div>
                <i class="ti ti-shopping-cart stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card bg-gradient-success h-100 shadow-sm">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div>
                    <h6 class="text-white opacity-75 mb-1 text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.8rem;">Total Ventas</h6>
                    <h2 class="display-6 fw-bold mb-0 text-white">Gs. <?= number_format($stats['total_ventas'], 0) ?></h2>
                </div>
                <div class="mt-3">
                    <span class="badge bg-white bg-opacity-25 rounded-pill fw-normal px-3">Ingresos Totales</span>
                </div>
                <i class="ti ti-currency-dollar stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card bg-gradient-info h-100 shadow-sm">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div>
                    <h6 class="text-white opacity-75 mb-1 text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.8rem;">Ticket Promedio</h6>
                    <h2 class="display-6 fw-bold mb-0 text-white">
                        Gs. <?= $stats['total_pedidos'] > 0 ? number_format($stats['total_ventas'] / $stats['total_pedidos'], 0) : '0' ?>
                    </h2>
                </div>
                <div class="mt-3">
                    <span class="badge bg-white bg-opacity-25 rounded-pill fw-normal px-3">Promedio por pedido</span>
                </div>
                <i class="ti ti-receipt stat-icon"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card report-card h-100">
            <div class="card-body p-5 text-center d-flex flex-column align-items-center">
                <div class="report-icon-circle bg-primary bg-opacity-10 text-primary mb-4">
                    <i class="ti ti-chart-line fs-8"></i>
                </div>
                <h4 class="fw-bold mb-2">Reporte de Ventas</h4>
                <p class="text-muted mb-4 px-lg-5">Analiza el rendimiento de tus ventas por día, filtra por fechas y descarga reportes detallados.</p>
                <a href="<?= base_url('admin/reportes/ventas') ?>" class="btn btn-primary rounded-pill px-5 py-2 mt-auto">
                    Ver Reporte de Ventas <i class="ti ti-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card report-card h-100">
            <div class="card-body p-5 text-center d-flex flex-column align-items-center">
                <div class="report-icon-circle bg-success bg-opacity-10 text-success mb-4">
                    <i class="ti ti-package fs-8"></i>
                </div>
                <h4 class="fw-bold mb-2">Productos Más Vendidos</h4>
                <p class="text-muted mb-4 px-lg-5">Descubre cuáles son tus productos estrella y gestiona mejor tu inventario.</p>
                <a href="<?= base_url('admin/reportes/productos') ?>" class="btn btn-success rounded-pill px-5 py-2 mt-auto">
                    Ver Top Productos <i class="ti ti-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>