<h2>Add <?php echo $doc_type['doc_type']; ?> Details</h2>
<?php
echo form_open('vehicles/add_policy/' . $vehicle_id . '/' . $doc_type['id']);
echo form_hidden('vehicle_id', $vehicle_id);
echo form_hidden('doc_type_id', $doc_type['id']);
?>
<fieldset>
    <legend><?php echo $doc_type['doc_type']; ?></legend>
    <?php
    foreach ($form_fields as $k => $form_field) {
        $attr = 'placeholder="' . $form_field['field_name'] . '" id="field_' . $form_field['id'] . '" autocomplete="off"';
        if ($form_field['field_type'] == 'textbox') {
            echo form_input('form_field[' . $form_field['id'] . ']', set_value('form_field[' . $form_field['id'] . ']', ''), $attr);
        } elseif ($form_field['field_type'] == 'textarea') {
            $data = array(
                'name' => 'form_field[' . $form_field['id'] . ']',
                'id' => 'field_' . $form_field['id'],
                'value' => '',
                'placeholder' => $form_field['field_name'],
                'rows' => 2,
                'cols' => 33
            );
            echo form_textarea($data);
        } elseif ($form_field['field_type'] == 'date') {
            $attr .= ' class="date"';
            echo form_input('form_field[' . $form_field['id'] . ']', set_value('form_field[' . $form_field['id'] . ']', ''), $attr);
        } elseif ($form_field['field_type'] == 'datetime') {
            $attr .= ' class="datetime"';
            echo form_input('form_field[' . $form_field['id'] . ']', set_value('form_field[' . $form_field['id'] . ']', ''), $attr);
        }
    }
    echo form_submit('submit', 'Submit Request');
    echo validation_errors('<p class= "error"></p>');
    ?>
</fieldset>