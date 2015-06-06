
<?php
$data = $this->session->all_userdata();

if (trim($data['user_type']) == 'admin'):
    ?>
    <ul class="PaycMenu">
        <li>
            <a href="#">&nbsp;Admin</a>
            <ul>
                <li><a href="<?php echo base_url() ?>site/testsRequest" >Take Tests Request </a></li>
                <li><a href="<?php echo base_url() ?>site/getOrders" >Update/Delete Tests Request</a></li>
                <li><a href="#">Add Lab User</a></li>
            </ul>
        </li>
        <li><a href="#">&nbsp;Reports</a>
            <ul>
                <li><a href="#" >Find Customers</a></li>
                <li><a href="#" >View & send Reports</a></li>
            </ul>
        </li>
        <li>
            <a href="<?php echo base_url() ?>login/logout">
                Logout
            </a>
        </li>
    </ul>
<?php elseif (trim($data['user_type']) == 'user'): ?>
    <ul class="PaycMenu">
        <li>
            <a href="<?php echo base_url() ?>vehicles/index">My Vehicles</a>
            <ul>
                <li><a href="<?php echo base_url() ?>vehicles/add" >Add New Vehicle</a></li>
                <li><a href="<?php echo base_url() ?>vehicles/index" >Vehicle List</a></li>
            </ul>
        </li>
        <li>
            <a href="<?php echo base_url() ?>users/profile">My Profile</a>
        <li>
            <a href="<?php echo base_url() ?>login/logout">
                Logout
            </a>
        </li>
    </ul>
<?php endif; ?>