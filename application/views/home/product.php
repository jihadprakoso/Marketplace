<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('home/products') ?>">Products</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($product->name) ?></li>
    </ol>
</nav>

<div class="row g-4 mb-5">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
            <div class="product-img-wrapper" style="height: 420px;">
                <?php if ($product->image): ?>
                    <img src="<?= base_url('assets/uploads/products/' . $product->image) ?>" alt="<?= htmlspecialchars($product->name) ?>" class="card-img-top h-100 object-fit-cover">
                <?php else: ?>
                    <div class="text-muted h-100 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-image fa-4x"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex flex-column p-4">
                <h2 class="fw-bold mb-2"><?= htmlspecialchars($product->name) ?></h2>

                <p class="text-muted mb-3">
                    <i class="fa-solid fa-store text-warning me-1"></i>
                    <?= htmlspecialchars($product->store_name) ?>
                </p>

                <h3 class="text-primary fw-bold mb-4">$<?= number_format($product->price, 2) ?></h3>

                <p class="mb-4">
                    <?php if ((int) $product->stock > 0): ?>
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                            <i class="fa-solid fa-circle-check me-1"></i> Stok tersedia: <?= (int) $product->stock ?>
                        </span>
                    <?php else: ?>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                            <i class="fa-solid fa-circle-xmark me-1"></i> Stok habis
                        </span>
                    <?php endif; ?>
                </p>

                <div class="mb-4">
                    <h6 class="text-uppercase text-muted small fw-bold">Deskripsi</h6>
                    <p class="text-body mb-0" style="white-space: pre-line;">
                        <?= htmlspecialchars($product->description ?: 'Penjual belum menambahkan deskripsi untuk produk ini.') ?>
                    </p>
                </div>

                <div class="d-flex flex-wrap gap-2 mt-auto">
                    <?php if ((int) $product->stock > 0): ?>
                        <?= form_open('cart/add', ['class' => 'd-flex gap-2 flex-grow-1']) ?>
                            <input type="hidden" name="id" value="<?= (int) $product->id ?>">
                            <input type="hidden" name="name" value="<?= htmlspecialchars($product->name) ?>">
                            <input type="hidden" name="price" value="<?= $product->price ?>">
                            <input type="number" name="qty" value="1" min="1" max="<?= (int) $product->stock ?>" class="form-control" style="max-width: 110px;">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fa-solid fa-cart-plus me-1"></i> Add to Cart
                            </button>
                        <?= form_close() ?>
                    <?php else: ?>
                        <button class="btn btn-secondary w-100" disabled>Out of Stock</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($related)): ?>
    <div class="row mb-3">
        <div class="col-12">
            <h4 class="border-bottom pb-2">Produk lain dari <?= htmlspecialchars($product->store_name) ?></h4>
        </div>
    </div>

    <div class="row">
        <?php foreach ($related as $p): ?>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <a href="<?= base_url('home/product/' . $p->id) ?>" class="text-decoration-none">
                        <div class="product-img-wrapper">
                            <?php if ($p->image): ?>
                                <img src="<?= base_url('assets/uploads/products/' . $p->image) ?>" alt="<?= htmlspecialchars($p->name) ?>" class="card-img-top">
                            <?php else: ?>
                                <div class="text-muted"><i class="fa-solid fa-image fa-3x"></i></div>
                            <?php endif; ?>
                        </div>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title text-truncate" title="<?= htmlspecialchars($p->name) ?>">
                            <a href="<?= base_url('home/product/' . $p->id) ?>" class="text-decoration-none text-dark"><?= htmlspecialchars($p->name) ?></a>
                        </h6>
                        <p class="text-primary fw-bold mb-0">$<?= number_format($p->price, 2) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
