
<?php
$data = $this->session->all_userdata();

if (trim($data['user_type']) == 'admin'):
    ?>
    <ul class="PaycMenu">
        <li>
            <a href="#">&nbsp;Admin</a>
            <ul>
                <li><a href="<?php echo base_url() ?>users/createuser" >Create User</a></li>
            </ul>
        </li>
        <li><a href="#">&nbsp;Reports</a>
            <ul>
                <li><a href="#" >Find Customers</a></li>
                <li><a href="#" >View & send Reports</a></li>
            </ul>
        </li>
        <li>
            <a href="<?php echo base_url() ?>vehicles/search">
                Search
            </a>
        </li>
        <li>
            <a href="<?php echo base_url() ?>login/logout">
                Logout
            </a>
        </li>
    </ul>
<?php elseif (trim($data['user_type']) == 'rto_staff'): ?>
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
        </li>
        <li>
            <a href="<?php echo base_url() ?>vehicles/search">
                Search
            </a>
        </li>
        <li>
            <a href="<?php echo base_url() ?>login/logout">
                Logout
            </a>
        </li>
    </ul>
<?php elseif (trim($data['user_type']) == 'pol_staff'): ?>
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
        </li>
        <li>
            <a href="<?php echo base_url() ?>vehicles/search">
                Search
            </a>
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
        </li>
        <li>
            <a href="<?php echo base_url() ?>login/logout">
                Logout
            </a>
        </li>
    </ul>
<?php endif; ?>