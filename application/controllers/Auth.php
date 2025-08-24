<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    private $users = [
        ['username' => 'admin', 'password' => 'admin123', 'level' => '1'],
        ['username' => 'manager', 'password' => 'manager123', 'level' => '2'],
        ['username' => 'user', 'password' => 'user123', 'level' => '3'],
    ];

    public function login()
    {
        $this->load->view('login');
    }

    public function do_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $level    = $this->input->post('level');

        foreach ($this->users as $user) {
            if ($user['username'] === $username && $user['password'] === $password && $user['level'] === $level) {
                $this->session->set_userdata([
                    'logged_in' => TRUE,
                    'username'  => $username,
                    'level'     => $level,
                ]);
                redirect('home');
                return;
            }
        }

        $this->session->set_flashdata('error', 'Credenciais inválidas.');
        redirect('auth/login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
