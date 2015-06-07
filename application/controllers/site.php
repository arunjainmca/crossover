<?php

class Site extends CI_Controller {

    function __construct() {
        parent::__construct();
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

    function testsRequest() {
        $this->is_logged_in();
        $data['main_content'] = 'testsRequest';
        $this->load->model('tests');
        $data['testList'] = $this->tests->getTestList();
        $this->load->view('layouts/default', $data);
    }

    function UpdateTests($order_id, $user_id) {
        $this->is_logged_in();
        $this->load->model('tests');
        $result = $this->tests->getcompleteReport($order_id, $user_id, true);
        $data['result'] = $result;
        $data['testList'] = $this->tests->getTestList();
        $this->session->set_userdata(array('ReportUpdate' => 1, 'order_id' => $order_id, 'user_id' => $user_id));
        $data['mode'] = 'EDIT';
        $data['main_content'] = 'testsRequest';
        $this->load->view('layouts/default', $data);
    }

    function createTestsRequest() {
        $this->is_logged_in();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required|min_length[10]');
        $this->form_validation->set_rules('gender', 'gender', 'trim|required');
        $this->form_validation->set_rules('age', 'age', 'trim|required');
        $this->form_validation->set_rules('tests', 'tests', 'callback_validate_test_list');

        if ($this->form_validation->run() == FALSE) {
            if ($this->session->userdata('ReportUpdate') == 1)
                $this->UpdateTests($this->session->userdata('order_id'), $this->session->userdata('user_id'));
            else
                $this->testsRequest();
        } else {

            if ($user_id) {
                $this->load->model('tests');
                $order_id = $this->tests->createTestsOrder($user_id);
                $data['main_content'] = 'testsRequest_success';
                $data['order_id'] = $order_id;
                $this->load->view('layouts/default', $data);
            } else {
                if ($this->session->userdata('ReportUpdate') == 1) {
                    $this->UpdateTests($this->session->set_userdata('order_id'), $this->session->set_userdata('$user_id'));
                } else {
                    $this->testsRequest();
                }
            }
        }
    }

    function validate_test_list($testList) {
        $this->load->model('tests');
        $tList = $this->tests->getTestList($testList);
        if (count($tList) != count($testList)) {
            $this->form_validation->set_message('validate_test_list', 'Please select %s from list.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function testsRequestupdate() {
        $this->is_logged_in();
        $data['main_content'] = 'signup_form';
        $this->load->view('layouts/default', $data);
    }

    function viewTestsReports() {
        $this->is_logged_in();
        $this->load->model('tests');
        $result = $this->tests->viewTestsReports($this->session->userdata('user_id'));
        $data['result'] = $result;
        $data['main_content'] = 'customerReports';
        $this->load->view('layouts/default', $data);
    }

    function viewReport($order_id, $user_id) {
        $this->is_logged_in();
        $this->load->model('tests');
        $result = $this->tests->getcompleteReport($order_id, $user_id);
        $data['result'] = $result;
        $data['main_content'] = 'detailedReport';
        $this->load->view('layouts/default', $data);
    }

    function getOrders() {
        $this->is_logged_in();
        $this->load->model('tests');
        $result = $this->tests->getAllOrders();
        $data['result'] = $result;
        $data['main_content'] = 'updateOrders';
        $this->load->view('layouts/default', $data);
    }

    function deleteOrder($order_id) {
        $this->is_logged_in();
        $this->load->model('tests');
        $data['deletestatus'] = $this->tests->deleteOrder($order_id);
        $result = $this->tests->getAllOrders();
        $data['result'] = $result;
        $data['main_content'] = 'updateOrders';
        $this->load->view('layouts/default', $data);
    }

}
