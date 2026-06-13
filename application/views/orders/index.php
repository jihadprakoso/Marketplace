<div class="row justify-content-center">
    <div class="col-md-10">
        <h3 class="mb-4"><i class="fa-solid fa-clock-rotate-left text-primary"></i> Order History</h3>

        <?php if (empty($orders)): ?>
            <div class="card shadow-sm border-0 text-center py-5">
                <div class="card-body text-muted">
                    <i class="fa-solid fa-box-open fa-3x mb-3"></i>
                    <h4>You haven't placed any orders yet.</h4>
                    <a href="<?= base_url('home/products') ?>" class="btn btn-primary mt-3">Start Shopping</a>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold">Order #<?= str_pad($order->id, 6, '0', STR_PAD_LEFT) ?></span>
                            <span class="text-muted ms-2 small"><?= date('d M Y, H:i', strtotime($order->created_at)) ?></span>
                        </div>
                        <span class="badge bg-success text-uppercase"><?= $order->status ?></span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm mb-0">
                                <thead>
                                    <tr class="text-muted small border-bottom">
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order->items as $item): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($item->name) ?></td>
                                            <td>$<?= number_format($item->price, 2) ?></td>
                                            <td>x<?= $item->quantity ?></td>
                                            <td class="text-end">$<?= number_format($item->price * $item->quantity, 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="border-top">
                                        <td colspan="3" class="text-end fw-bold pt-3">Total Amount:</td>
                                        <td class="text-end fw-bold text-primary fs-5 pt-3">$<?= number_format($order->total_amount, 2) ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
