<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title fw-semibold mb-0">Gestión de Pedidos</h5>
            <div class="btn-group">
                <a href="?estado=" class="btn btn-outline-primary <?= !$estado_actual ? 'active' : '' ?>">Todos</a>
                <a href="?estado=pendiente" class="btn btn-outline-warning <?= $estado_actual == 'pendiente' ? 'active' : '' ?>">Pendientes</a>
                <a href="?estado=preparando" class="btn btn-outline-info <?= $estado_actual == 'preparando' ? 'active' : '' ?>">En Preparación</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Tipo Envío</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $ped): ?>
                        <tr>
                            <td><span class="fw-bold">#<?= $ped['codigo'] ?></span></td>
                            <td>
                                <div><?= $ped['cliente_nombre'] ?></div>
                                <small class="text-muted"><?= $ped['cliente_email'] ?></small>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($ped['created_at'])) ?></td>
                            <td class="fw-bold">Gs. <?= number_format($ped['total'], 0) ?></td>
                            <td>
                                <span class="badge bg-<?= $ped['tipo_envio'] == 'delivery' ? 'primary' : 'secondary' ?>">
                                    <?= ucfirst($ped['tipo_envio']) ?>
                                </span>
                            </td>
                            <td>
                                <select class="form-select form-select-sm estado-select"
                                    style="width: 130px;"
                                    data-pedido-id="<?= $ped['id'] ?>"
                                    onchange="cambiarEstado(this)">
                                    <?php
                                    $estados = ['pendiente', 'confirmado', 'preparando', 'listo', 'en_camino', 'entregado', 'cancelado'];
                                    foreach ($estados as $est):
                                    ?>
                                        <option value="<?= $est ?>" <?= $ped['estado'] == $est ? 'selected' : '' ?>>
                                            <?= ucfirst($est) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/pedidos/ver/' . $ped['id']) ?>" class="btn btn-sm btn-primary">
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

<script>
    function cambiarEstado(select) {
        const pedidoId = select.dataset.pedidoId;
        const nuevoEstado = select.value;

        fetch('<?= base_url('admin/pedidos/cambiar-estado') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `pedido_id=${pedidoId}&estado=${nuevoEstado}`
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    // Mostrar toast de éxito
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Estado actualizado',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
    }
</script>
<?= $this->endSection() ?>