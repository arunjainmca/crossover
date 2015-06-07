<?php

class Users extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->is_logged_in();
    }

    function home() {
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
        } else {
            echo 'Please provide Aadhar Number';
            exit;
        }
    }

    function profile() {
        //Driving License Details
        //doc_type_id = 4 for Driving License
        $dl_details = $this->db->query('SELECT udl.*, dtf.field_name FROM user_dl_details udl 
            LEFT JOIN doc_type_fields dtf ON dtf.id = udl.doc_type_field_id AND dtf.doc_type_id=4
            WHERE user_id = ' . $this->session->userdata('user_id') . ' AND udl.doc_type_id = 4')->result_array();
        $data['dl_details'] = $dl_details;
        $data['main_content'] = 'users/profile';
        $this->load->view('layouts/default', $data);
    }

    function add_dl() {
        if ($this->input->post('submit')) {
            $this->load->model('UserModel');
            if ($this->UserModel->add_dl()) {
                redirect(base_url() . 'users/profile');
            } else {
                redirect(base_url() . 'users/add_dl');
            }
        } else {
            $form_fields = $this->db->order_by('sort_order', 'ASC')->get_where('doc_type_fields', array('doc_type_id' => 4, 'status' => 1))->result_array();
            $data['form_fields'] = $form_fields;
            $data['main_content'] = 'users/add_dl';
            $this->load->view('layouts/default', $data);
        }
    }

}
