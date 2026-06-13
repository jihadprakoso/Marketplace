<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login() {
        if ($this->session->userdata('user_id')) {
            redirect('');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() === TRUE) {
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                
                $user = $this->User_model->login($email, $password);
                
                if ($user) {
                    $userdata = array(
                        'user_id'   => $user->id,
                        'user_name' => $user->name,
                        'user_role' => $user->role,
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($userdata);
                    
                    $this->session->set_flashdata('success', 'Welcome back, ' . $user->name);
                    
                    if ($user->role === 'admin') redirect('admin');
                    else if ($user->role === 'seller') redirect('seller');
                    else redirect('');
                } else {
                    $this->session->set_flashdata('error', 'Invalid email or password');
                }
            }
        }

        $data['title'] = 'Login';
        $this->load->view('layouts/header', $data);
        $this->load->view('auth/login');
        $this->load->view('layouts/footer');
    }

    public function register() {
        if ($this->session->userdata('user_id')) {
            redirect('');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]', [
                'is_unique' => 'This email is already registered.'
            ]);
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('role', 'Role', 'required|in_list[seller,buyer]');

            if ($this->form_validation->run() === TRUE) {
                $data = [
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                    'role' => $this->input->post('role')
                ];

                if ($this->User_model->register($data)) {
                    $this->session->set_flashdata('success', 'Registration successful. You can now login.');
                    redirect('auth/login');
                } else {
                    $this->session->set_flashdata('error', 'Registration failed. Please try again.');
                }
            }
        }

        $data['title'] = 'Register';
        $this->load->view('layouts/header', $data);
        $this->load->view('auth/register');
        $this->load->view('layouts/footer');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
