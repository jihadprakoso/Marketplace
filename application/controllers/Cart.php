<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Simple session-based cart initialization
        if (!$this->session->userdata('cart')) {
            $this->session->set_userdata('cart', []);
        }
    }

    public function index() {
        $data['title'] = 'Shopping Cart';
        $data['cart'] = $this->session->userdata('cart');
        
        $this->load->view('layouts/header', $data);
        $this->load->view('cart/index', $data);
        $this->load->view('layouts/footer');
    }

    public function add() {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $price = $this->input->post('price');
            $qty = (int) $this->input->post('qty');

            $cart = $this->session->userdata('cart');

            if (isset($cart[$id])) {
                $cart[$id]['qty'] += $qty;
            } else {
                $cart[$id] = [
                    'id' => $id,
                    'name' => $name,
                    'price' => $price,
                    'qty' => $qty
                ];
            }

            $this->session->set_userdata('cart', $cart);
            $this->session->set_flashdata('success', $name . ' added to cart.');
        }
        redirect('home/products');
    }

    public function update() {
        if ($this->input->post()) {
            $cart = $this->session->userdata('cart');
            $qty_updates = $this->input->post('qty');
            
            foreach ($qty_updates as $id => $qty) {
                if ($qty <= 0) {
                    unset($cart[$id]);
                } else if (isset($cart[$id])) {
                    $cart[$id]['qty'] = $qty;
                }
            }
            
            $this->session->set_userdata('cart', $cart);
            $this->session->set_flashdata('success', 'Cart updated.');
        }
        redirect('cart');
    }

    public function remove($id) {
        $cart = $this->session->userdata('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            $this->session->set_userdata('cart', $cart);
            $this->session->set_flashdata('success', 'Item removed.');
        }
        redirect('cart');
    }

    public function clear() {
        $this->session->set_userdata('cart', []);
        $this->session->set_flashdata('success', 'Cart cleared.');
        redirect('cart');
    }
}
