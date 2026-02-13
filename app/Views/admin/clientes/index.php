<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Clientes</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-muted" href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Clientes</li>
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <i class="ti ti-users text-primary" style="font-size: 5rem; opacity: 0.1;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="card-title fw-semibold mb-0 lh-sm">Listado de Clientes</h5>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive rounded-2 mb-4">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Cliente</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Contacto</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Pedidos</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Total Gastado</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Registro</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Acciones</h6>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cli): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php
                                    $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info'];
                                    $color = $colors[$cli['id'] % count($colors)];
                                    ?>
                                    <div class="rounded-circle bg-light-<?= $color ?> text-<?= $color ?> d-flex align-items-center justify-content-center me-3"
                                        style="width: 40px; height: 40px; font-weight: 600;">
                                        <?= strtoupper(substr($cli['nombre'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1"><?= $cli['nombre'] ?></h6>
                                        <span class="fs-2 text-muted">ID: #<?= $cli['id'] ?></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fs-2 text-dark fw-semibold"><i class="ti ti-mail fs-2 me-1"></i><?= $cli['email'] ?></span>
                                    <span class="fs-2 text-muted"><i class="ti ti-phone fs-2 me-1"></i><?= $cli['telefono'] ?? 'N/A' ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light-info text-info rounded-3 fw-semibold">
                                    <?= $cli['total_pedidos'] ?> Pedidos
                                </span>
                            </td>
                            <td>
                                <h6 class="fw-semibold mb-0 text-dark">Gs. <?= number_format($cli['total_gastado'] ?? 0, 0) ?></h6>
                            </td>
                            <td>
                                <span class="fs-2 text-muted"><?= date('d/m/Y', strtotime($cli['created_at'])) ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/clientes/ver/' . $cli['id']) ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2" title="Ver Perfil">
                                    <i class="ti ti-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>