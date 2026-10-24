<div class="row">
    <!-- Store Sidebar -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0 mb-4 rounded-4">
            <div class="card-body text-center p-4">
                <div class="rounded-circle bg-warning-subtle text-warning d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-store fs-3"></i>
                </div>
                <h5 class="card-title fw-bold mb-1"><?= htmlspecialchars($store->store_name) ?></h5>
                <p class="text-muted small mb-3">Merchant Hub</p>
                
                <div class="d-grid gap-2">
                    <a href="<?= base_url('seller') ?>" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-boxes-stacked me-1"></i> My Products</a>
                    <a href="<?= base_url('seller/orders') ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-receipt me-1"></i> Incoming Orders</a>
                    <a href="<?= base_url('seller/store_form') ?>" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-gear me-1"></i> Store Settings</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Incoming Orders List -->
    <div class="col-md-9">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-0"><i class="fa-solid fa-receipt text-primary me-2"></i>Incoming Sales Orders</h5>
                    <small class="text-muted">Purchases of your store products from buyers</small>
                </div>
                <span class="badge bg-primary rounded-pill px-3 py-2"><?= count($orders) ?> Total Sales</span>
            </div>
            <div class="card-body px-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="text-muted small border-bottom">
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($orders)): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="fa-solid fa-box-open fa-3x mb-3 text-secondary"></i>
                                        <h6>No customer orders received yet.</h6>
                                        <p class="small">When buyers purchase your products, orders will appear here automatically.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $seen_orders = []; ?>
                                <?php foreach ($orders as $ord): ?>
                                    <?php
                                    // Satu pesanan bisa memiliki beberapa item; form ubah status
                                    // hanya ditampilkan pada baris pertama tiap order.
                                    $is_first_row = !isset($seen_orders[$ord->order_id]);
                                    $seen_orders[$ord->order_id] = TRUE;
                                    ?>
                                    <tr>
                                        <td><span class="font-monospace fw-bold text-primary">#<?= str_pad($ord->order_id, 5, '0', STR_PAD_LEFT) ?></span></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <?php if ($ord->product_image): ?>
                                                    <img src="<?= base_url('assets/uploads/products/' . $ord->product_image) ?>" alt="img" width="38" height="38" class="rounded object-fit-cover">
                                                <?php else: ?>
                                                    <div class="bg-light rounded text-center text-muted d-flex align-items-center justify-content-center" style="width:38px; height:38px;"><i class="fa-solid fa-box small"></i></div>
                                                <?php endif; ?>
                                                <span class="fw-semibold small"><?= htmlspecialchars($ord->product_name) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small fw-semibold"><?= htmlspecialchars($ord->buyer_name) ?></div>
                                            <small class="text-muted" style="font-size:0.75rem;"><?= htmlspecialchars($ord->buyer_email) ?></small>
                                        </td>
                                        <td><span class="badge bg-light text-dark border">x<?= (int)$ord->quantity ?></span></td>
                                        <td class="fw-bold text-success">$<?= number_format($ord->price * $ord->quantity, 2) ?></td>
                                        <td>
                                            <?php
                                            $st_badge = 'bg-secondary';
                                            if ($ord->status === 'paid' || $ord->status === 'completed') $st_badge = 'bg-success';
                                            else if ($ord->status === 'shipped') $st_badge = 'bg-primary';
                                            else if ($ord->status === 'pending') $st_badge = 'bg-warning text-dark';
                                            ?>
                                            <span class="badge <?= $st_badge ?> rounded-pill text-uppercase px-2" style="font-size:0.7rem;"><?= htmlspecialchars($ord->status) ?></span>
                                        </td>
                                        <td class="text-muted small"><?= date('d M Y', strtotime($ord->created_at)) ?></td>
                                        <td>
                                            <?php if ($is_first_row): ?>
                                                <?= form_open('seller/update_order_status/' . $ord->order_id, ['class' => 'd-flex gap-1']) ?>
                                                    <select name="status" class="form-select form-select-sm" style="min-width: 110px;">
                                                        <?php foreach ($statuses as $status): ?>
                                                            <option value="<?= $status ?>" <?= $ord->status === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                                <?= form_close() ?>
                                            <?php else: ?>
                                                <span class="text-muted small">&mdash;</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
