<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2 class="fw-bold mb-1"><i class="fa-solid fa-gauge-high text-primary me-2"></i>Platform Overview</h2>
            <p class="text-muted mb-0">System administration & ecosystem monitoring</p>
        </div>
        <div>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill font-monospace">
                <i class="fa-solid fa-circle-check me-1"></i> Core v1.5.0 Online
            </span>
        </div>
    </div>
</div>

<!-- Quick Statistics Cards -->
<div class="row g-3 mb-5">
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                    <i class="fa-solid fa-users fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted small text-uppercase mb-1">Total Users</h6>
                    <h3 class="fw-bold mb-0"><?= number_format($total_users) ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                    <i class="fa-solid fa-store fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted small text-uppercase mb-1">Active Stores</h6>
                    <h3 class="fw-bold mb-0"><?= number_format($total_stores) ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                    <i class="fa-solid fa-boxes-stacked fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted small text-uppercase mb-1">Total Products</h6>
                    <h3 class="fw-bold mb-0"><?= number_format($total_products) ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                    <i class="fa-solid fa-dollar-sign fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted small text-uppercase mb-1">Total Revenue</h6>
                    <h3 class="fw-bold mb-0">$<?= number_format($total_revenue, 2) ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Recent Platform Orders -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0"><i class="fa-solid fa-receipt text-primary me-2"></i>Recent Orders</h5>
                <span class="text-muted small"><?= count($recent_orders) ?> orders recorded</span>
            </div>
            <div class="card-body px-4">
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="text-muted small border-bottom">
                            <tr>
                                <th>Order ID</th>
                                <th>Buyer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recent_orders)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No transactions recorded yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recent_orders as $ord): ?>
                                    <tr>
                                        <td><span class="font-monospace fw-bold text-primary">#<?= str_pad($ord->id, 5, '0', STR_PAD_LEFT) ?></span></td>
                                        <td>
                                            <div class="fw-semibold"><?= htmlspecialchars($ord->buyer_name) ?></div>
                                            <small class="text-muted"><?= htmlspecialchars($ord->buyer_email) ?></small>
                                        </td>
                                        <td class="fw-bold text-success">$<?= number_format($ord->total_amount, 2) ?></td>
                                        <td>
                                            <?= form_open('admin/update_order_status/' . $ord->id, ['class' => 'd-flex gap-1 align-items-center']) ?>
                                                <select name="status" class="form-select form-select-sm" style="min-width: 110px;">
                                                    <?php foreach ($statuses as $status): ?>
                                                        <option value="<?= $status ?>" <?= $ord->status === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-outline-primary">Simpan</button>
                                            <?= form_close() ?>
                                        </td>
                                        <td class="text-muted small"><?= date('d M Y, H:i', strtotime($ord->created_at)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick User Directory -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0"><i class="fa-solid fa-user-shield text-primary me-2"></i>Recent Members</h5>
            </div>
            <div class="card-body px-4">
                <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                    <?php foreach ($recent_users as $usr): ?>
                        <li class="d-flex align-items-center justify-content-between p-2 rounded-3 bg-light">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-circle-user fs-4 text-muted"></i>
                                <div>
                                    <p class="mb-0 fw-semibold small"><?= htmlspecialchars($usr->name) ?></p>
                                    <small class="text-muted" style="font-size:0.75rem;"><?= htmlspecialchars($usr->email) ?></small>
                                </div>
                            </div>
                            <?php
                            $role_badge = 'bg-secondary';
                            if ($usr->role === 'admin') $role_badge = 'bg-danger';
                            else if ($usr->role === 'seller') $role_badge = 'bg-warning text-dark';
                            else $role_badge = 'bg-info text-dark';
                            ?>
                            <span class="badge <?= $role_badge ?> rounded-pill text-uppercase" style="font-size:0.65rem;"><?= htmlspecialchars($usr->role) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Registered Stores List -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0"><i class="fa-solid fa-shop text-primary me-2"></i>Registered Multi-Vendor Stores</h5>
                <span class="text-muted small"><?= count($stores) ?> merchant(s) registered</span>
            </div>
            <div class="card-body px-4">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="text-muted small border-bottom">
                            <tr>
                                <th>Store Name</th>
                                <th>Merchant (Owner)</th>
                                <th>Description</th>
                                <th>Total Products</th>
                                <th>Member Since</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($stores)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No merchant stores registered yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($stores as $st): ?>
                                    <tr>
                                        <td class="fw-bold"><i class="fa-solid fa-store text-warning me-2"></i><?= htmlspecialchars($st->store_name) ?></td>
                                        <td>
                                            <div class="fw-semibold"><?= htmlspecialchars($st->owner_name) ?></div>
                                            <small class="text-muted"><?= htmlspecialchars($st->owner_email) ?></small>
                                        </td>
                                        <td class="text-muted small" style="max-width: 300px;"><?= htmlspecialchars($st->description ?: 'No description provided') ?></td>
                                        <td><span class="badge bg-primary rounded-pill px-3"><?= number_format($st->product_count) ?> Items</span></td>
                                        <td class="text-muted small"><?= date('d M Y', strtotime($st->created_at)) ?></td>
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
