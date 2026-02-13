<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="fw-bold text-white mb-3">
                    <i class="bi bi-shop me-2"></i>MiniMarket
                </h5>
                <p class="text-white-50 small">
                    Tu tienda de confianza con los mejores productos y precios del mercado.
                    Calidad garantizada en cada entrega.
                </p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="fw-bold text-white mb-3">Enlaces Rápidos</h5>
                <ul class="list-unstyled">
                    <li><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Inicio</a></li>
                    <li><a href="<?= base_url('catalogo') ?>" class="text-white-50 text-decoration-none">Catálogo</a></li>
                    <li><a href="<?= base_url('mis-pedidos') ?>" class="text-white-50 text-decoration-none">Mis Pedidos</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="fw-bold text-white mb-3">Contacto</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>Calle Principal 123, Ciudad</li>
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i>contacto@minimarket.com</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2"></i>+51 987 654 321</li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary my-4">
        <div class="text-center text-white-50 small">
            &copy; <?= date('Y') ?> MiniMarket. Todos los derechos reservados.
        </div>
    </div>
</footer>