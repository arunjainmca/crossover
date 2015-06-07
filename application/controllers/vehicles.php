<?php

class Vehicles extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->is_logged_in();
        $this->load->model('vehicle_model');
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
        $vehicles = $this->vehicle_model->get_vehicles($this->session->userdata('user_id'));
        $data['vehicles'] = $vehicles;
        $this->load->view('layouts/default', $data);
    }

    function search() {
        $data['main_content'] = 'vehicles/search';
        if ($this->session->userdata('user_type') == 'user') {
            redirect(base_url() . 'users/profile');
        }
        $vehicles = array();
        if ($this->input->post('search')) {
            $vehicles = $this->vehicle_model->get_vehicles_aadhar($this->input->post('aadharSearch'));
        }
        $data['vehicles'] = $vehicles;
        $this->load->view('layouts/default', $data);
    }

    function updateStatus() {


        $this->db->where('vehicle_number', $_POST['vnum']);
        if (!$this->db->update("vehicles", array('status' => $_POST['status']))) {
            echo "not done";
        } else {
            echo 'done';
        }
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

                $this->load->model('vehicle_model');
                $vehicle_id = $this->vehicle_model->add_vehicle();
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

    function view($vehicle_id) {
        if (!empty($vehicle_id)) {
            $vehicle_details = $this->db->get_where('vehicles', array('id' => $vehicle_id, 'user_id' => $this->session->userdata('user_id')))->row_array();
            if (!empty($vehicle_details)) {
                $doc_details = array();

                $data['vehicle_details'] = $vehicle_details;
                $doc_types = $this->db->get_where('doc_types', array('doc_status' => 1, 'id <> ' => 4))->result_array();
                foreach ($doc_types as $doc_type) {
                    $f_details = $this->db->query('SELECT vd.*, dtf.field_name FROM vehicle_details vd 
            LEFT JOIN doc_type_fields dtf ON dtf.id = vd.doc_type_field_id
            WHERE user_id = ' . $this->session->userdata('user_id') . ' AND vd.doc_type_id = ' . $doc_type['id'])->result_array();
                    $doc_details[$doc_type['id']] = $f_details;
                }
                $data['doc_types'] = $doc_types;
                $data['doc_details'] = $doc_details;
//                echo '<pre>';
//                print_r($data);
//                die;
                $data['main_content'] = 'vehicles/view';
                $this->load->view('layouts/default', $data);
            } else {
                echo 'Vehicle Details not found.';
                exit;
            }
        } else {
            echo 'Invalid Request. Please Try Again.';
            exit;
        }
    }

    function add_policy($vehicle_id, $doc_type_id) {
        if ($this->input->post('submit')) {
            $this->load->model('vehicle_model');
            if ($this->vehicle_model->add_policy()) {
                redirect(base_url() . 'vehicles/view/' . $vehicle_id);
            } else {
                redirect(base_url() . 'vehicles/add_policy/' . $vehicle_id . '/' . $doc_type_id);
            }
        } else {
            $data['vehicle_id'] = $vehicle_id;
            $data['doc_type'] = $this->db->get_where('doc_types', array('id' => $doc_type_id))->row_array();
            $form_fields = $this->db->order_by('sort_order', 'ASC')->get_where('doc_type_fields', array('doc_type_id' => $doc_type_id, 'status' => 1))->result_array();
            $data['form_fields'] = $form_fields;
            $data['main_content'] = 'vehicles/add_policy';
            $this->load->view('layouts/default', $data);
        }
    }

}
