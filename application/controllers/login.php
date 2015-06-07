<?php

class Login extends CI_Controller {

    function index() {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (isset($is_logged_in) && $is_logged_in) {
            redirect(base_url() . 'site/home');
        }
        $this->session->sess_destroy();
        if (isset($this->data['error'])) {
            $data = $this->data;
        }
        $data['main_content'] = 'login/login_form';
        $this->load->view('layouts/default', $data);
    }

    function authenticate_user() {
        //print_r($_POST);exit;
        $this->load->model('UserModel');
        $query = $this->UserModel->validate();
        if ($query) {
            redirect('site/home');
        } else {
            $this->data['error'] = "Wrong Credentials! Please Try again.";
            $this->index();
        }
    }

    public function getUsers() {
        if (!isset($_GET['term']) || !isset($_GET['searchBy']))
            exit;
        $searchBy = 'aadhar';
        if ($_GET['searchBy'] == 'mobile') {
            $searchBy = 'mobile';
        } elseif ($_GET['searchBy'] == 'vehicle_no') {
            $searchBy = 'vehicle_no';
        } else {
            exit;
        }
        $keyword = $_REQUEST['term'];
        $data = array();
        $this->load->model('UserModel');
        $rows = $this->UserModel->getUser($keyword, $searchBy);
        foreach ($rows as $row) {
            $data[] = array(
                'label' => $row->first_name . ' ' . $row->last_name . "[ " . $row->mobile . "]",
                'all' => $row
            );
        }
        echo json_encode($data);
        flush();
    }

    public function get_otp() {
        if (!isset($_GET['username']) || !isset($_GET['user_type'])) {
            echo("We have not receievd proper inputs.");
            exit();
        }
        // Check Data value with regular Expression here
        if ($_GET['username'] == "" || $_GET['user_type'] != "PAT") {
            echo("We have  receievd invalid inputs.");
            exit();
        }
        $this->load->model('UserModel');
        $data = $this->UserModel->sendPasscode($_GET['username']);
        echo($data);
        flush();
    }

    function logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'login/index/');
    }

}
