<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Clientes Registrados</h5>

        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle" id="tablaClientes">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Total Pedidos</th>
                        <th>Total Gastado</th>
                        <th>Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cli): ?>
                        <tr>
                            <td><?= $cli['id'] ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center"
                                        style="width:35px;height:35px;font-size:14px;">
                                        <?= strtoupper(substr($cli['nombre'], 0, 1)) ?>
                                    </div>
                                    <span class="ms-2"><?= $cli['nombre'] ?></span>
                                </div>
                            </td>
                            <td><?= $cli['email'] ?></td>
                            <td><?= $cli['telefono'] ?></td>
                            <td>
                                <span class="badge bg-info"><?= $cli['total_pedidos'] ?></span>
                            </td>
                            <td>S/ <?= number_format($cli['total_gastado'] ?? 0, 2) ?></td>
                            <td><?= date('d/m/Y', strtotime($cli['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('admin/clientes/ver/' . $cli['id']) ?>" class="btn btn-sm btn-primary">
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
<?= $this->endSection() ?>