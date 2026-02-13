<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - MiniMarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo i {
            font-size: 4rem;
            color: #667eea;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
        }

        .btn-login {
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-logo">
            <i class="bi bi-shop"></i>
            <h3 class="mt-2">MiniMarket</h3>
            <p class="text-muted">Inicia sesión en tu cuenta</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" required value="<?= old('email') ?>">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-login mb-3">
                <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
            </button>

            <div class="text-center">
                <p class="mb-0">¿No tienes cuenta? <a href="<?= base_url('registro') ?>" class="text-decoration-none">Regístrate aquí</a></p>
                <a href="<?= base_url('/') ?>" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i>Volver a la tienda</a>
            </div>
        </form>
    </div>
</body>

</html>