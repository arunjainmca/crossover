<script>
    $(document).ready(function () {
	$('#datatable').DataTable();
	});
	function showhidefunc(tthis){
	$(tthis).parents(".editFunCon").hide()
	$(tthis).parents(".editAllFunct").find('.editCon').show();
	}
	function cancelhidefunc(tthis){
	$(tthis).parents(".editCon").hide()
	$(tthis).parents(".editAllFunct").find('.editFunCon').show();
	}
	function editStatusFunc(vid,vnum){
		var vid_select = $( "#editStatus_"+vid+" option:selected" ).val();
		var array_select = [];
		array_select[1] = "Active"
		array_select[2] = "In Active"
		array_select[3] = "Pending for Approval"
		array_select[4] = "Rejected"
		 $.ajax({
			type: 'post',
			cache: false,
			url: 'updateStatus',
			dataType: 'html',
			data: {'status':vid_select,'vnum':vnum,},
			success: function (html) {
			if(html == "done"){
				$('.status_'+vid).html(array_select[vid_select]);
				$('.editCon').hide();
				$('.editFunCon').show();
				}
			},	
			complete: function () {
				
	
			}			
		});		
	
	
	
	}
</script>
<h2>Search Vehicles List</h2>
<div class="divider"></div>
<br/>

<?php
$aadhar_number = isset($_POST['aadharSearch']) ? $_POST['aadharSearch'] : '';

?>
<form name="searchByAadhar" method="post" action="search">
<h1>Search By Aadhar Number</h1><input type="text" name="aadharSearch" value="<?php echo $aadhar_number; ?>"/>
<input type="submit" value="Search"  name="search">
</form>
<br/>
<table id="datatable" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Vehicle Name</th>
            <th>Vehicle No.</th>
            <th>Make/Model/Year</th>
            <th>Insurance Policy No.</th>
            <th>Added On</th>
            <th>Last Updated</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Vehicle Name</th>
            <th>Vehicle No.</th>
            <th>Make/Model/Year</th>
            <th>Insurance Policy No.</th>
            <th>Added On</th>
            <th>Last Updated</th>
            <th>Status</th>
            <th>Actions</th>
			
        </tr>
    </tfoot>
    <?php if (!empty($vehicles)) { 
        ?>
        <tbody>
            <?php foreach ($vehicles as $k => $vehicle) { ?>
                <tr>
                    <td><?php echo $vehicle['vehicle_name']; ?></td>
                    <td><?php echo $vehicle['vehicle_number']; ?></td>
                    <td><?php echo $vehicle['make'] . '/' . $vehicle['model'] . '/' . $vehicle['year']; ?></td>
                    <td><?php echo $vehicle['ins_policy_no']; ?></td>
                    <td><?php echo date('d-m-Y h:i A', strtotime($vehicle['created'])); ?></td>
                    <td><?php
                        if (!empty($vehicle['updated'])) {
                            echo date('d-m-Y h:i A', strtotime($vehicle['updated']));
                        } else {
                            echo 'Not Updated Yet';
                        }
                        ?>
                    </td>
                    <td>
					<span class="status_<?php echo $vehicle['id']; ?>">
                        <?php
                        if ($vehicle['status'] == 1) {
                            echo 'Active';
                        } elseif ($vehicle['status'] == 2) {
                            echo 'In Active';
                        } elseif ($vehicle['status'] == 3) {
                            echo 'Pending for Approval';
                        } elseif ($vehicle['status'] == 4) {
                            echo 'Rejected';
                        }
                        ?>
						</span>
                    </td>
					<td>
					<?php 		if($this->session->userdata('user_type') == 'rto_staff'){	?>
					<div class="editAllFunct" >
						<div class="editFunCon" style="display:block">
                        <a href="javascript:void(0);" onclick="showhidefunc(this)">Edit</a>
						</div>
						<div class="editCon" style="display:none">
						<select id="editStatus_<?php echo $vehicle['id']; ?>" name="editStatus_<?php echo $vehicle['id']; ?>">
							<option value="1">Active</option>
							<option value="2">In Active</option>
							<option value="3">Pending for Approval</option>
							<option value="4">Rejected</option>
						</select> 
						<a href="javascript:void(0);" onclick = "editStatusFunc(<?php echo $vehicle['id']; ?>,'<?php echo $vehicle['vehicle_number']; ?>')" >save</a>
						<a href="javascript:void(0);" onclick = "cancelhidefunc(this)" >cancel</a>
						</div>
					</div>
					<?php } ?>
                        <!--<a href="<?php //echo base_url(); ?>vehicles/add">Edit</a>-->
                       &nbsp;&nbsp;
                        <a href="<?php //echo base_url(); ?>vehicles/view/<?php echo $vehicle['id']; ?>">View Details</a>
                    </td>
                </tr>
            <?php }
            ?>
        </tbody>
        <?php
    }?>
</table>
