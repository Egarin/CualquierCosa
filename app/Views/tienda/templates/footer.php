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

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Configuración de URL base
    const BASE_URL = '<?= base_url() ?>';

    // Actualizar contador del carrito al cargar
    document.addEventListener('DOMContentLoaded', function() {
        if (!window.location.href.includes('login') && !window.location.href.includes('registro')) {
            actualizarContadorCarrito();
        }
    });

    function agregarAlCarrito(productoId, cantidad = 1) {
        const formData = new FormData();
        formData.append('producto_id', productoId);
        formData.append('cantidad', cantidad);

        fetch(BASE_URL + 'carrito/agregar', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const cartCount = document.getElementById('cart-count');
                    if (cartCount) cartCount.textContent = data.contador;

                    const toastEl = document.getElementById('liveToast');
                    if (toastEl) {
                        const toast = new bootstrap.Toast(toastEl);
                        toast.show();
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function actualizarContadorCarrito() {
        fetch(BASE_URL + 'carrito/contador')
            .then(response => response.json())
            .then(data => {
                const cartCount = document.getElementById('cart-count');
                if (cartCount) cartCount.textContent = data.contador || 0;
            })
            .catch(error => console.error('Error:', error));
    }
</script>
</body>

</html>