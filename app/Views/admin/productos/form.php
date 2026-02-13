<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">
            <?= isset($producto) ? 'Editar' : 'Nuevo' ?> Producto
        </h5>

        <form action="<?= isset($producto) ? base_url('admin/productos/actualizar/' . $producto['id']) : base_url('admin/productos/guardar') ?>"
            method="POST"
            enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Nombre del Producto</label>
                        <input type="text" name="nombre" class="form-control"
                            value="<?= old('nombre', $producto['nombre'] ?? '') ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Código</label>
                            <input type="text" name="codigo" class="form-control"
                                value="<?= old('codigo', $producto['codigo'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Categoría</label>
                            <select name="categoria_id" class="form-select" required>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"
                                        <?= (old('categoria_id', $producto['categoria_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                                        <?= $cat['nombre'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"><?= old('descripcion', $producto['descripcion'] ?? '') ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Precio Normal</label>
                            <div class="input-group">
                                <span class="input-group-text">S/</span>
                                <input type="number" step="0.01" name="precio" class="form-control"
                                    value="<?= old('precio', $producto['precio'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Precio Oferta</label>
                            <div class="input-group">
                                <span class="input-group-text">S/</span>
                                <input type="number" step="0.01" name="precio_oferta" class="form-control"
                                    value="<?= old('precio_oferta', $producto['precio_oferta'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Unidad</label>
                            <input type="text" name="unidad" class="form-control"
                                value="<?= old('unidad', $producto['unidad'] ?? 'unidad') ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock Actual</label>
                            <input type="number" name="stock" class="form-control"
                                value="<?= old('stock', $producto['stock'] ?? 0) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock Mínimo</label>
                            <input type="number" name="stock_minimo" class="form-control"
                                value="<?= old('stock_minimo', $producto['stock_minimo'] ?? 5) ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Marca</label>
                            <input type="text" name="marca" class="form-control"
                                value="<?= old('marca', $producto['marca'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Peso (kg)</label>
                            <input type="number" step="0.01" name="peso" class="form-control"
                                value="<?= old('peso', $producto['peso'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Imagen del Producto</label>
                        <div class="image-upload-box text-center p-4 border border-2 border-dashed rounded-3 position-relative bg-light" id="drop-zone">
                            <input type="file" name="imagen" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                accept="image/*" onchange="previewImage(this)">

                            <div id="uploadPlaceholder" class="<?= (isset($producto) && $producto['imagen']) ? 'd-none' : '' ?>">
                                <i class="ti ti-cloud-upload fs-8 text-primary mb-2"></i>
                                <p class="mb-0 text-muted fw-semibold">Haz clic para subir imagen</p>
                                <p class="small text-muted">JPG, PNG, WEBP (Max 2MB)</p>
                            </div>

                            <img id="imagePreview"
                                src="<?= (isset($producto) && $producto['imagen']) ? base_url('uploads/productos/' . $producto['imagen']) : '' ?>"
                                class="img-fluid rounded-2 <?= (isset($producto) && $producto['imagen']) ? '' : 'd-none' ?>"
                                style="max-height: 200px; object-fit: contain;">
                        </div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="destacado" value="1"
                            <?= (old('destacado', $producto['destacado'] ?? 0) == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label">Producto Destacado</label>
                    </div>

                    <?php if (isset($producto)): ?>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="activo" value="1"
                                <?= (old('activo', $producto['activo'] ?? 1) == 1) ? 'checked' : '' ?>>
                            <label class="form-check-label">Activo</label>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>Guardar
                </button>
                <a href="<?= base_url('admin/productos') ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        const box = document.getElementById('drop-zone');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');

                // Add success border
                box.classList.remove('border-dashed');
                box.classList.add('border-primary');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?= $this->endSection() ?>