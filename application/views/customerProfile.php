<script>
	$(document).ready(function() {
    $('#datatable').DataTable();
} );

</script>
<h2>Customer's Details</h2>
<div class="divider"></div>
<br/>
<table align="center" border='1' cellspacing='0' cellpadding='20'>
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
        <td>Contact Details.</td><td><?=$this->session->userdata('mobile');?></td>
    </tr>
     <tr>
        <td>Email</td><td><?=$this->session->userdata('email');?></td>
    </tr>
</table>
</br>

