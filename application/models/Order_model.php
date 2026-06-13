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

    public function get_order_items($order_id) {
        $this->db->select('order_items.*, products.name');
        $this->db->from('order_items');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->where('order_id', $order_id);
        return $this->db->get()->result();
    }
}
