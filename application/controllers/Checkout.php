<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        $this->load->model('Order_model');
        $this->load->model('Product_model');
    }

    /**
     * Halaman konfirmasi: menampilkan ringkasan keranjang sebelum pesanan dibuat.
     */
    public function index() {
        $cart = $this->session->userdata('cart');

        if (empty($cart)) {
            $this->session->set_flashdata('error', 'Keranjang Anda masih kosong.');
            redirect('cart');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['price'] * $item['qty']);
        }

        $data['title'] = 'Konfirmasi Pesanan';
        $data['cart'] = $cart;
        $data['total'] = $total;

        $this->load->view('layouts/header', $data);
        $this->load->view('checkout/index', $data);
        $this->load->view('layouts/footer');
    }

    /**
     * Membuat pesanan setelah pembeli menekan tombol konfirmasi.
     */
    public function place() {
        if (!$this->input->post()) {
            redirect('checkout');
        }

        $cart = $this->session->userdata('cart');

        if (empty($cart)) {
            $this->session->set_flashdata('error', 'Keranjang Anda masih kosong.');
            redirect('cart');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['price'] * $item['qty']);
        }

        $buyer_id = $this->session->userdata('user_id');

        if ($this->Order_model->create_order($buyer_id, $total, $cart)) {
            $this->session->set_userdata('cart', []);
            $this->session->set_flashdata('success', 'Pesanan berhasil dibuat.');
            redirect('orders');
        }

        $this->session->set_flashdata('error', 'Gagal memproses pesanan. Silakan coba lagi.');
        redirect('cart');
    }
}
