<?php

class tests extends CI_Model {
    function getTestList(array $testList=NULL){ 
        if($testList){
            $this->db->where_in('id',$testList);
        }
        $result=$this->db->select('id,test_name,test_cost')->get('tests_master')->result_array();
        $retArr=array();
        foreach($result as $k=>$v){
            $retArr[$v['id']]=$v['test_name']." [Rs. ".$v['test_cost']."]";
        }
        return $retArr;
    }
    
    function createTestsOrder($user_id){
        
        $insert_data = array(
            'customer_id' => $user_id,
            'created' => date('Y-m-d H:i:s')
        );
        $this->db->insert('tests_order', $insert_data);
        $order_id= $this->db->insert_id();
        $Arr=$this->input->post('tests');
        foreach($Arr as $k=>$v){
            $insert_data = array(
                'order_id' => $order_id,
                'tests_id'=>$v,
                'created' => date('Y-m-d H:i:s')
            );
            $this->db->insert('tests_order_particulars', $insert_data);
        }
        return $order_id;
        
    }
    
    function viewTestsReports($user_id){
        $this->db->where('customer_id',$user_id);
        $result=$this->db->select('*')->get('tests_order')->result_array();
        return $result;
    }
    function getcompleteReport($order_id,$user_id,$onlyAvailesTest=FALSE){
        $this->db->where('id',$user_id);
        $userresult=$this->db->select('*')->get('users')->result_array();
        $query="SELECT top.order_id,tm.test_name,tm.test_min_value,tm.test_cost,tm.test_max_value,top.test_result ,
           top.status FROM tests_order_particulars top INNER JOIN `tests_master` tm ON top.tests_id=tm.id 
           WHERE top.order_id=".$order_id;
        if($onlyAvailesTest){
            $query="SELECT tests_id FROM tests_order_particulars  WHERE order_id=".$order_id;
        }
       
        $result=$this->db->query($query)->result_array();
        return array('userdata'=>$userresult[0],'testdata'=>$result);
    }
    function getAllOrders()
    {
        $query="SELECT grouped.order_id, grouped.status,grouped.created,grouped.patient_name,
            GROUP_CONCAT(grouped.test_name) test_details ,grouped.user_id
        FROM (
        SELECT t.id AS order_id,t.status,t.created,CONCAT(users.first_name,' ',users.last_name)AS patient_name,tests_master.test_name 
        ,users.id as user_id FROM tests_order t 
        INNER JOIN `users` ON t.customer_id=users.id 
        INNER JOIN tests_order_particulars top ON t.id=top.order_id
        INNER JOIN tests_master ON top.tests_id=tests_master.id
        WHERE users.user_type='Patient'
        ) grouped GROUP BY order_id";
        $result=$this->db->query($query)->result_array();
        //var_dump($result);
        return $result;
    }
    
    function deleteOrder($order_id){
        $this->db->where('order_id',$order_id);
        $this->db->delete('tests_order_particulars');
        $this->db->where('id',$order_id);
        $this->db->delete('tests_order');
        return "Order Deleted Successfully";
    }
    
}