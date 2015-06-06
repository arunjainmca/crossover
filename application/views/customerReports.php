<script>
	$(document).ready(function() {
    $('#datatable').DataTable();
} );

</script>
<h2>Customer's Test Reports</h2>
        <div class="divider"></div>
        <br/>
        <table>
            <tr>
                <td>Patient Name</td><td><?=$this->session->userdata('username');?></td>
            </tr>
            <tr>
                <td>Age</td><td><?=$this->session->userdata('age');?></td>
            </tr
             <tr>
                <td>Gender</td><td><?=$this->session->userdata('gender');?></td>
            </tr
            <tr>
                <td>Contact Details.</td><td><?=$this->session->userdata('mobile'),",  ".$this->session->userdata('email');?></td>
            </tr>
        </table>
        </br>
	<?php
	echo "<table id='datatable' class='display' cellspacing='0' width='100%'>";
	$head="<thead>
        <tr>
            <th>Request ID</th>
            <th>Request Date</th>
            <th>status</th>
            <th>Actions</th>
        </tr>
    </thead>";
	$foot="<tfoot>
        <tr>
           <th>Request ID</th>
            <th>Request Date</th>
            <th>status</th>
            <th>Actions</th>
        </tr>
    </tfoot>";
	echo $head;
	echo $foot;
	echo "<tbody>";
    
 foreach($result as $k=>$v)
 {
 	echo "<tr>";
	echo "<td>";
 	 echo $v['id'];
	 echo "</td><td>";
	 echo date('m-d-Y H:i:s',strtotime($v['created']));
         echo "</td><td>";
	 echo $v['status'];
	 echo "</td><td>";
	 //echo "<a href='".base_url().'index.php/home/editstudent'.'/'.$v['id']."'>Edit</a>&nbsp;&nbsp;<a href='".base_url('index.php/home/deletestudent').'/'.$v['id']."'>Delete</a>";
         echo "<a href='".base_url().'index.php/site/viewReport/'.$v['id'].'/'.$this->session->userdata('user_id')."'>View Complete Report</a>";
	 echo "</tr>";
 }
 echo "</tbody>";
 echo "</table>";
?>
