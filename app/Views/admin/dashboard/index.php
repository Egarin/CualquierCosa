<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <!-- Sales Overview -->
    <div class="col-lg-8 d-flex align-items-stretch">
        <div class="card w-100 shadow-none border">
            <div class="card-body p-4">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Resumen de Ventas</h5>
                        <p class="card-subtitle mb-0">Rendimiento de las últimas transacciones</p>
                    </div>
                    <div>
                        <select class="form-select border-0 bg-light-primary text-primary fw-semibold">
                            <option value="7">Últimos 7 días</option>
                            <option value="30">Últimos 30 días</option>
                        </select>
                    </div>
                </div>
                <div id="chart-ventas" class="mx-n3"></div>
            </div>
        </div>
    </div>

    <!-- Right Side Stats -->
    <div class="col-lg-4">
        <div class="row">
            <!-- Today's Sales -->
            <div class="col-lg-12">
                <div class="card border shadow-none">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="card-title mb-0 fw-semibold">Ventas de Hoy</h5>
                            <div class="p-2 bg-light-primary rounded-2 text-primary">
                                <i class="ti ti-currency-dollar fs-6"></i>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h3 class="fw-bold mb-2"><?= formato_moneda($stats_hoy['total_ventas']) ?></h3>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-light-success text-success d-flex align-items-center gap-1">
                                        <i class="ti ti-arrow-up-right fs-3"></i>
                                    </span>
                                    <p class="text-dark mb-0 fw-semibold fs-3"><?= $stats_hoy['total_pedidos'] ?> pedidos hoy</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customers Count -->
            <div class="col-lg-12">
                <div class="card border shadow-none">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h5 class="card-title mb-4 fw-semibold">Clientes</h5>
                                <h3 class="fw-bold mb-1"><?= number_format($total_clientes) ?></h3>
                                <p class="text-muted mb-0 fs-2">Registrados en total</p>
                            </div>
                            <div class="col-4">
                                <div class="d-flex justify-content-end">
                                    <div class="p-3 bg-light-info text-info rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="ti ti-users fs-7"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Sales Short -->
            <div class="col-lg-12">
                <div class="card border shadow-none bg-light-primary border-0">
                    <div class="card-body p-4">
                        <p class="text-primary mb-1 fw-semibold">Ventas del Mes</p>
                        <h4 class="fw-bold text-primary mb-0"><?= formato_moneda($stats_mes['total_ventas']) ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Orders Table -->
    <div class="col-lg-8 d-flex align-items-stretch">
        <div class="card w-100 border shadow-none">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title fw-semibold mb-0">Pedidos Recientes</h5>
                    <a href="<?= base_url('admin/pedidos') ?>" class="btn btn-sm btn-outline-primary">Ver todos</a>
                </div>
                <div class="table-responsive">
                    <table class="table customize-table mb-0 align-middle">
                        <thead class="text-dark fs-3">
                            <tr>
                                <th>
                                    <h6 class="fs-3 fw-semibold mb-0">Código</h6>
                                </th>
                                <th>
                                    <h6 class="fs-3 fw-semibold mb-0">Cliente</h6>
                                </th>
                                <th>
                                    <h6 class="fs-3 fw-semibold mb-0">Monto</h6>
                                </th>
                                <th>
                                    <h6 class="fs-3 fw-semibold mb-0">Estado</h6>
                                </th>
                                <th>
                                    <h6 class="fs-3 fw-semibold mb-0">Acción</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($pedidos_recientes, 0, 5) as $pedido): ?>
                                <tr>
                                    <td><span class="badge bg-light-primary text-primary fw-semibold">#<?= $pedido['codigo'] ?></span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="ms-0">
                                                <h6 class="fw-semibold mb-1 fs-3"><?= $pedido['cliente_nombre'] ?></h6>
                                                <span class="text-muted fs-2"><?= $pedido['cliente_email'] ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="fw-semibold mb-0 fs-3"><?= formato_moneda($pedido['total']) ?></h6>
                                    </td>
                                    <td>
                                        <?php
                                        $statusClass = 'bg-light-warning text-warning';
                                        if ($pedido['estado'] == 'completado') $statusClass = 'bg-light-success text-success';
                                        if ($pedido['estado'] == 'cancelado') $statusClass = 'bg-light-danger text-danger';
                                        ?>
                                        <span class="badge <?= $statusClass ?> rounded-3 fw-semibold fs-2">
                                            <?= ucfirst($pedido['estado']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/pedidos/ver/' . $pedido['id']) ?>" class="btn btn-sm btn-light-primary text-primary">
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

    <!-- Low Stock Timeline -->
    <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100 border shadow-none">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">Stock Crítico</h5>
                <div class="position-relative">
                    <ul class="timeline-widget mb-0 position-relative mb-n5">
                        <?php foreach ($productos_bajo_stock as $prod): ?>
                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                <div class="timeline-time text-muted flex-shrink-0 text-end fs-2"><?= $prod['stock'] ?>/<?= $prod['stock_minimo'] ?></div>
                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                    <span class="timeline-badge border-2 border border-danger flex-shrink-0 my-8"></span>
                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                </div>
                                <div class="timeline-desc fs-3 text-dark mt-n1">
                                    <span class="fw-semibold"><?= $prod['nombre'] ?></span>
                                    <p class="text-muted fs-2">Reabastecimiento urgente</p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                        <?php if (empty($productos_bajo_stock)): ?>
                            <div class="text-center py-4">
                                <i class="ti ti-circle-check text-success fs-8 mb-2"></i>
                                <p class="mb-0">Todo el stock está al día</p>
                            </div>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Gráfico de ventas optimizado
        var options = {
            chart: {
                id: "ventas-chart",
                type: "area",
                height: 300,
                fontFamily: "Plus Jakarta Sans, sans-serif",
                foreColor: "#adb5bd",
                toolbar: {
                    show: false
                },
                sparkline: {
                    enabled: false
                },
            },
            colors: ["#5D87FF"],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: "smooth",
                width: 3,
            },
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 0,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0,
                    stops: [20, 180],
                },
            },
            grid: {
                borderColor: "rgba(0,0,0,0.05)",
                strokeDashArray: 3,
                xaxis: {
                    lines: {
                        show: false
                    }
                },
            },
            series: [{
                name: "Ventas (Gs.)",
                data: [<?= implode(',', array_column($ventas_diarias, 'total')) ?>],
            }],
            xaxis: {
                type: "category",
                categories: [<?= implode(',', array_map(function ($v) {
                                    return "'" . date('d/m', strtotime($v['fecha'])) . "'";
                                }, $ventas_diarias)) ?>],
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return val >= 1000 ? (val / 1000).toFixed(1) + 'k' : val;
                    }
                }
            },
            tooltip: {
                theme: "dark",
                x: {
                    show: true
                },
                y: {
                    formatter: function(val) {
                        return "Gs. " + Number(val).toLocaleString('es-PY').replace(/,/g, '.');
                    }
                }
            },
        };

        var chart = new ApexCharts(document.querySelector("#chart-ventas"), options);
        chart.render();
    });
</script>
<?= $this->endSection() ?>