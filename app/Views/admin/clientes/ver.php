<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                    style="width:80px;height:80px;font-size:36px;">
                    <?= strtoupper(substr($cliente['nombre'], 0, 1)) ?>
                </div>
                <h4><?= $cliente['nombre'] ?></h4>
                <p class="text-muted"><?= $cliente['email'] ?></p>
                <p><i class="ti ti-phone me-2"></i><?= $cliente['telefono'] ?></p>
                <p><i class="ti ti-calendar me-2"></i>Registrado: <?= date('d/m/Y', strtotime($cliente['created_at'])) ?></p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Direcciones</h5>
                <?php foreach ($cliente['direcciones'] as $dir): ?>
                    <div class="border-bottom py-2">
                        <strong><?= $dir['alias'] ?: 'Dirección' ?></strong>
                        <?php if ($dir['es_principal']): ?>
                            <span class="badge bg-success ms-2">Principal</span>
                        <?php endif; ?>
                        <p class="mb-0 text-muted small"><?= $dir['direccion'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Historial de Pedidos</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cliente['pedidos'] as $ped): ?>
                                <tr>
                                    <td>#<?= $ped['codigo'] ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($ped['created_at'])) ?></td>
                                    <td>S/ <?= number_format($ped['total'], 2) ?></td>
                                    <td>
                                        <span class="badge bg-<?=
                                                                $ped['estado'] == 'entregado' ? 'success' : ($ped['estado'] == 'cancelado' ? 'danger' : 'warning')
                                                                ?>">
                                            <?= ucfirst($ped['estado']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/pedidos/ver/' . $ped['id']) ?>" class="btn btn-sm btn-light">
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
</div>
<?= $this->endSection() ?>