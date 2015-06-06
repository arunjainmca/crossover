<script type="text/javascript">
    $(document).ready(function() {
        $("#usertype").focus();
        $('#passcode').click(function (event){ 
        event.preventDefault(); 
        if($("#usertype").val() != "PAT"){
            alert("Please select user as Patient.");
            $("#usertype").focus(); 
            return;
        }
        if($("#username").val() == ""){
            alert("Please  search Patient name.");
            $("#username").focus(); 
            return;
        }
        $.ajax({
            url: $(this).attr('href'),
            data: "username="+$("#username").val()+"&usertype="+$("#usertype").val(),
            success: function(response) {
                alert(response);
                $("#password").focus(); 
            }
        })
        return false; //for good measure
        });
        
        $( "form" ).submit(function( event ) {
            if($("#usertype").val() == ""){
                alert("Please select user type.");
                $("#usertype").focus();
                event.preventDefault();
                return;
            }
            if($("#username").val() == ""){
                alert("Please  enter user name/serarch patient.");
                $("#username").focus();
                event.preventDefault();
                return;
            }
            if($("#password").val() == ""){
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
        
        $("#usertype").change(function() {
        $("#username").val('');
        $("#password").val('');  
        $("#username").focus();
        if($(this).val()=="PAT" ){
            $("#username").attr("placeholder", "Search Patient");
            $("#password").attr("placeholder", "Enter Pass Code");
            $('#passcode').show();
            
            if(!$("#username").data('autocomplete')){
            $("#username").bind("keydown", function(event) {
                    if (event.keyCode === $.ui.keyCode.TAB &&
                            $(this).data("autocomplete").menu.active) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                source: function(request, response) {
                    $.getJSON("<?php echo base_url(); ?>index.php/login/getPatients?searchBy=name", {
                        term: extractLast(request.term)
                    }, response);
                },
                search: function() {
                    // custom minLength
                    var term = extractLast(this.value);
                    if (term.length < 2) {
                        return false;
                    }
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function(event, ui) {
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
            if ($("#usertype").data('autocomplete')) {
                $("#usertype").autocomplete("destroy");
                $("#usertype").removeData('autocomplete');
                
            }
            
        }
         
        });
        
        
                       
                       

    });
</script>

<div id="login_form">
	<h1>Login</h1>
    <?php
	$username = 'placeholder="Enter Username" id="username" autocomplete=off';
	$password = 'placeholder="Enter Password" id="password"';
	
	echo form_open("login/authenticate_user");
        echo form_dropdown("usertype", array(''	=>'-- Select Login Type --','LAB'=>'Lab Technician','PAT'=>'Patients'),
                '','id="usertype"');
	echo form_input("username", "", $username);
	echo form_password("password", "", $password);
        ?>
        
         
        <?php
	echo form_submit("submit", "Login");
	echo anchor("login/getPasscode", "Generate Passcode",'id="passcode"');
        echo('<br><br>');
        if(isset($error) && !empty($error)){
            echo($error);
        }
	?>
        

</div>