<div class="row">
    <div class="col-md-3">
        <div class="card shadow-sm border-0 mb-4 rounded-4">
            <div class="card-body text-center p-4">
                <div class="rounded-circle bg-warning-subtle text-warning d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-store fs-3"></i>
                </div>
                <h5 class="card-title fw-bold mb-1"><?= htmlspecialchars($store->store_name) ?></h5>
                <p class="text-muted small mb-3">Merchant Hub</p>
                
                <div class="d-grid gap-2">
                    <a href="<?= base_url('seller') ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-boxes-stacked me-1"></i> My Products</a>
                    <a href="<?= base_url('seller/orders') ?>" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-receipt me-1"></i> Incoming Orders</a>
                    <a href="<?= base_url('seller/store_form') ?>" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-gear me-1"></i> Store Settings</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">My Products</h5>
                <a href="<?= base_url('seller/product_form') ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Add Product</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($products)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No products found. Start adding some!</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($products as $p): ?>
                                <tr>
                                    <td>
                                        <?php if ($p->image): ?>
                                            <img src="<?= base_url('assets/uploads/products/' . $p->image) ?>" alt="img" width="50" class="img-thumbnail">
                                        <?php else: ?>
                                            <div class="bg-light text-center text-muted" style="width:50px; height:50px; line-height:50px;"><i class="fa-solid fa-image"></i></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($p->name) ?></td>
                                    <td>$<?= number_format($p->price, 2) ?></td>
                                    <td>
                                        <span class="badge <?= $p->stock > 0 ? 'bg-success' : 'bg-danger' ?>"><?= $p->stock ?></span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('seller/product_form/'.$p->id) ?>" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-edit"></i></a>
                                        <a href="<?= base_url('seller/delete_product/'.$p->id) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="fa-solid fa-trash"></i></a>
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
