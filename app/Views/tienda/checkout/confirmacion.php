<?= $this->extend('tienda/templates/header') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <div class="mb-4">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
            </div>
            
            <h1 class="mb-3">¡Pedido Confirmado!</h1>
            <p class="lead text-muted mb-4">Gracias por tu compra. Hemos recibido tu pedido correctamente.</p>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Detalles del Pedido</h5>
                    <div class="row mt-3">
                        <div class="col-md-6 text-md-end border-end">
                            <p class="mb-1 text-muted">Número de Pedido:</p>
                            <h4 class="text-primary">#<?= $pedido['codigo'] ?></h4>
                        </div>
                        <div class="col-md-6 text-md-start">
                            <p class="mb-1 text-muted">Total:</p>
                            <h4>S/ <?= number_format($pedido['total'], 2) ?></h4>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 text-md-end border-end">
                            <p class="mb-1 text-muted">Método de Pago:</p>
                            <p class="fw-semibold"><?= ucfirst($pedido['metodo_pago']) ?></p>
                        </div>
                        <div class="col-md-6 text-md-start">
                            <p class="mb-1 text-muted">Tipo de Entrega:</p>
                            <p class="fw-semibold"><?= $pedido['tipo_envio'] == 'delivery' ? 'Delivery' : 'Recojo en tienda' ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-3">
                <a href="<?= base_url('mis-pedidos') ?>" class="btn btn-primary btn-lg">
                    <i class="bi bi-bag me-2"></i>Ver mis pedidos
                </a>
                <a href="<?= base_url('catalogo') ?>" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-shop me-2"></i>Seguir comprando
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>