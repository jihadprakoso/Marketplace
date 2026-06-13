<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?= isset($product) ? 'Edit Product' : 'Add New Product' ?></h5>
                <a href="<?= base_url('seller') ?>" class="btn btn-sm btn-outline-secondary">Back to Dashboard</a>
            </div>
            <div class="card-body">
                <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
                
                <?= form_open_multipart('seller/product_form/'.(isset($product) ? $product->id : '')) ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= isset($product) ? $product->name : set_value('name') ?>" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= isset($product) ? $product->price : set_value('price') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="stock" name="stock" value="<?= isset($product) ? $product->stock : set_value('stock') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?= isset($product) ? $product->description : set_value('description') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label">Product Image</label>
                        <input class="form-control" type="file" id="image" name="image">
                        <?php if (isset($product) && $product->image): ?>
                            <div class="mt-2">
                                <img src="<?= base_url('assets/uploads/products/' . $product->image) ?>" alt="Current Image" width="100" class="img-thumbnail">
                                <small class="text-muted d-block">Current image</small>
                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary px-4"><?= isset($product) ? 'Update' : 'Add' ?> Product</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
