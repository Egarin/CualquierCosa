<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Gestión de Productos</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-muted" href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Productos</li>
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <i class="ti ti-package text-primary" style="font-size: 5rem; opacity: 0.1;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold mb-0 lh-sm">Listado de Productos</h5>
            <a href="<?= base_url('admin/productos/nuevo') ?>" class="btn btn-primary d-flex align-items-center">
                <i class="ti ti-plus me-2"></i> Nuevo Producto
            </a>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive rounded-2 mb-4">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Producto</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Categoría</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Precio</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Stock</h6>
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
                    <?php foreach ($productos as $prod): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?= $prod['imagen'] ? base_url('uploads/productos/' . $prod['imagen']) : base_url('assets/images/no-image.jpg') ?>"
                                        class="rounded-3 me-3" width="50" height="50" style="object-fit: cover;" alt="<?= $prod['nombre'] ?>">
                                    <div>
                                        <h6 class="fw-semibold mb-1"><?= character_limiter($prod['nombre'], 30) ?></h6>
                                        <span class="fs-2 text-muted"><?= $prod['codigo'] ?></span>
                                        <?php if ($prod['destacado']): ?>
                                            <i class="ti ti-star-filled text-warning ms-1" title="Destacado"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge rounded-3 fw-semibold fs-2" style="background-color: <?= $prod['color'] ?>20; color: <?= $prod['color'] ?>">
                                    <?= $prod['categoria_nombre'] ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($prod['precio_oferta']): ?>
                                    <h6 class="fw-semibold mb-1 text-danger">Gs. <?= number_format($prod['precio_oferta'], 0) ?></h6>
                                    <span class="fs-2 text-decoration-line-through text-muted">Gs. <?= number_format($prod['precio'], 0) ?></span>
                                <?php else: ?>
                                    <h6 class="fw-semibold mb-0">Gs. <?= number_format($prod['precio'], 0) ?></h6>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge <?= $prod['stock'] <= $prod['stock_minimo'] ? 'bg-danger' : 'bg-success' ?> rounded-3 fw-semibold">
                                        <?= $prod['stock'] ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge <?= $prod['activo'] ? 'bg-light-success text-success' : 'bg-light-danger text-danger' ?> rounded-3 fw-semibold">
                                        <?= $prod['activo'] ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown dropstart">
                                    <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical fs-6"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-3" href="<?= base_url('admin/productos/editar/' . $prod['id']) ?>">
                                                <i class="fs-4 ti ti-edit"></i>Editar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-3 text-danger" href="<?= base_url('admin/productos/eliminar/' . $prod['id']) ?>"
                                                onclick="return confirm('¿Eliminar este producto?')">
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
<?= $this->endSection() ?>