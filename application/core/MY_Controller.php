<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $allowed_levels = ['1', '2', '3'];
        $logged_in = $this->session->userdata('logged_in');
        $level = $this->session->userdata('level');
        if (!$logged_in || !in_array($level, $allowed_levels)) {
            redirect('auth/login');
        }
    }
}
