<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    public function get_products_by_store($store_id) {
        return $this->db->get_where('products', ['store_id' => $store_id])->result();
    }

    public function get_product($id) {
        return $this->db->get_where('products', ['id' => $id])->row();
    }

    /**
     * Detail produk beserta informasi tokonya (dipakai halaman detail produk).
     */
    public function get_product_detail($id) {
        $this->db->select('products.*, stores.store_name, stores.description as store_description, stores.created_at as store_created_at');
        $this->db->from('products');
        $this->db->join('stores', 'stores.id = products.store_id');
        $this->db->where('products.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Produk lain dari toko yang sama (rekomendasi di halaman detail).
     */
    public function get_related_products($store_id, $exclude_id, $limit = 4) {
        $this->db->select('products.*, stores.store_name');
        $this->db->from('products');
        $this->db->join('stores', 'stores.id = products.store_id');
        $this->db->where('products.store_id', $store_id);
        $this->db->where('products.id !=', $exclude_id);
        $this->db->order_by('products.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    /**
     * Pencarian produk berdasarkan nama produk, deskripsi, atau nama toko.
     */
    public function search_products($keyword) {
        $this->db->select('products.*, stores.store_name');
        $this->db->from('products');
        $this->db->join('stores', 'stores.id = products.store_id');
        $this->db->group_start();
        $this->db->like('products.name', $keyword);
        $this->db->or_like('products.description', $keyword);
        $this->db->or_like('stores.store_name', $keyword);
        $this->db->group_end();
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get()->result();
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
