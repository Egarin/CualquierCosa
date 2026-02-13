<?= $this->extend('tienda/templates/header') ?>

<?= $this->section('content') ?>
<style>
    body {
        background-color: #f5f8fa;
    }

    .sidebar-card {
        background: white;
        border-radius: 16px;
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.03);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .table-custom th {
        background-color: #f8f9fa;
        color: #5a6a85;
        font-weight: 600;
        border-bottom: 1px solid #dfe5ef;
        padding: 16px;
    }

    .table-custom td {
        vertical-align: middle;
        padding: 16px;
        color: #2a3547;
        border-bottom: 1px solid #f1f5f9;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-badge.entregado {
        background-color: #e6fffa;
        color: #13deb9;
    }

    .status-badge.pendiente {
        background-color: #fff8ec;
        color: #ffae1f;
    }

    .status-badge.cancelado {
        background-color: #fdede8;
        color: #fa896b;
    }

    .status-badge.procesando {
        background-color: #ebf3fe;
        color: #5d87ff;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f6f9fc;
        color: #5d87ff;
        transition: all 0.2s;
    }

    .btn-action:hover {
        background-color: #5d87ff;
        color: white;
    }
</style>

<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Mis Pedidos</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small text-muted">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Mis Pedidos</li>
                </ol>
            </nav>
        </div>
        <a href="<?= base_url('catalogo') ?>" class="btn btn-outline-primary rounded-pill">
            <i class="bi bi-cart-plus me-2"></i>Seguir comprando
        </a>
    </div>

    <?php if (empty($pedidos)): ?>
        <div class="sidebar-card text-center py-5">
            <div class="py-4">
                <div class="mb-4">
                    <span class="bg-light rounded-circle p-4 d-inline-block">
                        <i class="bi bi-bag-x display-4 text-muted"></i>
                    </span>
                </div>
                <h4 class="text-dark fw-bold">No tienes pedidos aún</h4>
                <p class="text-muted mb-4">Cuando realices una compra, aparecerá aquí.</p>
                <a href="<?= base_url('catalogo') ?>" class="btn btn-primary rounded-pill px-4 py-2">
                    Ir al Catálogo
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="sidebar-card p-0">
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Nº Pedido</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $ped): ?>
                            <tr>
                                <td>
                                    <span class="fw-bold text-dark">#<?= $ped['codigo'] ?></span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium"><?= date('d/m/Y', strtotime($ped['created_at'])) ?></span>
                                        <small class="text-muted"><?= date('H:i', strtotime($ped['created_at'])) ?></small>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    $estadoClass = match ($ped['estado']) {
                                        'entregado' => 'entregado',
                                        'cancelado' => 'cancelado',
                                        'pendiente' => 'pendiente',
                                        default => 'procesando'
                                    };
                                    ?>
                                    <span class="status-badge <?= $estadoClass ?>">
                                        <?= ucfirst($ped['estado']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark"><?= formato_moneda($ped['total']) ?></span>
                                </td>
                                <td>
                                    <a href="<?= base_url('mis-pedidos/ver/' . $ped['codigo']) ?>" class="btn-action" title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>