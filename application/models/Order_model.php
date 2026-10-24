<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function create_order($buyer_id, $total_amount, $cart_items) {
        $this->db->trans_start();

        // 1. Insert Order
        $order_data = [
            'buyer_id' => $buyer_id,
            'total_amount' => $total_amount,
            'status' => 'paid' // Auto paid for demo
        ];
        $this->db->insert('orders', $order_data);
        $order_id = $this->db->insert_id();

        // 2. Insert Order Items & Deduct Stock
        foreach ($cart_items as $item) {
            $item_data = [
                'order_id' => $order_id,
                'product_id' => $item['id'],
                'quantity' => $item['qty'],
                'price' => $item['price']
            ];
            $this->db->insert('order_items', $item_data);

            // Deduct stock
            $this->db->set('stock', 'stock - ' . (int)$item['qty'], FALSE);
            $this->db->where('id', $item['id']);
            $this->db->update('products');
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function get_buyer_orders($buyer_id) {
        $this->db->where('buyer_id', $buyer_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('orders')->result();
    }

    public function get_order($order_id) {
        return $this->db->get_where('orders', ['id' => $order_id])->row();
    }

    /**
     * Daftar status pesanan yang diizinkan (mengikuti ENUM kolom orders.status).
     */
    public function allowed_statuses() {
        return ['pending', 'paid', 'shipped', 'completed', 'cancelled'];
    }

    /**
     * Ubah status pesanan. Mengembalikan FALSE bila status tidak dikenal.
     */
    public function update_status($order_id, $status) {
        if (!in_array($status, $this->allowed_statuses(), TRUE)) {
            return FALSE;
        }

        $this->db->where('id', $order_id);
        return $this->db->update('orders', ['status' => $status]);
    }

    /**
     * Pastikan pesanan memuat minimal satu produk milik toko tertentu.
     * Dipakai sebagai pengecekan kepemilikan sebelum seller mengubah status.
     */
    public function order_belongs_to_store($order_id, $store_id) {
        $this->db->select('order_items.id');
        $this->db->from('order_items');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->where('order_items.order_id', $order_id);
        $this->db->where('products.store_id', $store_id);
        return $this->db->count_all_results() > 0;
    }

    public function get_order_items($order_id) {
        $this->db->select('order_items.*, products.name');
        $this->db->from('order_items');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->where('order_id', $order_id);
        return $this->db->get()->result();
    }

    public function get_seller_orders($store_id) {
        $this->db->select('order_items.*, products.name as product_name, products.image as product_image, orders.status, orders.created_at, users.name as buyer_name, users.email as buyer_email');
        $this->db->from('order_items');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->join('orders', 'orders.id = order_items.order_id');
        $this->db->join('users', 'users.id = orders.buyer_id');
        $this->db->where('products.store_id', $store_id);
        $this->db->order_by('orders.created_at', 'DESC');
        return $this->db->get()->result();
    }
}
