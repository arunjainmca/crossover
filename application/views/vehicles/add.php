<script type="text/javascript">
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
            }).autocomplete({
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
<h2>Add New Vehicle</h2>
<?php echo form_open('vehicles/add'); ?>
<fieldset>
    <legend>Vehicle Details</legend>
    <?php
    $attr_vname = 'placeholder="Vehicle Name" id="vehicle_name" autocomplete="off"';
    $attr_vnum = 'placeholder="Vehicle Number"  id="last_name" autocomplete="off"';
    $attr_vmake = 'placeholder="Vehicle Make (Manufacturer)" id="make" autocomplete="off"';
    $attr_vmodel = 'placeholder="Vehicle Model" id="model" autocomplete="off"';
    $attr_vyear = 'placeholder="Vehicle Year" id="year" autocomplete="off"';
    $attr_vcolor = 'placeholder="Vehicle Color" id="color" autocomplete="off"';
    $attr_ins_policy_no = 'placeholder="Insurance Policy Number" id="ins_policy_no" autocomplete="off"';
    $vname = '';
    $vnum = '';
    $vmake = '';
    $vmodel = '';
    $vyear = '';
    $vcolor = '';
    $ins_policy_no = '';
    $testListArr = array();
    if (isset($mode) && $mode == "EDIT") {
        echo form_hidden('mode', set_value('mode', 'EDIT'));
    }

    echo form_input('vehicle_name', set_value('vehicle_name', $vname), $attr_vname);
    echo form_input('vehicle_number', set_value('vehicle_number', $vnum), $attr_vnum);
    echo form_input('make', set_value('make', $vnum), $attr_vnum);
    echo form_input('model', set_value('model', $vmodel), $attr_vmodel);
    echo form_input('year', set_value('year', $vyear), $attr_vyear);
    echo form_input('color', set_value('color', $vcolor), $attr_vcolor);
    echo form_input('ins_policy_no', set_value('ins_policy_no', $ins_policy_no), $attr_ins_policy_no);
    echo form_submit('submit', 'Submit Request');
    echo validation_errors('<p class="error"></p>');
    ?>
</fieldset>