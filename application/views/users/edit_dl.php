<h2>Edit Driving License Details</h2>
<?php echo form_open('users/edit_dl'); ?>
<fieldset>
    <legend>Driving License</legend>
    <?php
    //echo '<pre>';
    //print_r($form_fields);
    foreach ($form_fields as $k => $form_field) {
	
        $attr = 'placeholder="' . $form_field['field_name'] . '" id="field_' . $form_field['id'] . '" autocomplete="off"';
        if ($form_field['field_type'] == 'textbox') {
            echo form_input('form_field[' . $form_field['id'] . ']', set_value('form_field[' . $form_field['id'] . ']', $dl_details[$k]['value']), $attr);
        } elseif ($form_field['field_type'] == 'textarea') {
            $data = array(
                'name' => 'form_field[' . $form_field['id'] . ']',
                'id' => 'field_' . $form_field['id'],
                'value' => $dl_details[$k]['value'],
                'placeholder' => $form_field['field_name'],
                'rows' => 2,
                'cols' => 34
            );
            echo form_textarea($data);
        } elseif ($form_field['field_type'] == 'date') {
            $attr .= ' class="date"';
            echo form_input('form_field[' . $form_field['id'] . ']', set_value('form_field[' . $form_field['id'] . ']', $dl_details[$k]['value']), $attr);
        } elseif ($form_field['field_type'] == 'datetime') {
            $attr .= ' class="datetime"';
            echo form_input('form_field[' . $form_field['id'] . ']', set_value('form_field[' . $form_field['id'] . ']', $dl_details[$k]['value']), $attr);
        }
    }
    echo form_submit('edit', 'Save Request');
    echo validation_errors('<p class= "error"></p>');
    ?>
</fieldset>