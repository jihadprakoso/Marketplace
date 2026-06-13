<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function register($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->db->insert('users', $data);
    }

    public function login($email, $password) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        $user = $query->row();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }

    public function get_user($id) {
        return $this->db->get_where('users', ['id' => $id])->row();
    }
}
