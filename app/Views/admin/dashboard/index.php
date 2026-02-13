<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Resumen de Ventas</h5>
                    </div>
                    <div>
                        <select class="form-select">
                            <option value="7">Últimos 7 días</option>
                            <option value="30">Últimos 30 días</option>
                        </select>
                    </div>
                </div>
                <div id="chart-ventas"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-9 fw-semibold">Ventas de Hoy</h5>
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="fw-semibold mb-3">S/ <?= number_format($stats_hoy['total_ventas'], 2) ?></h4>
                                <div class="d-flex align-items-center mb-3">
                                    <span class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-arrow-up-left text-success"></i>
                                    </span>
                                    <p class="text-dark me-1 fs-3 mb-0"><?= $stats_hoy['total_pedidos'] ?> pedidos</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex justify-content-center">
                                    <div id="breakup"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row alig n-items-start">
                            <div class="col-8">
                                <h5 class="card-title mb-9 fw-semibold">Clientes Registrados</h5>
                                <h4 class="fw-semibold mb-3"><?= $total_clientes ?></h4>
                            </div>
                            <div class="col-4">
                                <div class="d-flex justify-content-end">
                                    <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-users fs-6"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">Pedidos Recientes</h5>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Código</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Cliente</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Total</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Estado</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Acción</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($pedidos_recientes, 0, 5) as $pedido): ?>
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">#<?= $pedido['codigo'] ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-1"><?= $pedido['cliente_nombre'] ?></h6>
                                        <span class="fw-normal"><?= $pedido['cliente_email'] ?></span>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 fs-4">S/ <?= number_format($pedido['total'], 2) ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <span class="badge bg-warning rounded-3 fw-semibold"><?= ucfirst($pedido['estado']) ?></span>
                                    </td>
                                    <td class="border-bottom-0">
                                        <a href="<?= base_url('admin/pedidos/ver/' . $pedido['id']) ?>" class="btn btn-sm btn-primary">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h5 class="card-title fw-semibold">Stock Bajo</h5>
                </div>
                <ul class="timeline-widget mb-0 position-relative mb-n5">
                    <?php foreach ($productos_bajo_stock as $prod): ?>
                        <li class="timeline-item d-flex position-relative overflow-hidden">
                            <div class="timeline-time text-dark flex-shrink-0 text-end"><?= $prod['stock'] ?> unid.</div>
                            <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                <span class="timeline-badge border-2 border border-danger flex-shrink-0 my-8"></span>
                                <span class="timeline-badge-border d-block flex-shrink-0"></span>
                            </div>
                            <div class="timeline-desc fs-3 text-dark mt-n1">
                                <?= $prod['nombre'] ?>
                                <span class="text-danger fw-semibold">Stock mínimo: <?= $prod['stock_minimo'] ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Gráfico de ventas
    var options = {
        series: [{
            name: 'Ventas S/',
            data: [<?= implode(',', array_column($ventas_diarias, 'total')) ?>]
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: false,
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: [<?= implode(',', array_map(function ($v) {
                                return "'" . date('d/m', strtotime($v['fecha'])) . "'";
                            }, $ventas_diarias)) ?>],
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart-ventas"), options);
    chart.render();
</script>
<?= $this->endSection() ?>