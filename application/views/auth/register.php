<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 mt-5">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-4">Create an Account</h3>
                
                <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
                
                <?= form_open('auth/register') ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">I want to...</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="buyer" <?= set_select('role', 'buyer') ?>>Buy products</option>
                            <option value="seller" <?= set_select('role', 'seller') ?>>Sell products</option>
                        </select>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Register</button>
                    </div>
                <?= form_close() ?>
                
                <div class="text-center mt-3">
                    <p>Already have an account? <a href="<?= base_url('auth/login') ?>">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
