<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_role') !== 'seller') {
            $this->session->set_flashdata('error', 'Access denied. You must be a seller.');
            redirect('');
        }
        $this->load->model('Store_model');
        $this->load->model('Product_model');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $store = $this->Store_model->get_store_by_user($user_id);

        $data['title'] = 'Seller Dashboard';
        $data['store'] = $store;
        
        if ($store) {
            $data['products'] = $this->Product_model->get_products_by_store($store->id);
            $this->load->view('layouts/header', $data);
            $this->load->view('seller/dashboard', $data);
        } else {
            // Need to setup store first
            $this->load->view('layouts/header', $data);
            $this->load->view('seller/store_form', $data);
        }
        $this->load->view('layouts/footer');
    }

    public function save_store() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('store_name', 'Store Name', 'required');

            if ($this->form_validation->run() === TRUE) {
                $data = [
                    'store_name' => $this->input->post('store_name'),
                    'description' => $this->input->post('description')
                ];
                $this->Store_model->save_store($data, $this->session->userdata('user_id'));
                $this->session->set_flashdata('success', 'Store configuration saved.');
                redirect('seller');
            }
        }
        redirect('seller');
    }

    public function product_form($id = null) {
        $store = $this->Store_model->get_store_by_user($this->session->userdata('user_id'));
        if (!$store) redirect('seller');

        $data['title'] = $id ? 'Edit Product' : 'Add Product';
        $data['product'] = $id ? $this->Product_model->get_product($id) : null;

        // Ensure user owns product
        if ($id && $data['product']->store_id != $store->id) {
            $this->session->set_flashdata('error', 'Unauthorized access.');
            redirect('seller');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Product Name', 'required');
            $this->form_validation->set_rules('price', 'Price', 'required|numeric');
            $this->form_validation->set_rules('stock', 'Stock', 'required|numeric');

            if ($this->form_validation->run() === TRUE) {
                $product_data = [
                    'store_id' => $store->id,
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'price' => $this->input->post('price'),
                    'stock' => $this->input->post('stock')
                ];

                // Handle Image Upload
                if (!empty($_FILES['image']['name'])) {
                    $config['upload_path'] = './assets/uploads/products/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = 2048;
                    $config['file_name'] = time() . '_' . $_FILES['image']['name'];

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('image')) {
                        $upload_data = $this->upload->data();
                        $product_data['image'] = $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        redirect('seller/product_form/' . $id);
                    }
                }

                if ($id) {
                    $this->Product_model->update_product($id, $product_data);
                    $this->session->set_flashdata('success', 'Product updated successfully.');
                } else {
                    $this->Product_model->add_product($product_data);
                    $this->session->set_flashdata('success', 'Product added successfully.');
                }
                redirect('seller');
            }
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('seller/product_form', $data);
        $this->load->view('layouts/footer');
    }

    public function delete_product($id) {
        $store = $this->Store_model->get_store_by_user($this->session->userdata('user_id'));
        if ($store) {
            $this->Product_model->delete_product($id, $store->id);
            $this->session->set_flashdata('success', 'Product deleted.');
        }
        redirect('seller');
    }
}
