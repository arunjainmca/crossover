<?php

class Login extends CI_Controller {

    function index() {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (isset($is_logged_in) && $is_logged_in) {
            redirect(base_url() . 'site/homepage');
        }
        $this->session->sess_destroy();
        if (isset($this->data['error'])) {
            $data = $this->data;
        }
        $data['main_content'] = 'login_form';
        $this->load->view('includes/template', $data);
    }

    function authenticate_user() {
        //print_r($_POST);exit;
        $this->load->model('users');
        $query = $this->users->validate();
        if ($query) {
            redirect('site/homepage');
        } else {
            $this->data['error'] = "Wrong Credentials! Please Try again.";
            $this->index();
        }
    }

    public function getPatients() {
        if (!isset($_GET['term']) || !isset($_GET['searchBy']))
            exit;
        $searchBy = 'name';
        if ($_GET['searchBy'] == 'mobile') {
            $searchBy = 'mobile';
        } elseif ($_GET['searchBy'] == 'name') {
            $searchBy = 'first_name';
        } else {
            exit;
        }
        $keyword = $_REQUEST['term'];
        $data = array();
        $this->load->model('users');
        $rows = $this->users->getUser($keyword, $searchBy);
        foreach ($rows as $row) {
            $data[] = array(
                'label' => $row->first_name . ' ' . $row->last_name . "[ " . $row->mobile . "]",
                'all' => $row
            );
        }
        echo json_encode($data);
        flush();
    }

    public function getPasscode() {
        if (!isset($_GET['username']) || !isset($_GET['usertype'])) {
            echo("We have not receievd proper inputs.");
            exit();
        }
        // Check Data value with regular Expression here
        if ($_GET['username'] == "" || $_GET['usertype'] != "PAT") {
            echo("We have  receievd invalid inputs.");
            exit();
        }
        $this->load->model('users');
        $data = $this->users->sendPasscode($_GET['username']);
        echo($data);
        flush();
    }

    function logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'login/index/');
    }

}
