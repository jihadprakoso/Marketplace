<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm border-0 mt-5">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-4">Login to JihadMarket</h3>
                
                <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
                
                <?= form_open('auth/login') ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Login</button>
                    </div>
                <?= form_close() ?>
                
                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="<?= base_url('auth/register') ?>">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
