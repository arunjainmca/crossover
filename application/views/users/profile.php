<script>
    $(document).ready(function () {
        $('#datatable').DataTable();
    });

</script>
<h2>User's Details</h2>
<div class="divider"></div>
<br/>
<table align="center" border='1' cellspacing='0' cellpadding='10'>
    <tr>
        <td>User Name</td><td><?php echo $this->session->userdata('username'); ?></td>
    </tr>
    <tr>
        <td>Aadhar Number</td><td><?php echo $this->session->userdata('aadhar_id'); ?></td>
    </tr>
    <tr>
        <td>Login Name</td><td><?php echo $this->session->userdata('loginname'); ?></td>
    </tr>
    <tr>
        <td>Gender</td><td><?php echo ucfirst($this->session->userdata('gender')); ?></td>
    </tr
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