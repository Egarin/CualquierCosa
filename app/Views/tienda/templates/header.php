<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($titulo) ? $titulo : 'MiniMarket' ?> - Tu Tienda Online</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>" id="csrf-token">

    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }

        .product-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
            background: white;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .product-img {
            height: 200px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
        }

        .category-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 0.75rem;
            padding: 0.35em 0.8em;
            border-radius: 20px;
            font-weight: 500;
        }

        .price-tag {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .price-original {
            text-decoration: line-through;
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        .btn-add-cart {
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-box {
            border-radius: 25px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1.5rem;
        }

        .search-box:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .category-sidebar {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .category-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #495057;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s;
            margin-bottom: 0.5rem;
        }

        .category-link:hover,
        .category-link.active {
            background-color: #e7f1ff;
            color: var(--primary-color);
        }

        .category-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            color: white;
        }

        .footer {
            background: #2c3e50;
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="bi bi-shop me-2"></i>MiniMarket
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Buscador -->
                <form class="d-flex mx-auto w-50" action="<?= base_url('catalogo/buscar') ?>" method="GET">
                    <div class="input-group">
                        <input type="search" name="q" class="form-control search-box" placeholder="Buscar productos..."
                            value="<?= isset($_GET['q']) ? esc($_GET['q']) : '' ?>">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>

                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <a class="nav-link position-relative" href="<?= base_url('carrito') ?>">
                            <i class="bi bi-cart3 fs-4"></i>
                            <span class="cart-badge" id="cart-count">0</span>
                        </a>
                    </li>

                    <?php if (session()->get('usuario_id')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode(session()->get('nombre')) ?>&background=0d6efd&color=fff"
                                    class="rounded-circle me-2" width="32" height="32">
                                <span><?= explode(' ', session()->get('nombre'))[0] ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <?php if (session()->get('rol') === 'admin'): ?>
                                    <li><a class="dropdown-item text-primary" href="<?= base_url('admin/dashboard') ?>"><i class="bi bi-speedometer2 me-2"></i>Panel Admin</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="<?= base_url('perfil') ?>"><i class="bi bi-person me-2"></i>Mi Perfil</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('mis-pedidos') ?>"><i class="bi bi-bag me-2"></i>Mis Pedidos</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Salir</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-primary me-2" href="<?= base_url('login') ?>">Ingresar</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="<?= base_url('registro') ?>">Registrarse</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Toast Notification Success -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body" id="liveToastBody">
                    <i class="bi bi-check-circle me-2"></i>Producto agregado al carrito
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <!-- Toast Notification Error -->
        <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body" id="errorToastBody">
                    <i class="bi bi-exclamation-circle me-2"></i>Error al agregar
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div style="min-height: calc(100vh - 350px);">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Footer -->
    <?= $this->include('tienda/templates/footer') ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const BASE_URL = '<?= base_url() ?>';
        const CSRF_TOKEN = '<?= csrf_token() ?>';

        document.addEventListener('DOMContentLoaded', function() {
            if (!window.location.href.includes('login') && !window.location.href.includes('registro')) {
                actualizarContadorCarrito();
            }
        });

        function getCsrfHash() {
            return document.getElementById('csrf-token').content;
        }

        function agregarAlCarrito(productoId, cantidad = 1) {
            const formData = new FormData();
            formData.append('producto_id', productoId);
            formData.append('cantidad', cantidad);
            formData.append(CSRF_TOKEN, getCsrfHash());

            fetch(BASE_URL + 'carrito/agregar', {
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
                    // Actualizar token CSRF si viene en la respuesta
                    if (data.csrf_name && data.csrf_hash) {
                        const meta = document.getElementById('csrf-token');
                        if (meta) {
                            meta.name = data.csrf_name;
                            meta.content = data.csrf_hash;
                        }
                    }

                    if (data.success) {
                        const cartCount = document.getElementById('cart-count');
                        if (cartCount) cartCount.textContent = data.contador;
                        showToast('Producto agregado al carrito');
                    } else {
                        showToast(data.message || 'Error al agregar al carrito', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error inesperado', 'error');
                });
        }

        function actualizarContadorCarrito() {
            fetch(BASE_URL + 'carrito/contador')
                .then(async response => {
                    const text = await response.text();
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        if (text.includes('<!DOCTYPE html>')) {
                            console.error('El servidor devolvió HTML en lugar de JSON para el contador.');
                        } else {
                            console.error('Error al parsear contador:', e, 'Response text:', text);
                        }
                        return {
                            contador: 0
                        };
                    }
                })
                .then(data => {
                    const cartCount = document.getElementById('cart-count');
                    if (cartCount) cartCount.textContent = data.contador || 0;
                })
                .catch(error => {
                    console.error('Error de conexión al contador:', error);
                });
        }

        function showToast(mensaje, tipo = 'success') {
            const toastId = tipo === 'success' ? 'liveToast' : 'errorToast';
            const bodyId = tipo === 'success' ? 'liveToastBody' : 'errorToastBody';
            const icon = tipo === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle';

            const body = document.getElementById(bodyId);
            if (body) {
                body.innerHTML = `<i class="bi ${icon} me-2"></i>${mensaje}`;
            }

            const toastEl = document.getElementById(toastId);
            if (toastEl) {
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            }
        }
    </script>
</body>

</html>