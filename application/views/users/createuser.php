<script>

    $(document).ready(function () {
        function split(val) {
            return val.split(/,\s*/);
        }
        function extractLast(term) {
            return split(term).pop();
        }
        if (!$("#mobile").data('autocomplete')) {
            $("#mobile").bind("keydown", function (event) {
                if (event.keyCode === $.ui.keyCode.TAB &&
                        $(this).data("autocomplete").menu.active) {
                    event.preventDefault();
                }
            })
                    .autocomplete({
                        source: function (request, response) {
                            $.getJSON("<?php echo base_url(); ?>index.php/login/getPatients?searchBy=mobile", {
                                term: extractLast(request.term)
                            }, response);
                        },
                        search: function () {
                            // custom minLength
                            $("#first_name").val('');
                            $("#last_name").val('');
                            $("#email").val('');
                            $("#gender").val('');
                            $("#age").val('');
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
                            this.value = ui.item.all.mobile;
                            $("#first_name").val(ui.item.all.first_name);
                            $("#last_name").val(ui.item.all.last_name);
                            $("#email").val(ui.item.all.email);
                            $("#gender").val(ui.item.all.gender);
                            $("#age").val(ui.item.all.age);
                            return false;
                        }
                    });
        }
    });
    var expanded = false;
    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
    }

</script>


<h2>Create Traffic Crossover User</h2>
<?php echo form_open('site/createuser'); ?>
<fieldset>
    <legend>Personal Information</legend>

    <?php
    $fname = 'placeholder="First Name" id="first_name" autocomplete="off"';
    $lname = 'placeholder="Last Name"  id="last_name" autocomplete="off"';
    $mbl = 'placeholder="Mobile Number" id="mobile" autocomplete="off"';
    $aadharplaceholder = 'placeholder="Enter Aadhar No." id="aadhar" autocomplete="off"';
    $aadhar="";
    $mobile = '';
    $firstname = '';
    $last_name = '';
    $email = '';
    $gender = '';
    $dob = '';
    $testListArr = array();
    if (isset($mode) && $mode == "EDIT") {
        $mobile = $result['userdata']['mobile'];
        $firstname = $result['userdata']['first_name'];
        $last_name = $result['userdata']['last_name'];
        $email = $result['userdata']['email'];
        $gender = $result['userdata']['gender'];
        $dob = $result['userdata']['dob'];
        $mbl.=' readonly ';
        echo form_hidden('mode', set_value('mode', 'EDIT'));

        if (count($result['testdata']) > 0) {
            foreach ($result['testdata'] as $k => $v) {
                $testListArr[] = $v['tests_id'];
            }
        }
        echo form_dropdown('status', array('' => 'Select status', 'Pending' => 'Pending', 'Complete' => 'Complete'), '', 'id="status"');
    }
    echo form_dropdown("user_type", array('' => '-- Select Login Type --', 'rto_staff' => 'RTO Authority','trafic_police' => 'Traffic Police',
        'ins_staff' => 'Insurance Authority', 'pol_staff' => 'Pollution Control Authority', 'user' => 'User'), 'user', 'id="user_type"');
    echo form_input('Aadhar No.', set_value('aadhar', $aadhar), $aadharplaceholder);
    echo form_input('mobile', set_value('mobile', $mobile), $mbl);
    echo form_input('first_name', set_value('first_name', $firstname), $fname);
    echo form_input('last_name', set_value('last_name', $last_name), $lname);
    echo form_input('email', set_value('email', $email), 'placeholder="E-mail Address"  id="email"');
    echo form_dropdown('gender', array('' => 'Select Gender', 'Male' => 'Male', 'Female' => 'Female'), $gender, 'id="gender"');
    echo form_input('dob', set_value('dob', $dob), 'placeholder="Enter Date of Birth" id="dob" class="date"');
    ?>
</fieldset>

<fieldset>
    <legend>Tests Info</legend><br>
    <div class="multiselect">
        <div class="selectBox" onclick="showCheckboxes()">
            <select>
                <option>Select Customer's Choice</option>
            </select>
            <div class="overSelect"></div>
        </div>
        <div id="checkboxes">
            <?php
            foreach ($testList as $k => $v) {
                $chk = '';
                if (in_array($k, $testListArr)) {
                    $chk = "checked";
                }
                ?>
                <label for="<?= $k; ?>">

                    <input type="checkbox" id='<?= $k; ?>' name="tests[]"  <?php echo $chk; ?>  value="<?= $k; ?>"/><?= $v; ?></label>
                <?php
            }
            ?>
        </div>
    </div>    
    <?php
    echo form_submit('submit', 'Submit Rerquest');
    echo validation_errors('<p class="error"></p>');
    ?> </fieldset>