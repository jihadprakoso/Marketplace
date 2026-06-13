<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - Marketplace' : 'Marketplace' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url() ?>">
            <i class="fa-solid fa-shop me-2"></i>JihadMarket
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('home/products') ?>">Products</a></li>
            </ul>
            <ul class="navbar-nav">
                <?php if ($this->session->userdata('user_id')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('cart') ?>">
                            <i class="fa-solid fa-cart-shopping"></i> Cart
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user-circle"></i> <?= htmlspecialchars($this->session->userdata('user_name')) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php if ($this->session->userdata('user_role') === 'admin'): ?>
                                <li><a class="dropdown-item" href="<?= base_url('admin') ?>">Admin Dashboard</a></li>
                            <?php elseif ($this->session->userdata('user_role') === 'seller'): ?>
                                <li><a class="dropdown-item" href="<?= base_url('seller') ?>">Seller Dashboard</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?= base_url('orders') ?>">My Orders</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('auth/login') ?>">Login</a></li>
                    <li class="nav-item"><a class="btn btn-outline-light ms-2" href="<?= base_url('auth/register') ?>">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5 min-vh-100">
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
