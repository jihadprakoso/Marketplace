<div class="row">
    <div class="col-12 mb-4">
        <h3><i class="fa-solid fa-cart-shopping text-primary"></i> Your Shopping Cart</h3>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <?php if (empty($cart)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fa-solid fa-cart-arrow-down fa-3x mb-3"></i>
                        <h4>Your cart is empty</h4>
                        <a href="<?= base_url('home/products') ?>" class="btn btn-primary mt-3">Browse Products</a>
                    </div>
                <?php else: ?>
                    <?= form_open('cart/update') ?>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th width="120">Quantity</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total = 0;
                                foreach ($cart as $item): 
                                    $subtotal = $item['price'] * $item['qty'];
                                    $total += $subtotal;
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                        <td>$<?= number_format($item['price'], 2) ?></td>
                                        <td>
                                            <input type="number" name="qty[<?= $item['id'] ?>]" value="<?= $item['qty'] ?>" class="form-control form-control-sm" min="1">
                                        </td>
                                        <td class="fw-bold">$<?= number_format($subtotal, 2) ?></td>
                                        <td class="text-end">
                                            <a href="<?= base_url('cart/remove/'.$item['id']) ?>" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total:</td>
                                    <td class="fw-bold fs-5 text-primary">$<?= number_format($total, 2) ?></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <a href="<?= base_url('cart/clear') ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Clear cart?')">Clear Cart</a>
                        <button type="submit" class="btn btn-outline-secondary btn-sm">Update Cart</button>
                    </div>
                    <?= form_close() ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title mb-4">Order Summary</h5>
                <?php if (!empty($cart)): ?>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Items:</span>
                        <span><?= count($cart) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 fw-bold fs-5 border-top pt-3">
                        <span>Total:</span>
                        <span class="text-primary">$<?= number_format($total ?? 0, 2) ?></span>
                    </div>
                    
                    <?php if ($this->session->userdata('user_id')): ?>
                        <a href="<?= base_url('checkout') ?>" class="btn btn-success w-100 btn-lg">Proceed to Checkout</a>
                    <?php else: ?>
                        <div class="alert alert-warning small">You must be logged in to checkout.</div>
                        <a href="<?= base_url('auth/login') ?>" class="btn btn-primary w-100">Login to Checkout</a>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="text-muted">Add items to cart to see summary.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
