<br/>
<table>
    <tr>
        <td>User Name:</td><td><?php echo $this->session->userdata('username'); ?></td>
    </tr>
    <tr>
        <td>Aadhar Number:</td><td><?php echo $this->session->userdata('aadhar_id'); ?></td>
    </tr>
    <tr>
        <td>Contact Details:</td><td><?php echo $this->session->userdata('mobile'), ",  " . $this->session->userdata('email'); ?></td>
    </tr>
</table>
<br/>
<h2>Vehicle Details</h2>
<br/>
<div class="divider"></div>
<table border="0" align="center" cellpadding="10" width="100%" style="border:1px solid #000000;">
    <tr>
        <td width="120">Vehicle Name:</td><td><?php echo $vehicle_details['vehicle_name']; ?></td>
        <td width="120">Vehicle Number:</td><td><?php echo $vehicle_details['vehicle_number']; ?></td>
    </tr>
    <tr>
        <td>Make:</td><td><?php echo $vehicle_details['make']; ?></td>
        <td>Model:</td><td><?php echo $vehicle_details['model']; ?></td>
    </tr>
    <tr>
        <td>Year:</td><td><?php echo $vehicle_details['year']; ?></td>
        <td>Color:</td><td><?php echo $vehicle_details['color']; ?></td>
    </tr>
    <tr>
        <td>Insurance Policy No.:</td><td><?php echo $vehicle_details['ins_policy_no']; ?></td>
        <td>Status:</td>
        <td>
            <strong>
                <?php
                if ($vehicle_details['status'] == 1) {
                    echo 'Active';
                } elseif ($vehicle_details['status'] == 2) {
                    echo 'In Active';
                } elseif ($vehicle_details['status'] == 3) {
                    echo 'Pending for Approval';
                } elseif ($vehicle_details['status'] == 4) {
                    echo 'Rejected';
                }
                ?>
            </strong>
        </td>
    </tr>
</table>
<br/>
<?php foreach ($doc_types as $doc_type) { ?>
    <table align="center" border="1" cellspacing="0" cellpadding="10" width="540">
        <tr>
            <th colspan="2">
                <?php
                echo $doc_type['doc_type'] . ' Details';
                if (!empty($doc_details[$doc_type['id']])) {
                    ?>
                    <span style="float:right"><a href="javascript:void(0);">Renew Documents</a></span>
                <?php } ?>
            </th>
        </tr>
        <?php
        if (!empty($doc_details[$doc_type['id']])) {
            foreach ($doc_details[$doc_type['id']] as $policy_field) {
                ?>
                <tr>
                    <td width="120"><?php echo $policy_field['field_name']; ?></td><td><?php echo $policy_field['value']; ?></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="2">You have not updated your <?php echo $doc_type['doc_type']; ?> Details yet. Please <a href="<?php echo base_url() . 'vehicles/add_policy/' . $vehicle_details['id'] . '/' . $doc_type['id']; ?>">click here</a> to Add.</td>
            </tr>
        <?php }
        ?>
    </table>
    <br/>
<?php }
?>
<br/><br/><br/>