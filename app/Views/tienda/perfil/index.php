<?= $this->extend('tienda/templates/header') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="bg-primary p-4 text-center">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                            <span class="fs-2 text-primary fw-bold"><?= strtoupper(substr($usuario['nombre'], 0, 1)) ?></span>
                        </div>
                        <h5 class="text-white mb-0"><?= $usuario['nombre'] ?></h5>
                        <small class="text-white-50"><?= $usuario['email'] ?></small>
                    </div>
                    <div class="list-group list-group-flush" id="profileTabs" role="tablist">
                        <button class="list-group-item list-group-item-action active border-0 px-4 py-3" data-bs-toggle="pill" data-bs-target="#tab-info">
                            <i class="bi bi-person me-2"></i>Mis Datos
                        </button>
                        <button class="list-group-item list-group-item-action border-0 px-4 py-3" data-bs-toggle="pill" data-bs-target="#tab-direcciones">
                            <i class="bi bi-geo-alt me-2"></i>Mis Direcciones
                        </button>
                        <button class="list-group-item list-group-item-action border-0 px-4 py-3" data-bs-toggle="pill" data-bs-target="#tab-seguridad">
                            <i class="bi bi-shield-lock me-2"></i>Seguridad
                        </button>
                        <a href="<?= base_url('logout') ?>" class="list-group-item list-group-item-action border-0 px-4 py-3 text-danger">
                            <i class="bi bi-box-arrow-left me-2"></i>Cerrar Sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-lg-9">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger border-0 rounded-3 shadow-sm mb-4">
                    <i class="bi bi-exclamation-circle-fill me-2"></i><?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="tab-content border-0 shadow-sm rounded-4 bg-white p-4" id="v-pills-tabContent">
                <!-- Tab: Personal Info -->
                <div class="tab-pane fade show active" id="tab-info" role="tabpanel">
                    <h4 class="fw-bold mb-4">Información Personal</h4>
                    <form action="<?= base_url('perfil/actualizar') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nombre Completo</label>
                                <input type="text" name="nombre" class="form-control rounded-3" value="<?= old('nombre', $usuario['nombre']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control rounded-3" value="<?= old('email', $usuario['email']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Teléfono</label>
                                <input type="text" name="telefono" class="form-control rounded-3" value="<?= old('telefono', $usuario['telefono']) ?>" required>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-bold">Guardar Cambios</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tab: Addresses -->
                <div class="tab-pane fade" id="tab-direcciones" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">Mis Direcciones</h4>
                        <button class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="mostrarModalDireccion()">
                            <i class="bi bi-plus-circle me-1"></i>Agregar Nueva
                        </button>
                    </div>

                    <div id="lista-direcciones-perfil">
                        <?php if (empty($direcciones)): ?>
                            <div class="text-center py-5">
                                <i class="bi bi-geo-alt text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3">No tienes direcciones guardadas.</p>
                            </div>
                        <?php else: ?>
                            <div class="row g-3">
                                <?php foreach ($direcciones as $dir): ?>
                                    <div class="col-md-6">
                                        <div class="card border rounded-3 h-100 transition-base hover-shadow">
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="fw-bold text-dark">
                                                        <?= $dir['alias'] ?: 'Dirección' ?>
                                                        <?php if ($dir['es_principal']): ?>
                                                            <span class="badge bg-primary-subtle text-primary rounded-pill text-uppercase border-0 ms-1" style="font-size: 0.65rem;">Principal</span>
                                                        <?php endif; ?>
                                                    </span>
                                                    <div>
                                                        <button class="btn btn-link text-primary p-0 me-2" onclick='editarDireccion(<?= json_encode($dir) ?>)'>
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                        <button class="btn btn-link text-danger p-0" onclick="eliminarDireccion(<?= $dir['id'] ?>)">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <p class="small text-muted mb-0"><?= $dir['direccion'] ?></p>
                                                <?php if ($dir['referencia']): ?>
                                                    <small class="text-black-50 d-block mt-1"><i class="bi bi-info-circle me-1"></i><?= $dir['referencia'] ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Tab: Security -->
                <div class="tab-pane fade" id="tab-seguridad" role="tabpanel">
                    <h4 class="fw-bold mb-4">Cambiar Contraseña</h4>
                    <form action="<?= base_url('perfil/cambiar-password') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row g-3" style="max-width: 500px;">
                            <div class="col-12">
                                <label class="form-label small fw-bold">Contraseña Actual</label>
                                <input type="password" name="current_password" class="form-control rounded-3" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Nueva Contraseña</label>
                                <input type="password" name="new_password" class="form-control rounded-3" required>
                                <small class="text-muted">Mínimo 6 caracteres.</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Confirmar Nueva Contraseña</label>
                                <input type="password" name="confirm_password" class="form-control rounded-3" required>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-bold">Actualizar Contraseña</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Dirección (Reutilizar o Adaptar) -->
<div class="modal fade" id="modalDireccion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 16px;">
            <div class="modal-header border-bottom-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="modalDireccionTitulo">Nueva Dirección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formDireccion">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" id="direccion_id_edit">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Alias (Ej: Casa, Oficina)</label>
                        <input type="text" name="alias" id="alias_input" class="form-control rounded-3" placeholder="Nombre para esta dirección" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Dirección Completa</label>
                        <textarea name="direccion" id="direccion_input" class="form-control rounded-3" rows="2" placeholder="Calle, número, barrio..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Referencia</label>
                        <textarea name="referencia" id="referencia_input" class="form-control rounded-3" rows="1" placeholder="Ej: Frente a la plaza, portón azul..."></textarea>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="es_principal" id="esPrincipalInput" checked>
                        <label class="form-check-label small" for="esPrincipalInput">Establecer como dirección principal</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pb-4 px-4">
                <button type="button" class="btn btn-light w-100 py-2 fw-bold" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btnGuardarDireccion" onclick="procesarDireccion()" class="btn btn-primary w-100 py-2 fw-bold">Guardar Dirección</button>
            </div>
        </div>
    </div>
</div>

<script>
    function mostrarModalDireccion() {
        document.getElementById('formDireccion').reset();
        document.getElementById('direccion_id_edit').value = '';
        document.getElementById('modalDireccionTitulo').innerText = 'Nueva Dirección';
        const modal = new bootstrap.Modal(document.getElementById('modalDireccion'));
        modal.show();
    }

    function editarDireccion(dir) {
        document.getElementById('direccion_id_edit').value = dir.id;
        document.getElementById('alias_input').value = dir.alias;
        document.getElementById('direccion_input').value = dir.direccion;
        document.getElementById('referencia_input').value = dir.referencia;
        document.getElementById('esPrincipalInput').checked = dir.es_principal == 1;
        document.getElementById('modalDireccionTitulo').innerText = 'Editar Dirección';
        const modal = new bootstrap.Modal(document.getElementById('modalDireccion'));
        modal.show();
    }

    function procesarDireccion() {
        const id = document.getElementById('direccion_id_edit').value;
        const url = id ? BASE_URL + 'direcciones/actualizar/' + id : BASE_URL + 'direcciones/guardar';
        const form = document.getElementById('formDireccion');
        const formData = new FormData(form);
        const btn = document.getElementById('btnGuardarDireccion');

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';

        fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Simple reload for profile page to show changes
                } else {
                    showToast(data.message || 'Error al procesar dirección', 'error');
                }
            })
            .catch(error => showToast('Error de conexión', 'error'))
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = 'Guardar Dirección';
            });
    }

    function eliminarDireccion(id) {
        if (!confirm('¿Estás seguro de que deseas eliminar esta dirección?')) return;

        fetch(BASE_URL + 'direcciones/eliminar/' + id, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    showToast(data.message || 'Error al eliminar', 'error');
                }
            })
            .catch(error => showToast('Error de conexión', 'error'));
    }
</script>

<style>
    .transition-base {
        transition: all 0.2s ease-in-out;
    }

    .hover-shadow:hover {
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .08) !important;
        transform: translateY(-2px);
    }

    .list-group-item.active {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
        font-weight: bold;
    }

    .list-group-item:hover:not(.active) {
        background-color: #f8f9fa;
    }
</style>
<?= $this->endSection() ?>