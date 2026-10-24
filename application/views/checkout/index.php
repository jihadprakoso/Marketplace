<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h3 class="mb-0"><i class="fa-solid fa-clipboard-check text-primary"></i> Konfirmasi Pesanan</h3>
            <a href="<?= base_url('cart') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Keranjang
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Ringkasan Item</h5>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-muted small border-bottom">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['name']) ?></td>
                                    <td>$<?= number_format($item['price'], 2) ?></td>
                                    <td><span class="badge bg-light text-dark border">x<?= (int) $item['qty'] ?></span></td>
                                    <td class="text-end">$<?= number_format($item['price'] * $item['qty'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="border-top">
                                <td colspan="3" class="text-end fw-bold pt-3">Total</td>
                                <td class="text-end fw-bold text-primary fs-5 pt-3">$<?= number_format($total, 2) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <p class="text-muted mb-0 small">
                    Setelah pesanan dibuat, stok produk otomatis berkurang dan status pesanan tercatat pada halaman My Orders.
                </p>
                <?= form_open('checkout/place') ?>
                    <button type="submit" class="btn btn-success btn-lg fw-bold">
                        <i class="fa-solid fa-check me-1"></i> Buat Pesanan
                    </button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
