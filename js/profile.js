

$(document).ready(function(){
 if($('#update_form').length > 0){
     $.ajax({
			type:'POST' ,
            url:'controller.php',
            data : {
                    function_name : 'get_country_list', 
                   },
			success: function (response){  
				var parse_json = $.parseJSON(response);		
                if($('select[name=country_id]').children('option').length <= 1){				
					$.each(parse_json,function(key,value){
				 
						$('select[name=country_id]').append('<option value='+value['country_id']+'>'+value['country']+'</option>')
					});
				}
			}
		});
	$("#validation_msg").hide();

    $('#btn_edit').click(function(event){
	    event.stopImmediatePropagation();
	    show_hide($('div#update_profile'),$('div#view_profile'));
	});
	
    $('#btn_close').click(function(event){
	   event.stopImmediatePropagation();
	   show_hide($('div#view_profile'),$('div#update_profile'));
	});
	
	 $('#btn_cancel').click(function(event){
	   event.stopImmediatePropagation();
	   show_hide($('div#view_profile'),$('div#update_profile'));
	});
	
    get_profile();


	
    $("#btn_submit").on('click',function(event){
      event.stopImmediatePropagation();
      var validation_holder = 0;
      var firstname = $("input#fname");
      var lastname = $("input#lname");
      var street = $("input#address");
      var town_city = $("input#town_city");
      var state_province = $("input#state_province");
      var country = $('select[name=country_id]');
      var birth_date = $('input#birth_date');
      var contact_no = $('input#contact_no');
      var email_add = $('input#email_add');
      var pass = $('input[name=password]');
      var curr_pass = $('input[name=current_password]');
      
      var email_add_match =  $('#email_add_verify');
      var pass_match = $('input#confpass');
      var accept = $('#accept');
      var required = [firstname,lastname,street,town_city,country,birth_date,contact_no,email_add,curr_pass];
      
      var count_err = check_required_fields(required);	  
      var match = [{ m: [ pass_match.val(), pass.val() ] }];
   //   alert(count_err);
   //   var count = 0;
	//  alert(count_err);
	  if(count_err > 0){

		   // $(curr_pass).css('background-color', '#FF8073');
			 validation_holder = 1;
	  }
	  if(pass_match.val() !==  pass.val()){
	   	 $(pass_match).parent().find('p').hide();
         $(pass).css('background-color', '#FF8073');
         $(pass_match).css('background-color', '#FF8073');   
		 validation_holder = 1;
	  }else{
		 $(pass).css('background-color', '#FFFFFF');   
	     $(pass_match).css('background-color', '#FFFFFF');

	  }
console.log(validation_holder);
//console.log($("#update_form").serializeArray());
      if(validation_holder == 0) {
         $.ajax({
				type:'POST' ,
                  url:'controller.php',
                  data : {
                         pwd : $('#current_password').val(),
                         function_name : 'sha1_pass', 
                  },
                  success: function (response){   
                    if($('#cur_p').val() === response ){
                      $.ajax({
						type:'POST',
                  		url:'controller.php',
                        data: { 'params' : {'form' : $("#update_form").serializeArray(),'user_id': $('input#u_id').val(),},
                   			    'function_name':'update_profile',
                  			  },
						success: function (response){ 
						  console.log(response);
						  if(is_json_string(response)){
						     var obj = jQuery.parseJSON(response);
						    $('html,body').scrollTop(0);
							$('#validation_msg').focus();
							$('#validation_msg').fadeIn();
							$('#val_msg').text(obj['err_msg']);
						  }else{
							$('#validation_msg').fadeOut();
							if(response == true || response == ""){
								get_profile();
								show_hide($('div#view_profile'),$('div#update_profile'));
								$.ajax({
									type: 'POST',
									url:'controller.php',
									data: {'mail': email_add.val(),'subject': 'Account Update Notification','content': 'You have successfully updated your account.','function_name':'send_email'},
							   });
								$('#confirm_add').dialog('open');  
							}
						  }
						}
					  });

                    }else{
                      $('#current_password').css('background-color', '#FF8073');
                    }
							}
					});
  
      }else{
		 $('html,body').scrollTop(0);
		 $('#validation_msg').focus();
		 $('#validation_msg').fadeIn();
		 $('#val_msg').text('Please check and fill in required fields.');
	  }

    });
   
     $('#confirm_add').dialog({
         height: 'auto',
        width: 'auto',
		position: 'top',
        zIndex: 999,
        autoOpen: false,
        modal: true,
 				buttons: {
				'Ok' : function (){
      		     $(this).dialog('close');
       //    AC.API.Nav('update_profile');
				},
		   }
	});
	}
		  
		  
    function get_profile(){
		$.ajax({
			type:'POST',
			url:'controller.php',
			data: { 'function_name' : 'get_profile',
                  			},
			success: function (response){ 
		//	console.log(response);
				var parse_json = $.parseJSON(response);
				var user_profile = parse_json[0];
				console.log(user_profile);
				var arr = {'lname': user_profile['lname'],
						'mname' : user_profile['mname'],
						'fname' : user_profile['fname'],
			/*			'unit_no' : user_profile['unit_no'],
						'building_name' : user_profile['building_name'],*/
					    'address' : user_profile['address'],
						'town_city' : user_profile['town_city'],
						'state_province' : user_profile['state_province'],
						'contact_no' :user_profile['contact_no'],
						'email_add' : user_profile['email_add'],
						'birth_date' : user_profile['birth_date'],
						'country' : user_profile['country_id'],
						'gender' : user_profile['gender'],
						'cur_p' : user_profile['password'],
						'u_id' : user_profile['user_id'],
		 			  };

				$.each(arr,function(key,value){
					if(key == 'gender'){
						if(value.toUpperCase() == 'F'){
							$('input[type=radio]:eq(1)').click();
						}else{
							$('input[type=radio]:eq(0)').click();
						}
						$('input[name=gender]').filter('[value='+value+']').prop('checked',true);
						$('label#'+key).text((value.toUpperCase() == 'F') ? 'Female' : 'Male');
					}else if( key == 'country'){
				//	alert($('select#country_id').find('option[value='+value+']').text());
						//$('label#country').text('');
					    $('label#country').text($('select#country_id').find('option[value='+value+']').text());
						$('select#country_id').find('option[value='+value+']').prop('selected',true);
					}else{
						$('input#'+key).val(value);
						$('select#'+key).val(value);
						$('label#'+key).text(value);
					}                              
				});
			}			 
		});
	
	}
	
});
  
 


