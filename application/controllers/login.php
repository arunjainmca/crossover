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
        $this->load->model('user_model');
        $query = $this->user_model->validate();
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
        if (!isset($_GET['aadharno']) || !isset($_GET['aadharno']) || !($_GET['aadharno'] > 0)) {
            echo("We have not receievd proper inputs.");
            exit();
        }
        $res = $this->db->query('select * from users where aadhar_id=' . $_GET['aadharno'])->result_array();
        if (count($res) > 0) {
            echo("This Aadhar No. is already registered");
            return;
        }
        $this->load->library('aadharapi');
        $resp = $this->aadharapi->GenerateAadharOtp($_GET['aadharno'], "121003");
        if ($resp == 1) {
            echo("Otp is send to your registered mobile no.");
        } else {
            echo("Mobile No. not registered / Invalid Aadhar no.");
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'login/index/');
    }

    function signup() {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (isset($is_logged_in) && $is_logged_in) {
            redirect(base_url() . 'site/home');
        }
        $this->session->sess_destroy();
        if (isset($this->data['error'])) {
            $data = $this->data;
        }
        $data['signuperror'] = "";
        if ($this->input->post('aadharno')) {
            if (!($this->input->post('aadharno') > 0)) {
                $data['signuperror'] = "invalid Aadhar Number. Please try again";
            } elseif (!($this->input->post('otp') > 0)) {
                $data['signuperror'] = "invalid Otp. Please try again";
            } elseif (($this->input->post('password') == "")) {
                $data['signuperror'] = "Please enter password.";
            }
            if ($data['signuperror'] == "") {
                $this->load->library('aadharapi');
                $resp = $this->aadharapi->AuthUidWithOtp($this->input->post('aadharno'), "121003", $this->input->post('otp'));
                if ($resp['success']) {
                    $data = array(
                        'aadhar_id' => $this->input->post('aadharno'),
                        'password' => md5($this->input->post('password')),
                        'first_name' => $resp['kyc']['poi']['name'],
                        'gender' => $resp['kyc']['poi']['gender'],
                        'address' => $resp['kyc']['poa']['co'] . " " . $resp['kyc']['poa']['street'] . " " . $resp['kyc']['poa']['dist'],
                        'dob' => date('Y-m-d', strtotime($resp['kyc']['poi']['dob'])),
                        'city' => $resp['kyc']['poa']['po'],
                        'state' => $resp['kyc']['poa']['state'],
                        'pincode' => $resp['kyc']['poa']['pc'],
                        'user_type' => "user");
                    $this->db->insert('users', $data);
                    $data['signupsuccess'] = "You are signup successfully with Uid " . $this->input->post('aadharno');
                }
            }
        }
        $data['main_content'] = 'login/signup_form';
        $this->load->view('layouts/default', $data);
    }

}
