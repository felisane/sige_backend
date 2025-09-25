<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    private $users = [
        ['username' => 'felisane', 'password' => 'felisane123', 'level' => '1'],
        ['username' => 'esmeralda', 'password' => 'esmeralda123', 'level' => '2'],
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

        foreach ($this->users as $user) {
            if ($user['username'] === $username && $user['password'] === $password) {
                $this->session->set_userdata([
                    'logged_in' => TRUE,
                    'username'  => $username,
                    'level'     => $user['level'],
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
