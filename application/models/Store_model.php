<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_model extends CI_Model {

    public function get_store_by_user($user_id) {
        return $this->db->get_where('stores', ['user_id' => $user_id])->row();
    }

    public function save_store($data, $user_id) {
        $existing = $this->get_store_by_user($user_id);
        if ($existing) {
            $this->db->where('id', $existing->id);
            return $this->db->update('stores', $data);
        } else {
            $data['user_id'] = $user_id;
            return $this->db->insert('stores', $data);
        }
    }
}
