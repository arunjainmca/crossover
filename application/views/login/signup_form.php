<script type="text/javascript">
    $(document).ready(function () {
        $("#aadhar").focus();

        
        $('#genotp').click(function (event) {
            event.preventDefault();
            if ($("#aadharno").val() == "") {
                alert("Please enter numeric aadhar number.");
                $("#aadharno").focus();
                return;
            }
            $.ajax({
                url: $(this).attr('href'),
                data: "aadharno=" + $("#aadharno").val(),
                success: function (response) {
                    alert(response);
                    $("#otp").focus();
                }
            })
            return false; //for good measure
        });
        
        $("form").submit(function (event) {
        
            if ($("#aadharno").val() == "") {
                alert("Please enter numeric aadhar number.");
                $("#aadharno").focus();
                return;
            }
            if ($("#otp").val() == "") {
                alert("Please enter OTP.");
                $("#otp").focus();
                event.preventDefault();
                return;
            }
            if ($("#password").val() == "") {
                alert("Please enter password.");
                $("#password").focus();
                event.preventDefault();
                return;
            }
        });
        
    });
</script>

<div id="signup_form">
    <h1>Signup</h1>
    <?php
    $username = 'placeholder="Enter Aadhar Number" id="aadharno" autocomplete=off  style="width:150px;"';
    $password = 'placeholder="Enter New Password" id="password"';
    $otp = 'placeholder="Enter OTP Receievd from UIDAI" id="otp"';
    echo form_open("login/signup");
    ?>
    <table width="100%">
        <tr>
            <td valign="top">
                Aadhar Number
            </td>
            <td>
                <div style="float:left;">
                    <?php echo form_input("aadharno", "", $username);?>
                </div>&nbsp;&nbsp;
                <div style="float:left;margin-left: 15px;margin-top: 3px;">
                    <?php echo anchor("login/get_otp", "Generate OTP", 'id="genotp"');?>
                </div>
                
                
            </td>
        </tr>
        <tr>
            <td>
                Enter OTP
            </td>
            <td>
                <?php echo form_password("otp", "",$otp); ?>
            </td>
        </tr>
        <tr>
            <td>
                Password
            </td>
            <td>
                <?php echo form_password("password", "", $password); ?>
            </td>
        </tr>
        
    </table>
    <?php
    echo form_submit("submit", "Signup");
    echo anchor("login/", "login", 'id="login"');
    echo('<br/>');
    if (isset($signuperror) && !empty($signuperror)) {
        ?>
        <center>
            <span style="color:#FF0000"><?php echo($signuperror); ?></span></center>
        <?php 
    }
    if (isset($signupsuccess) && !empty($signupsuccess)) {
        ?>
        <center>
            <span style="color:#FF0000"><?php echo($signupsuccess); ?></span></center>
        <?php 
    }
        ?>
</div>