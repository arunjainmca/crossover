<?php

class Vehicles extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->is_logged_in();
        $this->load->model('VehicleModel');
    }

    function is_logged_in() {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
            echo "Session out/You don't have permission to access this page. <a href='../login'>Login</a>";
            exit;
        }
    }

    function index() {
        $data['main_content'] = 'vehicles/index';
        $vehicles = $this->VehicleModel->get_vehicles($this->session->userdata('user_id'));
        $data['vehicles'] = $vehicles;
        $this->load->view('layouts/default', $data);
    }

    function add() {
        $this->is_logged_in();
        if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('vehicle_name', 'Vehicle Name', 'trim|required');
            $this->form_validation->set_rules('vehicle_number', 'Vehicle Number', 'trim|required');
            $this->form_validation->set_rules('make', 'Vehicle Make', 'trim|required');
            $this->form_validation->set_rules('model', 'Vehicle Model', 'trim|required');
            $this->form_validation->set_rules('year', 'Vehicle Manufacuring Year', 'trim|required');
            $this->form_validation->set_rules('ins_policy_no', 'Insurance Policy Number', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                //Throw an exception here
                $data['main_content'] = 'vehicles/add';
                $this->load->view('layouts/default', $data);
            } else {

                $this->load->model('VehicleModel');
                $vehicle_id = $this->VehicleModel->add_vehicle();
                if ($vehicle_id) {
                    redirect(base_url() . 'vehicles/index');
                } else {
                    redirect(base_url() . 'vehicles/add');
                }
            }
        } else {
            $data['main_content'] = 'vehicles/add';
            $this->load->view('layouts/default', $data);
        }
    }

    function view() {
        $data['main_content'] = 'vehicles/view';
        $this->load->view('layouts/default', $data);
    }

}
