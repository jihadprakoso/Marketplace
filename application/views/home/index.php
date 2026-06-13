<!-- Hero Section -->
<div class="bg-primary text-white text-center py-5 mb-5 rounded-3 shadow-sm mt-3">
    <div class="container py-4">
        <h1 class="display-4 fw-bold">Welcome to JihadMarket</h1>
        <p class="lead">Discover amazing products from our trusted sellers.</p>
        <?php if(!$this->session->userdata('user_id')): ?>
            <a href="<?= base_url('auth/register') ?>" class="btn btn-light btn-lg mt-3 fw-bold">Join Now</a>
        <?php endif; ?>
    </div>
</div>

<!-- Product Catalog -->
<div class="row">
    <div class="col-12 mb-4">
        <h3 class="border-bottom pb-2">Latest Products</h3>
    </div>
    
    <?php if (empty($products)): ?>
        <div class="col-12 text-center py-5 text-muted">
            <i class="fa-solid fa-box-open fa-3x mb-3"></i>
            <h4>No products available right now.</h4>
            <p>Check back later!</p>
        </div>
    <?php else: ?>
        <?php foreach ($products as $p): ?>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <div class="product-img-wrapper">
                        <?php if ($p->image): ?>
                            <img src="<?= base_url('assets/uploads/products/' . $p->image) ?>" alt="<?= htmlspecialchars($p->name) ?>" class="card-img-top">
                        <?php else: ?>
                            <div class="text-muted"><i class="fa-solid fa-image fa-3x"></i></div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title text-truncate" title="<?= htmlspecialchars($p->name) ?>"><?= htmlspecialchars($p->name) ?></h6>
                        <p class="text-primary fw-bold mb-1">$<?= number_format($p->price, 2) ?></p>
                        <small class="text-muted mb-3"><i class="fa-solid fa-store"></i> <?= htmlspecialchars($p->store_name) ?></small>
                        <div class="mt-auto">
                            <?php if ($p->stock > 0): ?>
                                <?= form_open('cart/add') ?>
                                    <input type="hidden" name="id" value="<?= $p->id ?>">
                                    <input type="hidden" name="qty" value="1">
                                    <input type="hidden" name="price" value="<?= $p->price ?>">
                                    <input type="hidden" name="name" value="<?= htmlspecialchars($p->name) ?>">
                                    <button type="submit" class="btn btn-outline-primary w-100"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                                <?= form_close() ?>
                            <?php else: ?>
                                <button class="btn btn-secondary w-100" disabled>Out of Stock</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
