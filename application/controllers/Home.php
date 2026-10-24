<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function index() {
        $data['title'] = 'Welcome';
        $data['products'] = $this->Product_model->get_all_products();
        
        $this->load->view('layouts/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('layouts/footer');
    }

    public function products() {
        $keyword = trim((string) $this->input->get('q'));

        $data['title'] = $keyword !== '' ? 'Search: ' . $keyword : 'All Products';
        $data['keyword'] = $keyword;
        $data['products'] = $keyword !== ''
            ? $this->Product_model->search_products($keyword)
            : $this->Product_model->get_all_products();

        $this->load->view('layouts/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('layouts/footer');
    }

    public function product($id = null) {
        if ($id === null) {
            redirect('home/products');
        }

        $product = $this->Product_model->get_product_detail($id);
        if (!$product) {
            show_404();
        }

        $data['title'] = $product->name;
        $data['product'] = $product;
        $data['related'] = $this->Product_model->get_related_products($product->store_id, $product->id);

        $this->load->view('layouts/header', $data);
        $this->load->view('home/product', $data);
        $this->load->view('layouts/footer');
    }
}
