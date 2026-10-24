<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('user_role') !== 'admin') {
            $this->session->set_flashdata('error', 'Access denied. Administrator privileges required.');
            redirect('auth/login');
        }
        $this->load->model('Order_model');
        $this->load->model('Product_model');
        $this->load->model('Store_model');
        $this->load->model('User_model');
    }

    public function index() {
        $data['title'] = 'Admin Overview';

        // 1. Overall Statistics
        $data['total_users'] = $this->db->count_all('users');
        $data['total_stores'] = $this->db->count_all('stores');
        $data['total_products'] = $this->db->count_all('products');
        $data['total_orders'] = $this->db->count_all('orders');

        $rev_query = $this->db->select_sum('total_amount')->get('orders')->row();
        $data['total_revenue'] = $rev_query->total_amount ?? 0;

        // 2. Recent Orders (with Buyer name)
        $this->db->select('orders.*, users.name as buyer_name, users.email as buyer_email');
        $this->db->from('orders');
        $this->db->join('users', 'users.id = orders.buyer_id');
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit(5);
        $data['recent_orders'] = $this->db->get()->result();

        // 3. Registered Stores (with Owner name & Product Count)
        $this->db->select('stores.*, users.name as owner_name, users.email as owner_email, COUNT(products.id) as product_count');
        $this->db->from('stores');
        $this->db->join('users', 'users.id = stores.user_id');
        $this->db->join('products', 'products.store_id = stores.id', 'left');
        $this->db->group_by('stores.id');
        $this->db->order_by('stores.created_at', 'DESC');
        $data['stores'] = $this->db->get()->result();

        // 4. Recent Users
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(6);
        $data['recent_users'] = $this->db->get('users')->result();

        // 5. Status pesanan yang bisa dipilih admin
        $data['statuses'] = $this->Order_model->allowed_statuses();

        $this->load->view('layouts/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('layouts/footer');
    }

    /**
     * Admin mengubah status pesanan mana pun.
     */
    public function update_order_status($order_id) {
        if (!$this->input->post()) {
            redirect('admin');
        }

        $status = (string) $this->input->post('status');

        if ($this->Order_model->update_status($order_id, $status)) {
            $this->session->set_flashdata('success', 'Status pesanan #' . str_pad($order_id, 5, '0', STR_PAD_LEFT) . ' diubah menjadi ' . $status . '.');
        } else {
            $this->session->set_flashdata('error', 'Status pesanan tidak valid.');
        }

        redirect('admin');
    }
}
