<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Categorías</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-muted" href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Categorías</li>
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <i class="ti ti-category text-primary" style="font-size: 5rem; opacity: 0.1;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold mb-0 lh-sm">Listado de Categorías</h5>
            <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalCategoria" onclick="limpiarModal()">
                <i class="ti ti-plus me-2"></i> Nueva Categoría
            </button>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive rounded-2 mb-4">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Nombre</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Icono</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Color</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Orden</h6>
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
                    <?php foreach ($categorias as $cat): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle p-2 d-flex align-items-center justify-content-center me-3"
                                        style="width: 40px; height: 40px; background-color: <?= $cat['color'] ?>20;">
                                        <i class="<?= $cat['icono'] ?> fs-4" style="color: <?= $cat['color'] ?>"></i>
                                    </div>
                                    <h6 class="fw-semibold mb-0 text-dark"><?= $cat['nombre'] ?></h6>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark font-monospace text-start"><i class="<?= $cat['icono'] ?> me-2"></i><?= $cat['icono'] ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="rounded-circle" style="width: 20px; height: 20px; background-color: <?= $cat['color'] ?>;"></span>
                                    <span class="text-muted text-uppercase small"><?= $cat['color'] ?></span>
                                </div>
                            </td>
                            <td>
                                <h6 class="fw-semibold mb-0"><?= $cat['orden'] ?></h6>
                            </td>
                            <td>
                                <span class="badge <?= $cat['activo'] ? 'bg-light-success text-success' : 'bg-light-danger text-danger' ?> rounded-3 fw-semibold">
                                    <?= $cat['activo'] ? 'Activo' : 'Inactivo' ?>
                                </span>
                            </td>
                            <td>
                                <div class="dropdown dropstart">
                                    <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical fs-6"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)"
                                                onclick='editar(<?= htmlspecialchars(json_encode($cat), ENT_QUOTES, 'UTF-8') ?>)'>
                                                <i class="fs-4 ti ti-edit"></i>Editar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-3 text-danger" href="<?= base_url('admin/categorias/eliminar/' . $cat['id']) ?>"
                                                onclick="return confirm('¿Eliminar esta categoría?')">
                                                <i class="fs-4 ti ti-trash"></i>Eliminar
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Categoría -->
<div class="modal fade" id="modalCategoria" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <form id="formCategoria" action="<?= base_url('admin/categorias/guardar') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Nueva Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Icono (Bootstrap Icons)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="ti ti-star"></i></span>
                                <input type="text" name="icono" id="icono" class="form-control" placeholder="bi-tag">
                            </div>
                            <div class="form-text">Ej: bi-cart, bi-tag, bi-heart</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Color</label>
                            <input type="color" name="color" id="color" class="form-control form-control-color w-100" value="#5d87ff" title="Elegir color">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Orden</label>
                        <input type="number" name="orden" id="orden" class="form-control" value="0">
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 pb-4">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function limpiarModal() {
        document.getElementById('formCategoria').action = '<?= base_url('admin/categorias/guardar') ?>';
        document.getElementById('modalTitle').innerText = 'Nueva Categoría';
        document.getElementById('nombre').value = '';
        document.getElementById('descripcion').value = '';
        document.getElementById('icono').value = '';
        document.getElementById('color').value = '#5d87ff';
        document.getElementById('orden').value = '0';
    }

    function editar(cat) {
        document.getElementById('formCategoria').action = '<?= base_url('admin/categorias/actualizar/') ?>' + cat.id;
        document.getElementById('modalTitle').innerText = 'Editar Categoría';
        document.getElementById('nombre').value = cat.nombre;
        document.getElementById('descripcion').value = cat.descripcion;
        document.getElementById('icono').value = cat.icono;
        document.getElementById('color').value = cat.color;
        document.getElementById('orden').value = cat.orden;

        var myModal = new bootstrap.Modal(document.getElementById('modalCategoria'));
        myModal.show();
    }
</script>
<?= $this->endSection() ?>