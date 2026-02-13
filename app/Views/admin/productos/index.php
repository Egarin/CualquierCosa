<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title fw-semibold mb-0">Gestión de Productos</h5>
            <a href="<?= base_url('admin/productos/nuevo') ?>" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>Nuevo Producto
            </a>
        </div>

        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle" id="tablaProductos">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>Imagen</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $prod): ?>
                        <tr>
                            <td>
                                <img src="<?= $prod['imagen'] ? base_url('uploads/productos/' . $prod['imagen']) : base_url('assets/images/no-image.jpg') ?>"
                                    class="product-img" alt="<?= $prod['nombre'] ?>">
                            </td>
                            <td><?= $prod['codigo'] ?></td>
                            <td>
                                <?= character_limiter($prod['nombre'], 30) ?>
                                <?php if ($prod['destacado']): ?>
                                    <span class="badge bg-warning ms-1">Destacado</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge" style="background:<?= $prod['color'] ?>">
                                    <?= $prod['categoria_nombre'] ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($prod['precio_oferta']): ?>
                                    <span class="text-decoration-line-through text-muted">S/ <?= number_format($prod['precio'], 2) ?></span><br>
                                    <span class="text-danger fw-bold">S/ <?= number_format($prod['precio_oferta'], 2) ?></span>
                                <?php else: ?>
                                    S/ <?= number_format($prod['precio'], 2) ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?= $prod['stock'] <= $prod['stock_minimo'] ? 'danger' : 'success' ?>">
                                    <?= $prod['stock'] ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?= $prod['activo'] ? 'success' : 'secondary' ?>">
                                    <?= $prod['activo'] ? 'Activo' : 'Inactivo' ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/productos/editar/' . $prod['id']) ?>" class="btn btn-sm btn-warning">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <a href="<?= base_url('admin/productos/eliminar/' . $prod['id']) ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Eliminar este producto?')">
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
<?= $this->endSection() ?>