<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        $this->load->model('Order_model');
    }

    public function index() {
        $cart = $this->session->userdata('cart');
        
        if (empty($cart)) {
            $this->session->set_flashdata('error', 'Your cart is empty.');
            redirect('cart');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['price'] * $item['qty']);
        }

        $buyer_id = $this->session->userdata('user_id');

        if ($this->Order_model->create_order($buyer_id, $total, $cart)) {
            // Clear cart
            $this->session->set_userdata('cart', []);
            $this->session->set_flashdata('success', 'Order placed successfully!');
            redirect('orders');
        } else {
            $this->session->set_flashdata('error', 'Failed to process order. Please try again.');
            redirect('cart');
        }
    }
}
