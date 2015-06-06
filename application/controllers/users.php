<?php

class Users extends CI_Controller {

    function _construct() {
        parent::CI_Controller();
        $this->is_logged_in();
    }

    function home() {
        $this->is_logged_in();
        $data['main_content'] = 'site/home';
        $this->load->view('layouts/default', $data);
    }

    function is_logged_in() {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
            echo "Session out/You don't have permission to access this page. <a href='../login'>Login</a>";
            exit;
        }
    }

    function view_profile($aadhar_id) {
        if (!empty($aadhar_id)) {
            $data['main_content'] = 'users/profile';
            $this->load->view('layouts/default', $data);
        }
    }

    function profile() {
        $this->is_logged_in();
        $data['main_content'] = 'users/profile';
        $this->load->view('layouts/default', $data);
    }

}
