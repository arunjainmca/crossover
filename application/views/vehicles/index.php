<script>
    $(document).ready(function () {
        $('#datatable').DataTable();
    });

</script>
<h2>My Vehicles List</h2>
<div class="divider"></div>
<br/>
<table>
    <tr>
        <td>User Name:</td><td><?php echo $this->session->userdata('username'); ?></td>
        <td>Aadhar Number:</td><td><?php echo $this->session->userdata('aadhar_id'); ?></td>
    </tr>
    <tr>
        <td>Date of Birth:</td><td><?php echo $this->session->userdata('age'); ?></td>
    </tr>
    <tr>
        <td>Gender:</td><td><?php echo $this->session->userdata('gender'); ?></td>
    </tr>
    <tr>
        <td>Contact Details:</td><td><?php echo $this->session->userdata('mobile'), ",  " . $this->session->userdata('email'); ?></td>
    </tr>
</table>
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
                    </td>
                    <td>
                        <a href="javascript:void(0);">Edit</a>
                        <!--<a href="<?php echo base_url(); ?>vehicles/add">Edit</a>-->
                        &nbsp;&nbsp;
                        <a href="<?php echo base_url(); ?>vehicles/view/<?php echo $vehicle['id']; ?>">View Details</a>
                    </td>
                </tr>
            <?php }
            ?>
        </tbody>
        <?php
    }
    ?>
</table>
