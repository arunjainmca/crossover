<?php

class Vehicle_model extends CI_Model {

    function __construct() {
        //parent::__construct();
    }

    function add_vehicle() {
        $vehicle_data = array(
            'user_id' => $this->session->userdata('user_id'),
            'vehicle_name' => $this->input->post('vehicle_name'),
            'vehicle_number' => $this->input->post('vehicle_number'),
            'make' => $this->input->post('make'),
            'model' => $this->input->post('model'),
            'year' => $this->input->post('year'),
            'color' => $this->input->post('color'),
            'ins_policy_no' => $this->input->post('ins_policy_no'),
            'status' => 1,
            'created' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id')
        );
        $this->db->insert('vehicles', $vehicle_data);
        $vehicle_id = $this->db->insert_id();
        return $vehicle_id;
    }

    function get_vehicles($user_id) {
        $this->db->from('vehicles');
        $this->db->where('user_id', $user_id);
        $user_vehicles = $this->db->get()->result_array();
        return $user_vehicles;
    }

    function get_vehicles_aadhar($aadhar_id) {
        $user_vehicles = $this->db->query('select v.* from vehicles as v inner join users as u on v.user_id=u.id where u.aadhar_id="' . $aadhar_id . '"');
        $user_vehicles = $user_vehicles->result_array();
        return $user_vehicles;
    }

    function getUser($word, $field = 'first_name') {
        $sql = $this->db->query('select email,username,first_name,last_name,mobile,gender,age from users where user_type="patient" AND '
                . $field . ' like "' . mysql_real_escape_string($word) . '%" order by first_name asc limit 0,10');
        return $sql->result();
    }

    function sendPasscode($username) {
        $this->db->where('username', $username);
        $this->db->where('user_type', 'patient');
        $query = $this->db->get('users');
        $msg = "";
        if ($query->num_rows == 1) {
            $code = rand(111111, 999999);
            $this->db->where('username', $username);
            $this->db->update("users", array('password' => md5($code)));
            $msg = "A six digit passcode is sent to your registered Mobile Number\nFor testing your pass code is " . $code;
            // We will use Aadhar OTP API HERE
        }
        return $msg;
    }

    function add_policy() {
        $flag = true;
        $vehicle_id = $this->input->post('vehicle_id');
        $doc_type_id = $this->input->post('doc_type_id');
        $form_fields = $this->input->post('form_field');
        foreach ($form_fields as $field_id => $value) {
            $data = array();
            $data = array('user_id' => $this->session->userdata('user_id'),
                'vehicle_id' => $vehicle_id,
                'doc_type_id' => $doc_type_id,
                'doc_type_field_id' => $field_id,
                'value' => $value,
                'created' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_id'));
            if (!$this->db->insert('vehicle_details', $data)) {
                $flag = false;
            }
        }
        return $flag;
    }

}
