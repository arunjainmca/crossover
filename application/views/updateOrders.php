<script>
	$(document).ready(function() {
    $('#datatable').DataTable();
} );

</script>
<h2>Customer's Test Reports</h2>
        <div class="divider"></div>
        
         
        </table>
	<?php
        if(isset($deletestatus) && !empty($deletestatus)){
            echo($deletestatus);
        }
        
        echo "<table id='datatable' class='display' cellspacing='0' width='100%'>";
	$head="<thead>
        <tr>
            <th>Request ID</th>
            <th>Request Date</th>
            <th>Patient Name</th>
            <th>Tests Details</th>
            <th>Resport Status</th>
            <th>Actions</th>
        </tr>
    </thead>";
	$foot="<tfoot>
        <tr>
           <th>Request ID</th>
            <th>Request Date</th>
            <th>Patient Name</th>
            <th>Tests Details</th>
            <th>Resport Status</th>
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
 	 echo $v['order_id'];
	 echo "</td><td>";
	 echo date('m-d-Y H:i:s',strtotime($v['created']));
         echo "</td><td>";
	 echo $v['patient_name'];
	 echo "</td><td>";
         echo $v['test_details'];
	 echo "</td><td>";
         echo $v['status'];
	 echo "</td><td>";
         echo "<a href='".base_url().'index.php/site/UpdateTests/'.$v['order_id'].'/'.$v['user_id']."'>Edit</a>";
         echo "&nbsp;<a href='".base_url().'index.php/site/deleteOrder'.'/'.$v['order_id']."'>Delete</a>";
         echo "&nbsp;<a href='".base_url().'index.php/site/viewReport/'.$v['order_id'].'/'.$v['user_id']."'>View</a>";
         echo "<td>";
	 echo "</tr>";
 }
 echo "</tbody>";
 echo "</table>";
?>
