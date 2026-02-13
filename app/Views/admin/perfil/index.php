<?= $this->extend('templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body text-center p-5">
                <div class="mb-4">
                    <img src="<?= base_url('assets/images/profile/user-1.jpg') ?>" class="rounded-circle shadow-sm" width="120" height="120" style="object-fit:cover;">
                </div>
                <h4 class="fw-bold text-dark mb-1"><?= $usuario['nombre'] ?></h4>
                <p class="text-muted mb-4">Administrador</p>

                <div class="d-flex justify-content-center gap-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                        <i class="ti ti-shield-check me-1"></i> Cuenta Verificada
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white py-4 px-4 border-bottom-0">
                <h5 class="fw-bold mb-0 text-dark">Editar Información</h5>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('admin/perfil/actualizar') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="row g-4">
                        <div class="col-12">
                            <h6 class="text-primary fw-bold text-uppercase small mb-3" style="letter-spacing: 1px;">Datos Personales</h6>
                        </div>

                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-semibold text-dark">Nombre Completo</label>
                            <input type="text" class="form-control py-2" id="nombre" name="nombre"
                                value="<?= old('nombre', $usuario['nombre']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold text-dark">Correo Electrónico</label>
                            <input type="email" class="form-control py-2" id="email" name="email"
                                value="<?= old('email', $usuario['email']) ?>" required>
                        </div>

                        <div class="col-12 mt-4">
                            <h6 class="text-primary fw-bold text-uppercase small mb-3" style="letter-spacing: 1px;">Seguridad</h6>
                            <div class="alert alert-light border-start border-primary border-4 py-2 px-3 mb-4">
                                <small class="text-muted"><i class="ti ti-info-circle me-1"></i> Deja los campos de contraseña en blanco si no deseas cambiarla.</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold text-dark">Nueva Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-lock"></i></span>
                                <input type="password" class="form-control border-start-0 py-2" id="password" name="password"
                                    placeholder="••••••••">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="confirm_password" class="form-label fw-semibold text-dark">Confirmar Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-lock-check"></i></span>
                                <input type="password" class="form-control border-start-0 py-2" id="confirm_password" name="confirm_password"
                                    placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm">
                            <i class="ti ti-device-floppy me-2"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>