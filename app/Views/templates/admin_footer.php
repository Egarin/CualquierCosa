            </div>
            </div>
            </div>

            <!-- MatDash JS -->
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <script src="<?= base_url('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
            <script src="<?= base_url('assets/js/theme/app.init.js?v=' . time()) ?>"></script>
            <script src="<?= base_url('assets/js/theme/sidebarmenu.js?v=' . time()) ?>"></script>
            <script src="<?= base_url('assets/js/theme/app.min.js?v=' . time()) ?>"></script>
            <script src="<?= base_url('assets/libs/apexcharts/dist/apexcharts.min.js') ?>"></script>
            <script src="<?= base_url('assets/libs/simplebar/dist/simplebar.min.js') ?>"></script>

            <!-- SweetAlert2 -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                // Notificaciones
                <?php if (session()->getFlashdata('success')): ?>
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: '<?= session()->getFlashdata('success') ?>',
                        timer: 3000,
                        showConfirmButton: false
                    });
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '<?= session()->getFlashdata('error') ?>'
                    });
                <?php endif; ?>
            </script>

            <?= $this->renderSection('scripts') ?>
            </body>

            </html>