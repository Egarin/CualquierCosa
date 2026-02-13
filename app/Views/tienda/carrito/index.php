<?= $this->extend('tienda/templates/header') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <h2 class="mb-4"><i class="bi bi-cart3 me-2"></i>Mi Carrito</h2>

    <?php if (empty($items)): ?>
        <div class="text-center py-5">
            <i class="bi bi-cart-x display-1 text-muted"></i>
            <h4 class="mt-3">Tu carrito está vacío</h4>
            <p class="text-muted">Agrega algunos productos para comenzar</p>
            <a href="<?= base_url('catalogo') ?>" class="btn btn-primary btn-lg">Ver Catálogo</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-center">Precio</th>
                                        <th class="text-center" style="width: 150px;">Cantidad</th>
                                        <th class="text-end">Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item):
                                        $precio = $item['precio_oferta'] ?? $item['precio'];
                                        $subtotal = $precio * $item['cantidad'];
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?= $item['imagen'] ? base_url('uploads/productos/' . $item['imagen']) : base_url('assets/images/no-image.jpg') ?>"
                                                        class="rounded" width="60" height="60" style="object-fit: cover;">
                                                    <div class="ms-3">
                                                        <h6 class="mb-0"><?= $item['nombre'] ?></h6>
                                                        <small class="text-muted"><?= $item['unidad'] ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center"><?= formato_moneda($precio) ?></td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="actualizarCantidad(<?= $item['id'] ?>, <?= $item['cantidad'] - 1 ?>)">-</button>
                                                    <input type="text" class="form-control text-center" value="<?= $item['cantidad'] ?>" readonly>
                                                    <button class="btn btn-outline-secondary" type="button" onclick="actualizarCantidad(<?= $item['id'] ?>, <?= $item['cantidad'] + 1 ?>)">+</button>
                                                </div>
                                            </td>
                                            <td class="text-end fw-bold"><?= formato_moneda($subtotal) ?></td>
                                            <td class="text-end">
                                                <button class="btn btn-link text-danger" onclick="eliminarItem(<?= $item['id'] ?>)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="<?= base_url('catalogo') ?>" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Seguir comprando
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Resumen del Pedido</h5>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span class="fw-bold"><?= formato_moneda($total) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Envío</span>
                            <span class="text-success">A calcular</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5">Total</span>
                            <span class="h5 text-primary"><?= formato_moneda($total) ?></span>
                        </div>

                        <a href="<?= base_url('checkout') ?>" class="btn btn-primary w-100 btn-lg">
                            Proceder al pago<i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function actualizarCantidad(itemId, cantidad) {
        if (cantidad < 1) return;

        const formData = new FormData();
        formData.append('item_id', itemId);
        formData.append('cantidad', cantidad);
        formData.append(CSRF_TOKEN, getCsrfHash());

        fetch('<?= base_url('carrito/actualizar') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(async response => {
                const text = await response.text();
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Server response was not JSON:', text);
                    throw new Error('Error en el formato de respuesta del servidor');
                }
            })
            .then(data => {
                // Actualizar token CSRF
                if (data.csrf_name && data.csrf_hash) {
                    const meta = document.getElementById('csrf-token');
                    if (meta) {
                        meta.name = data.csrf_name;
                        meta.content = data.csrf_hash;
                    }
                }

                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Error al actualizar');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error inesperado al actualizar la cantidad');
            });
    }

    function eliminarItem(itemId) {
        if (!confirm('¿Eliminar este producto del carrito?')) return;

        const formData = new FormData();
        formData.append('item_id', itemId);
        formData.append(CSRF_TOKEN, getCsrfHash());

        fetch('<?= base_url('carrito/eliminar') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(async response => {
                const text = await response.text();
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Server response was not JSON:', text);
                    throw new Error('Error en el formato de respuesta del servidor');
                }
            })
            .then(data => {
                // Actualizar token CSRF
                if (data.csrf_name && data.csrf_hash) {
                    const meta = document.getElementById('csrf-token');
                    if (meta) {
                        meta.name = data.csrf_name;
                        meta.content = data.csrf_hash;
                    }
                }

                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error inesperado al eliminar el producto');
            });
    }
</script>
<?= $this->endSection() ?>