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
        $data['title'] = 'All Products';
        $data['products'] = $this->Product_model->get_all_products();
        
        $this->load->view('layouts/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('layouts/footer');
    }
}
