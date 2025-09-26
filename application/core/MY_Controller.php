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

    /**
     * Valida se a data informada existe e não está no futuro.
     */
    protected function is_valid_non_future_date(?string $date): bool
    {
        if (empty($date)) {
            return false;
        }

        $dateTime = DateTime::createFromFormat('Y-m-d', $date);

        if (!$dateTime || $dateTime->format('Y-m-d') !== $date) {
            return false;
        }

        $today = new DateTime('today');
        $dateTime->setTime(0, 0, 0);

        return $dateTime <= $today;
    }
}
