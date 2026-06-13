<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        $this->load->model('Order_model');
    }

    public function index() {
        $buyer_id = $this->session->userdata('user_id');
        $orders = $this->Order_model->get_buyer_orders($buyer_id);

        foreach ($orders as $order) {
            $order->items = $this->Order_model->get_order_items($order->id);
        }

        $data['title'] = 'My Orders';
        $data['orders'] = $orders;

        $this->load->view('layouts/header', $data);
        $this->load->view('orders/index', $data);
        $this->load->view('layouts/footer');
    }
}
