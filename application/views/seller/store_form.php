<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0"><?= isset($store) ? 'Edit Store Setup' : 'Setup Your Store' ?></h5>
            </div>
            <div class="card-body">
                <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
                
                <?= form_open('seller/save_store') ?>
                    <div class="mb-3">
                        <label for="store_name" class="form-label">Store Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="store_name" name="store_name" value="<?= isset($store) ? $store->store_name : set_value('store_name') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Store Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?= isset($store) ? $store->description : set_value('description') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Store</button>
                    <?php if (isset($store)): ?>
                        <a href="<?= base_url('seller') ?>" class="btn btn-light ms-2">Cancel</a>
                    <?php endif; ?>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
