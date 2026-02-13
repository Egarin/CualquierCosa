<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - MiniMarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 3rem;
            width: 100%;
            max-width: 500px;
        }

        .register-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-logo i {
            font-size: 4rem;
            color: #667eea;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
        }

        .btn-register {
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="register-card">
        <div class="register-logo">
            <i class="bi bi-shop"></i>
            <h3 class="mt-2">Crear Cuenta</h3>
            <p class="text-muted">Regístrate para comenzar a comprar</p>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php $errs = session()->getFlashdata('errors'); ?>
                    <?php if (is_array($errs)): ?>
                        <?php foreach ($errs as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><?= $errs ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('registro') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Nombre Completo</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="nombre" class="form-control" required value="<?= old('nombre') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" required value="<?= old('email') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                    <input type="tel" name="telefono" class="form-control" required value="<?= old('telefono') ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label">Confirmar Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-register mb-3">
                <i class="bi bi-person-plus me-2"></i>Crear Cuenta
            </button>

            <div class="text-center">
                <p class="mb-0">¿Ya tienes cuenta? <a href="<?= base_url('login') ?>" class="text-decoration-none">Inicia sesión</a></p>
                <a href="<?= base_url('/') ?>" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i>Volver a la tienda</a>
            </div>
        </form>
    </div>
</body>

</html>