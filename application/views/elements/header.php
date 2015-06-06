<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Aadhar Traffic Crossover System</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <link type='text/css' rel='stylesheet' href="<?php echo base_url() ?>css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/jquery.dataTables.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>css/jquery-ui.css" />
        <!--        <link type='text/css' rel='stylesheet' href='https://fonts.googleapis.com/css?family=Droid+Sans' />-->        
        <!--[if lt IE 9]>
            <script src="/js/html5shiv.js" type="text/javascript"></script>
        <![endif]-->
        <script type='text/javascript' src="<?php echo base_url() ?>/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo base_url() ?>/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>/js/modernizr.js"></script>
        <script src="<?php echo base_url() ?>js/jquery-ui.js"></script>
    </head>
    <body class="body">
        <div class="main">
            <div class="header">
                <table width="100%">
                    <tr>
                        <td class="PaycLogo">
                            <h1>Aadhar Traffic Crossover System</h1>
                        </td>
                        <td class="PaycUser">
                            <?php
                            $is_logged_in = $this->session->userdata('is_logged_in');
                            if (isset($is_logged_in) && $is_logged_in) {
                                echo ('Hi!&nbsp;' . ucwords(strtolower($this->session->userdata('username'))));
                            }
                            ?>
                            <?php //if ($IsLogin) echo ('Hi!&nbsp;' . ucwords(strtolower($UserName)));  ?>
                        </td>
                        <td>
                            <?php
                            if ($is_logged_in) {
                                $this->load->view("elements/menu");
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="nav">&nbsp;</div>
            <div class="content">