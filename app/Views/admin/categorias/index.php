<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title fw-semibold mb-0">Categorías</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNueva">
                <i class="ti ti-plus me-1"></i>Nueva Categoría
            </button>
        </div>

        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>Nombre</th>
                        <th>Icono</th>
                        <th>Color</th>
                        <th>Orden</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $cat): ?>
                        <tr>
                            <td><?= $cat['nombre'] ?></td>
                            <td><i class="<?= $cat['icono'] ?> fs-5" style="color:<?= $cat['color'] ?>"></i></td>
                            <td>
                                <span class="badge" style="background:<?= $cat['color'] ?>"><?= $cat['color'] ?></span>
                            </td>
                            <td><?= $cat['orden'] ?></td>
                            <td>
                                <span class="badge bg-<?= $cat['activo'] ? 'success' : 'secondary' ?>">
                                    <?= $cat['activo'] ? 'Activo' : 'Inactivo' ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editar(<?= htmlspecialchars(json_encode($cat)) ?>)">
                                    <i class="ti ti-edit"></i>
                                </button>
                                <a href="<?= base_url('admin/categorias/eliminar/' . $cat['id']) ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Eliminar?')">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Nueva -->
<div class="modal fade" id="modalNueva" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/categorias/guardar') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icono (clase Bootstrap)</label>
                            <input type="text" name="icono" class="form-control" placeholder="ti ti-home">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Color</label>
                            <input type="color" name="color" class="form-control" value="#0d6efd">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Orden</label>
                        <input type="number" name="orden" class="form-control" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editar(categoria) {
        // Implementar edición con modal similar
        console.log(categoria);
    }
</script>
<?= $this->endSection() ?>