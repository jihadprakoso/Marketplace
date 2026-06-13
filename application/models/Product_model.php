<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    public function get_products_by_store($store_id) {
        return $this->db->get_where('products', ['store_id' => $store_id])->result();
    }

    public function get_product($id) {
        return $this->db->get_where('products', ['id' => $id])->row();
    }

    public function add_product($data) {
        return $this->db->insert('products', $data);
    }

    public function update_product($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }

    public function delete_product($id, $store_id) {
        $this->db->where('id', $id);
        $this->db->where('store_id', $store_id); // Security measure
        return $this->db->delete('products');
    }

    public function get_all_products() {
        $this->db->select('products.*, stores.store_name');
        $this->db->from('products');
        $this->db->join('stores', 'stores.id = products.store_id');
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get()->result();
    }
}
