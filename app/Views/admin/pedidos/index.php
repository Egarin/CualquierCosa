<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Pedidos</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-muted" href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Pedidos</li>
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <i class="ti ti-shopping-cart text-primary" style="font-size: 5rem; opacity: 0.1;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="card-title fw-semibold mb-0 lh-sm">Listado de Pedidos</h5>
        <div class="btn-group shadow-sm" role="group">
            <a href="?estado=" class="btn btn-sm <?= !$estado_actual ? 'btn-primary' : 'btn-outline-primary' ?>">Todos</a>
            <a href="?estado=pendiente" class="btn btn-sm <?= $estado_actual == 'pendiente' ? 'btn-primary' : 'btn-outline-primary' ?>">Pendientes</a>
            <a href="?estado=preparando" class="btn btn-sm <?= $estado_actual == 'preparando' ? 'btn-primary' : 'btn-outline-primary' ?>">En Preparación</a>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive rounded-2 mb-4">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Pedido</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Cliente</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Total</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Envío</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Estado</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Acciones</h6>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $estadoColors = [
                        'pendiente' => 'warning',
                        'confirmado' => 'info',
                        'preparando' => 'primary',
                        'listo' => 'success',
                        'en_camino' => 'info',
                        'entregado' => 'success',
                        'cancelado' => 'danger'
                    ];

                    $estadosLabel = [
                        'pendiente' => 'Pendiente',
                        'confirmado' => 'Confirmado',
                        'preparando' => 'Preparando',
                        'listo' => 'Listo',
                        'en_camino' => 'En Camino',
                        'entregado' => 'Entregado',
                        'cancelado' => 'Cancelado'
                    ];
                    ?>
                    <?php if (empty($pedidos)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="ti ti-shopping-cart-off fs-8 text-muted d-block mb-3"></i>
                                <span class="text-muted fw-semibold">No se encontraron pedidos con este filtro.</span>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($pedidos as $ped): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="ti ti-receipt-2 fs-6 text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1">#<?= $ped['codigo'] ?></h6>
                                        <span class="fs-2 text-muted"><?= date('d/m/Y H:i', strtotime($ped['created_at'])) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <h6 class="fw-semibold mb-0"><?= $ped['cliente_nombre'] ?></h6>
                                    <span class="fs-2 text-muted"><?= $ped['cliente_email'] ?></span>
                                </div>
                            </td>
                            <td>
                                <h6 class="fw-semibold mb-0 text-dark">Gs. <?= number_format($ped['total'], 0) ?></h6>
                            </td>
                            <td>
                                <?php if ($ped['tipo_envio'] == 'delivery'): ?>
                                    <span class="badge bg-light-primary text-primary rounded-3 fw-semibold">
                                        <i class="ti ti-truck me-1"></i> Delivery
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-light-secondary text-secondary rounded-3 fw-semibold">
                                        <i class="ti ti-building-store me-1"></i> Recojo
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <select class="form-select form-select-sm border-0 fw-semibold text-<?= $estadoColors[$ped['estado']] ?? 'secondary' ?> bg-light-<?= $estadoColors[$ped['estado']] ?? 'secondary' ?>"
                                    style="width: 140px; cursor: pointer;"
                                    data-pedido-id="<?= $ped['id'] ?>"
                                    onchange="cambiarEstado(this)">
                                    <?php foreach ($estadosLabel as $clave => $label): ?>
                                        <option value="<?= $clave ?>" <?= $ped['estado'] == $clave ? 'selected' : '' ?> class="text-dark bg-white">
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <div class="action-btn">
                                    <a href="<?= base_url('admin/pedidos/ver/' . $ped['id']) ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2" title="Ver Detalle">
                                        <i class="ti ti-eye"></i> Ver
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function cambiarEstado(select) {
        const pedidoId = select.dataset.pedidoId;
        const nuevoEstado = select.value;
        const previousState = select.getAttribute('data-prev') || select.value; // Store previous state

        // Confirmation dialog could be added here if critical

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
                    // Update style based on selection
                    const colors = {
                        'pendiente': 'warning',
                        'confirmado': 'info',
                        'preparando': 'primary',
                        'listo': 'success',
                        'en_camino': 'info',
                        'entregado': 'success',
                        'cancelado': 'danger'
                    };

                    // Remove all possible color classes
                    Object.values(colors).forEach(c => {
                        select.classList.remove(`text-${c}`, `bg-light-${c}`);
                    });

                    // Add new color class
                    const newColor = colors[nuevoEstado] || 'secondary';
                    select.classList.add(`text-${newColor}`, `bg-light-${newColor}`);

                    // Success toast
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Estado actualizado correctamente',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire('Error', 'No se pudo actualizar el estado', 'error');
                    select.value = previousState; // Revert
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Ocurrió un error en la solicitud', 'error');
                select.value = previousState; // Revert
            });
    }

    // Save initial state for revert
    document.querySelectorAll('select').forEach(s => s.setAttribute('data-prev', s.value));
</script>
<?= $this->endSection() ?>