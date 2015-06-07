<?php

class User_model extends CI_Model {

    function validate() {
        $this->db->where('username', $this->input->post('username'));
        $this->db->or_where('aadhar_id', $this->input->post('username'));
        $this->db->where('password', md5($this->input->post('password')));
        $query = $this->db->get('users');
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            $data = array(
                'username' => $res['first_name'] . " " . $res['last_name'],
                'aadhar_id' => $res['aadhar_id'],
                'loginname' => $res['username'],
                'user_id' => $res['id'],
                'gender' => $res['gender'],
                'mobile' => $res['mobile'],
                'email' => $res['email'],
                'address' => $res['address'],
                'dob' => empty($res['dob']) ? '' : date('d-m-Y', strtotime($res['dob'])),
                'city' => $res['city'],
                'state' => $res['state'],
                'pincode' => $res['pincode'],
                'is_logged_in' => TRUE,
                'user_type' => $res['user_type']
            );
            $this->session->set_userdata($data);
            return true;
        } else {
            return false;
        }
    }

    function create_user() {
        $this->db->where('mobile', $this->input->post('mobile'));
        $result = $this->db->select('id')->get('users')->result_array();
        $new_member_insert_data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'gender' => $this->input->post('gender'),
            'age' => $this->input->post('age'),
            'user_type' => 'patient',
            'created' => date('Y-m-d H:i:s')
        );
        $userid = '';
        if (count($result) > 0) {
            $this->db->where('id', $result[0]["id"]);
            $this->db->update('users', $new_member_insert_data);
            $userid = $result[0]["id"];
        } else {
            $new_member_insert_data['mobile'] = $this->input->post('mobile');
            $new_member_insert_data['username'] = $this->input->post('mobile');
            $this->db->insert('users', $new_member_insert_data);
            $userid = $this->db->insert_id();
        }
        return $userid;
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

    function add_dl() {
        $flag = true;
        $dl_doc_type_id = 4;
        $form_fields = $this->input->post('form_field');

        foreach ($form_fields as $field_id => $value) {
            $dl_data = array('user_id' => $this->session->userdata('user_id'),
                'doc_type_id' => $dl_doc_type_id,
                'doc_type_field_id' => $field_id,
                'value' => $value,
                'created' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_id'));
            if (!$this->db->insert('user_dl_details', $dl_data)) {
                $flag = false;
            }
        }
        return $flag;
    }

    function edit_dl() {
        $flag = true;
        $form_fields = $this->input->post('form_field');
        //print_r($form_fields); exit;
        foreach ($form_fields as $field_id => $value) {
            $dl_data = array('value' => $value,
                'updated' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user_id'));
            $this->db->where(array('user_id' => $this->session->userdata('user_id'), 'doc_type_field_id' => $field_id));
            if (!$this->db->update("user_dl_details", $dl_data)) {
                $flag = false;
            }
        }
        return $flag;
    }

}
