<script>
    $(document).ready(function () {
        $('#datatable').DataTable();
    });

</script>
<br/>
<div class="divider"></div>
<table align="center" border="1" cellspacing="0" cellpadding="10" width="540">
    <tr>
        <th colspan="2">
            Profile Details
            <span style="float:right"><a href="javascript:void(0);">Edit</a></span>
        </th>
    </tr>
    <tr>
        <td width="120">User Name</td><td><?php echo $this->session->userdata('username'); ?></td>
    </tr>
    <tr>
        <td>Aadhar Number</td><td><?php echo $this->session->userdata('aadhar_id'); ?></td>
    </tr>
    <tr>
        <td>Login Name</td><td><?php echo $this->session->userdata('loginname'); ?></td>
    </tr>
    <tr>
        <td>Gender</td><td><?php echo ucfirst($this->session->userdata('gender')); ?></td>
    </tr>
    <tr>
        <td>Registered Mobile</td><td><?php echo $this->session->userdata('mobile'); ?></td>
    </tr>
    <tr>
        <td>Email</td><td><?php echo $this->session->userdata('email'); ?></td>
    </tr>
    <tr>
        <td>Address</td><td><?php echo $this->session->userdata('address'); ?></td>
    </tr>
    <tr>
        <td>City</td><td><?php echo $this->session->userdata('city'); ?></td>
    </tr>
    <tr>
        <td>State</td><td><?php echo $this->session->userdata('state'); ?></td>
    </tr>
    <tr>
        <td>Pin code </td><td><?php echo $this->session->userdata('pincode'); ?></td>
    </tr>
</table>
<br/>
<table align="center" border="1" cellspacing="0" cellpadding="10" width="540">
    <tr>
        <th colspan="2">
            Driving License Details
			<?php 
			if (!empty($dl_details)) {?>
            <span style="float:right"><a href="<?php echo base_url().'users/edit_dl';?>">Edit</a></span>    
			<?php }?>
        </th>
    </tr>
    <?php
    if (!empty($dl_details)) {
        foreach ($dl_details as $dl_field) {
            ?>
            <tr>
                <td width="120"><?php echo $dl_field['field_name']; ?></td><td><?php echo $dl_field['value']; ?></td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan="2">You have not saved your Driving License Details yet. Please <a href="<?php echo base_url(); ?>users/add_dl">click here</a> to Add.</td>
        </tr>
    <?php } ?>
</table>
