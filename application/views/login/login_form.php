<script type="text/javascript">
    $(document).ready(function () {
        $("#user_type").focus();
        $('#passcode').click(function (event) {
            event.preventDefault();
            if ($("#user_type").val() != "user") {
                alert("Please select user type as user.");
                $("#user_type").focus();
                return;
            }
            if ($("#username").val() == "") {
                alert("Please search aadhar number.");
                $("#username").focus();
                return;
            }
            $.ajax({
                url: $(this).attr('href'),
                data: "username=" + $("#username").val() + "&user_type=" + $("#user_type").val(),
                success: function (response) {
                    alert(response);
                    $("#password").focus();
                }
            })
            return false; //for good measure
        });

        $("form").submit(function (event) {
            if ($("#user_type").val() == "") {
                alert("Please select user type.");
                $("#user_type").focus();
                event.preventDefault();
                return;
            }
            if ($("#username").val() == "") {
                alert("Please  enter Username or Aadhar Number.");
                $("#username").focus();
                event.preventDefault();
                return;
            }
            if ($("#password").val() == "") {
                alert("Please enter password/passcode.");
                $("#password").focus();
                event.preventDefault();
                return;
            }
        });

        $('#passcode').hide();
        function split(val) {
            return val.split(/,\s*/);
        }
        function extractLast(term) {
            return split(term).pop();
        }

        $("#user_type").change(function () {
            $("#username").val('');
            $("#password").val('');
            $("#username").focus();
            if ($(this).val() == "user") {
                $("#username").attr("placeholder", "Search User");
                $("#password").attr("placeholder", "Enter Pass Code");
                $('#passcode').show();

                if (!$("#username").data('autocomplete')) {
                    $("#username").bind("keydown", function (event) {
                        if (event.keyCode === $.ui.keyCode.TAB &&
                                $(this).data("autocomplete").menu.active) {
                            event.preventDefault();
                        }
                    }).autocomplete({
                        source: function (request, response) {
                            $.getJSON("<?php echo base_url(); ?>index.php/login/getUsers?searchBy=aadhar", {
                                term: extractLast(request.term)
                            }, response);
                        },
                        search: function () {
                            // custom minLength
                            var term = extractLast(this.value);
                            if (term.length < 2) {
                                return false;
                            }
                        },
                        focus: function () {
                            // prevent value inserted on focus
                            return false;
                        },
                        select: function (event, ui) {
                            this.value = ui.item.all.username;
                            $("#passcode").focus();
                            //var terms = split( this.value );
                            // remove the current input
                            //terms.pop();
                            // add the selected item
                            // terms.push( ui.item.value );
                            // add placeholder to get the comma-and-space at the end
                            //terms.push( "" );
                            //this.value = terms.join( "," );
                            return false;
                        }
                    });
                }
            }
            else {
                $("#username").attr("placeholder", "Enter Username");
                $("#password").attr("placeholder", "Enter Password");
                $('#passcode').hide();
                if ($("#user_type").data('autocomplete')) {
                    $("#user_type").autocomplete("destroy");
                    $("#user_type").removeData('autocomplete');
                }
            }
        });
        //$("#user_type").trigger('change');
    });
</script>

<div id="login_form">
    <h1>Login</h1>
    <?php
    $username = 'placeholder="Enter Username or Aadhar Number" id="username" autocomplete=off';
    $password = 'placeholder="Enter Password" id="password"';

    echo form_open("login/authenticate_user");
    ?>
    <table>
        <tr>
            <td>
                Login Type
            </td>
            <td>
                <?php echo form_dropdown("user_type", array('' => '-- Select Login Type --', 'admin' => 'Admin', 'rto_staff' => 'RTO Authority', 'ins_staff' => 'Insurance Authority', 'pol_staff' => 'Pollution Control Authority', 'user' => 'User'), 'user', 'id="user_type"'); ?>
            </td>
        </tr>
        <tr>
            <td>
                Username or Aadhar Number
            </td>
            <td>
                <?php echo form_input("username", "", $username); ?>
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
    echo form_submit("submit", "Login");
    echo anchor("login/get_otp", "Generate Passcode", 'id="passcode"');
    echo('<br/><br/s>');
    if (isset($error) && !empty($error)) {
        ?>
        <center>
            <span style="color:#FF0000"><?php echo($error); ?></span></center>
        <?php }
        ?>
</div>