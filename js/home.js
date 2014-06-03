
	$(document).unbind().on('ready',function(event) {
	    // event.stopImmediatePropagation();

        /*STAFF*/
		
		$('a#manager').unbind().on('click',function(event){
			event.stopImmediatePropagation(); 
			event.preventDefault(); 
			$.ajax({
				type: 'POST',
				url:'controller.php',
						data: {'function_name':'get_manager'},
				success: function (response){ 
					$.ajax({
						type: 'POST',
						url:'staff.php',
						data: {'data':response},
						success: function (response){ 
							$('div#content_bottom').html("");
							$('div#content_bottom').append(response);
							$.isLoading("hide");
						//	call_table_plugin('staff');
						}
					});				
				}
			});
		});

		$('a#add_staff').on('click',function(event){
			event.stopImmediatePropagation(); 
			event.preventDefault();
			
		    if($('table#staff').length == 0){
				get_staff();			
			}
		
			dialog_add_staff();
		    $( "#dialog_staff" ).dialog('open');	
		});		
		
		
		$('a#staff').one('click',function(event){
			event.stopImmediatePropagation(); 
			event.preventDefault(); 
			
			get_staff();
		});
		
		/*$('a#a_add_staff').one('click',function(event){
			event.stopImmediatePropagation(); 
			event.preventDefault();
			if($('table#staff').length == 0){
				get_staff();
			}	  
		    dialog_add_staff();
		    $( "#dialog_staff" ).dialog('open');
		});*/
		
		
		/*END OF STAFF*/
		



		
		function build_dialog(element_id){
			$('#'+element_id).dialog({
				height: 'auto',
				width: 'auto',
				autoOpen: false,
				modal: true,
 				buttons: {
					'Ok' : function (){
						$(this).dialog('close');
					},
				}
			});
			
		}
		
		function dialog_add_staff(){
			var win_width = window.innerWidth/1.3;
			var win_height = window.innerHeight/1.05;
			//alert('dadsdsa');
			$( "#dialog_staff" ).dialog({
				autoOpen: false,
				height: win_height,	 
				width: win_width,
				position: ['center',20],
				modal: true,
				open: function() {
					$.ajax({
						url:'controller.php',
						data: {'function_name' : 'get_branches'},
						type: "POST",
						success: function (response){ 
							var obj = jQuery.parseJSON(response);

							$.ajax({
								url:'form_add_staff.php',
								success: function (response){ 
									$("#dialog_staff").html("");
									$("#dialog_staff").append(response);
									 
									get_country_list('country');
									 
									$.each(obj,function(index,value){
										var br_id = value['branch_id'];
										var br_desc = value['branch_name'];
									
										$("select#branch_id").append("<option id='"+br_id+"' value='"+br_id+"'>"+br_desc+"</option>");
									});
									
									if($('#ut_id').val()== '4'){
										$.ajax({
											type: 'POST',
											url:'controller.php',
											data: {'function_name':'get_profile'},
											success: function (response){
												var obj = jQuery.parseJSON(response);
												var manager_branch_id = obj[0]['branch_id'];
									//alert('asdferr');
												$('select#branch_id').val('asdfghjkl');
												$('#branch_id option[value='+manager_branch_id+']').prop('selected',true);
												$('select#branch_id').hide();
												$('label#branch_label').text($('select#branch_id :selected').text());
												$('label#branch_label').show();
											}
							  });
							}
								}
							});
	
						}
					});
					},
					buttons: {
						Save: function() {
						   // var validation_holder = 0;
							var firstname = $("input#fname");
							var lastname = $("input#lname");
							var street = $("input#street");
							var town_city = $("input#town_city");
							var state_province = $("input#state_province");
							var country = $('select[name=country]');
							var branch = $('select[name=branch_id]');
							var birth_date = $('input#birth_date');
							var contact_no = $('input#contact_no');
							var email_add = $('input#email_add');
							var required = [firstname,lastname,street,town_city,country,birth_date,contact_no,email_add,branch];
				  
							var count_err = check_required_fields(required);	
							if(count_err == 0){
								$.ajax({
									url: 'controller.php',
									data:  { 'form' : $("#add_staff_form").serializeArray(),
										 'function_name':'add_staff',
										  },
									type: "POST",
									success: function(response){
									  console.log(response);
								      var obj = jQuery.parseJSON(response);
									
										if(obj['result']){
											$('#validation_msg').fadeOut();
										  // console.log('result is true');
										   var content = "You can now access your account by logging in the ff. information. Username:"+email_add.val()+", Password: "+ $('#password').val() ;
											$.ajax({
												type: 'POST',
												url:'controller.php',
												data: {'mail': email_add.val(),'subject': 'Successful registration','content': content,'function_name':'send_email'},
												success: function (response){ 

													var ch = $('table#staff').find('tr').length-2; 
													var clas = $("table#staff tr:nth-child("+ch+")").attr('class');
													var status = ($('input[name=status]').val().trim() == 'activate') ? 'Active' : 'Inactive';
													var odd_even = (clas == 'odd') ? 'even' : 'odd';
													var btn_status = (status == 'Active') ? 'Deactivate' : 'Activate';
													var user_type = ($('#ut_id').val() == '4') ? 'Restaurant Staff' : 'Restaurant Manager';
													var add_tbl_row = "<tr class= "+ odd_even +" style='display: table-row'>";
														add_tbl_row += "<td>"+firstname.val()+" "+ lastname.val()+"</td>";
														add_tbl_row += "<td>"+street.val()+" "+ town_city.val()+" "+ state_province.val()+"</td>";
														add_tbl_row += "<td>"+contact_no.val()+"</td>";
														add_tbl_row += "<td>"+email_add.val()+"</td>";
														add_tbl_row += "<td>"+$('select[name=branch_id] :selected').text().trim()+"</td>";
														add_tbl_row += "<td>"+user_type+"</td>";
														add_tbl_row += "<td>"+status+"</td>";
														add_tbl_row += "<td><button id='update_stat'>"+btn_status+"</button></td>";
														add_tbl_row += "</tr>";
													$('table#staff').append(add_tbl_row);
													$( "#dialog_staff" ).dialog('close');
													build_dialog('confirm_add_user');
													$('#confirm_add_user').dialog('open');  

												}
										   });		
										}else{
											$('div#dialog_staff').scrollTop(0);
											$('#validation_msg').focus();
											$('#validation_msg').fadeIn();
											$('#val_msg').text(obj['err_msg']);
										}
									}
								});
							}else{
								$('div#dialog_staff').scrollTop(0);
								$('#validation_msg').focus();
								$('#validation_msg').fadeIn();
								$('#val_msg').text('Please fill in required fields');
							}
						},
						Cancel: function() { $( this ).dialog( "close" );	}
					}
		  });	
		}

		
		/* to be revised.. temporary code - JX */
		
		
		if($('#homeMainContainer').length > 0){
			if($('input#ut_id').val() == '3'){
				$('div#system_admin').unbind().show();
				do_show_home('a#sysad_report');
				$.isLoading("hide");
			}
			
			if($('input#ut_id').val() == '2'){
				$('div#resto_admin').show();
				do_show_home('a#resadmin_report');
				$.isLoading("hide");
			}
			
			if($('input#ut_id').val() == '4'){
				$('div#manager').show();
				do_show_home('a#all_trans');
				$.isLoading("hide");
			}
			
			if($('input#ut_id').val() > 4 ){
				$('div#staff').show();
				$.isLoading("hide");
			}
		}
	
	      /*View menus or products*/
		$('a#product').one('click',function(event){
			event.stopImmediatePropagation(); 
			event.preventDefault(); 
					
			$.ajax({
				url:'search.php',
				success: function (response){ 
						$('div#content_bottom').html("");
						$('div#content_bottom').append(response);
						
						$.isLoading("hide");
				}
			});										
		});
	

	
	    /*For displaying system admin restaurant name report - JX*/
	
		$('a#sysad_report').unbind().one('click',function(event){
			event.stopImmediatePropagation(); 
			event.preventDefault(); 
			$.isLoading("hide");
			$.isLoading({text:"Loading.. "});
			$.ajax({
				type: 'POST',
				url:'controller.php',
				data: {'function_name':'sysad_report'},
				success: function (response){ 
					$.ajax({
						type: 'POST',
						url:'sysad_report.php',
						data: {'data':response},
						success: function (response){ 
							$('div#content_bottom').html("");
							$('div#content_bottom').append(response);
							$.isLoading("hide");
						}
					});					
				}
			});
			//alert('you clicked me');
		});
		
		/*For displaying system admin restaurant name report - JX*/
	
		$('a#resadmin_report').one('click',function(event){
			event.stopImmediatePropagation(); 
			event.preventDefault(); 
		//	$.isLoading("hide");
		//	$.isLoading({text:"Loading.. "});
			$.ajax({
				type: 'POST',
				url:'controller.php',
				data: {'function_name':'get_profile'},
				success: function (response){
					var obj = jQuery.parseJSON(response);
					var user_res_id = obj[0]['res_id'];
					// console.log(user_res_id);
					$.ajax({
						type: 'POST',
						url:'controller.php',
						data: {'function_name':'restadmin_report','res_id' : user_res_id},
						success: function (response){ 
					//  	console.log(response);
						
							$.ajax({
								type: 'POST',
								url:'restadmin_report.php',
								data: {'data':response},
								success: function (response){ 
						
									$('div#content_bottom').html("");
									$('div#content_bottom').append(response);
									$.isLoading("hide");
									//alert('dog');
								}	
							});					
						}
					});	
                }				
			});
		  //$.isLoading("hide");
		});
		
		$('a#all_trans').one('click',function(event){
			get_transactions();
		});	
		
		/*Checks all and unchecks all checkboxes element in view transaction*/
		
		$('a#chkbox').bind('click',function(event){
		    if($('input[type=checkbox]').length == $('input[type=checkbox]:checked').length){
				$('input[type=checkbox]').prop('checked',false);			
			}else{
				$('input[type=checkbox]').prop('checked',true);
			}
		});
		
		/*Click View details in view transactions*/
		$('a#view_detailed_trans').bind('click',function(event){
		   var dialog_id = 'view_detailed_order';
		   var transaction_id = $(this).parents('tr').attr('id');
		   build_dialog(dialog_id);
		   var arr_replace = {'order_no_value': transaction_id,'name_value': $(this).parent().siblings('td:eq(3)').text().trim(),
							  'address_value': $(this).parent().siblings('td:eq(5)').text().trim(),
							  'contact_no_value': $(this).parent().siblings('td:eq(4)').text().trim()
							 }
		//   $('div#'+dialog_id).find
		   	$.each(arr_replace,function(index,value){
				$("div#"+dialog_id).find('td#'+index).text(value);
			});
		   //console.log(arr_replace);
		   $.ajax({
						type: 'POST',
						url:'controller.php',
						data: {'function_name':'get_order_details','order_id':transaction_id},
						success: function (response){ 
							var obj = jQuery.parseJSON(response);
							var total_invoice = 0;
						 console.log(obj);
						   $('table#order_details').find('tbody').children('tr').remove();
						   
						   $.each(obj,function(index,value){
						     var food_val =  value['food_title'];
							// var price_per = parseFloat(value['total_payment']/value['order_quantity']).toFixed(2);
							// var total_payment = parseFloat(value['total_payment']).toFixed(2);
							 var price_per = parseFloat(value['food_newprice']).toFixed(2);
							 var total_payment = parseFloat(value['food_newprice'] * value['order_quantity']).toFixed(2);
							
						      $('table#order_details').find('tbody').append("<tr><td>"+food_val+"</td><td>"+price_per+"</td><td>X</td><td>"+value['order_quantity']+"</td><td>"+total_payment+"</td></tr>");
							  total_invoice += parseInt(total_payment);
						   });
						       total_invoice = parseFloat(total_invoice).toFixed(2);
						   $('table#order_details').find('tbody').append("<tr><td colspan='4'>Subtotal</td><td>"+total_invoice+"</td></tr>");
						   $('table#order_details').find('tbody').append("<tr><td colspan='4'>Shipping & Handling</td><td>0</td></tr>");
						   $('table#order_details').find('tbody').append("<tr style = 'font-weight:bold;'><td colspan='4' >Total</td><td>"+total_invoice+"</td></tr>");
			
						}
			});
		  $('div#'+dialog_id).dialog('open');
		});
		
		$('a#pending_trans').on('click',function(event){
		   get_transaction_bstatus('pending');
		});
		
		$('a#delivered_trans').on('click',function(event){
		   get_transaction_bstatus('delivered');
		});
		
		$('a#cancelled_trans').on('click',function(event){
		   get_transaction_bstatus('cancelled');
		});
	
		/*View Restaurant Names*/
		
		/*View menus or products*/
		$('a#add_restaurant').one('click',function(event){
			event.stopImmediatePropagation(); 
			event.preventDefault(); 
					$.ajax({
						type: 'POST',
						url:'controller.php',
						data: {'function_name':'get_restaurant_class'},
						success: function (response){
							console.log(response);
							/*$.ajax({
								type: 'POST',
								url:'trans_report.php',
								data: {'data':response},
								success: function (response){ 
									$('div#content_bottom').html("");
									$('div#content_bottom').append(response);
									$.isLoading("hide");
								}
							});		*/			
						}
					});
											
			$.ajax({
				url:'form_add_restaurant_name.php',
				success: function (response){ 
						$('div#content_bottom').html("");
						$('div#content_bottom').append(response);
				}
			});										
		});
	
	 	
		function get_transactions(){
			$.ajax({
				type: 'POST',
				url:'controller.php',
				data: {'function_name':'get_profile'},
				success: function (response){
					var obj = jQuery.parseJSON(response);
					var user_branch_id = obj[0]['branch_id'];
					$.ajax({
						type: 'POST',
						url:'controller.php',
						data: {'function_name':'get_transactions','branch_id':user_branch_id},
						success: function (response){ 
						$.ajax({
							type: 'POST',
							url:'trans_report.php',
							data: {'data':response},
							success: function (response){ 
								$('div#content_bottom').html("");
								$('div#content_bottom').append(response);
								$.isLoading("hide");
							}
						});					
						}
					});
				}
			});
		}
	 
		function get_transaction_bstatus(status){
			if($('#trans_report').length == 0){
				get_transactions();
			}
				$('select option[value="8"]').prop('selected',true);
				$('#search').val(status);
				$('#search').change();
		}
	 
		function get_products(){
	 
		}
	 
		function get_staff(){
			$.isLoading({text:"Loading.. "});
			$.ajax({
				type: 'POST',
				url:'controller.php',
				data: {'function_name':'get_staff'},
				success: function (response){ 
						$.ajax({
							type: 'POST',
							url:'staff.php',
							data: {'data':response},
							success: function (response){ 					
								$('div#content_bottom').html("");
								$('div#content_bottom').append(response);
								$('a#add_staff').text('Add New Staff');
								$.isLoading("hide");
							}
						});					
				}
			});
			
			$.isLoading("hide");
		}
	 
		function call_table_plugin(table_id){
			$('select').children().remove();
			$("#searchtable").show();
			$("table#"+table_id).advancedtable({searchField: "#search", loadElement: "#loader", searchCaseSensitive: false, ascImage: "css/images/up.png", descImage: "css/images/down.png", searchOnField: "#searchOn"});
		}
	
	
		/********** CLASS **********/
		$('a#class').unbind().on('click',function(event){
			event.stopImmediatePropagation(); 
			event.preventDefault(); 
			$.isLoading("hide");
			$.isLoading({text:"Loading.. "});

			$.ajax({
				type: 'POST',
				url:'controller.php',
						data: {'function_name':'get_class'},
				success: function (resp){ 
				
					var obj = jQuery.parseJSON(resp);
				
					$.ajax({
						type: 'POST',
						url:'class.php',
						data: {'data':resp},
						success: function (response){
							// console.log(resp);

							$('div#content_bottom').html("");
							$('div#content_bottom').append(response);
							 
							$.isLoading("hide");
							
						}
					});					
				}
			});
		});
		
		
		$('a#add_class').on('click',function(event){
			event.stopImmediatePropagation(); 
			event.preventDefault();
			
			dialog_add_class();
		    $( "#dialog_add_class" ).dialog('open');
		});	
		
		
		function dialog_add_class(){
			$( "#dialog_add_class" ).dialog({
				autoOpen: false,	 
				width: 400,
				modal: true,
				
				open: function() {
					$.ajax({
						url:'form_add_class.php',
						success: function (response){ 
							$("#dialog_add_class").html("");
							$("#dialog_add_class").append(response);
						}
					});
				},
				
				buttons: {
					Save: function() {

						var class_desc = $("input#input_class")
						var submit_data = [class_desc];
					
						
						if ($("input#input_class").val() == "") {
							$("input#input_class").css({'background-color' : '#f2dede'});
							$("div#error_msg").show();
						}
						else {

							$.ajax({
								url: 'controller.php',
								data: { 
										'form' : $("#add_class_form").serializeArray(),
										'function_name':'add_class',
									  },
								type: "POST",
								success: function(response){
									// alert(response);
									var status = $('input[name=rad_status]:checked').val();
									var class_id = response;
									var enable = "<td style='text-align:center;'><div id="+ class_id +" class='rad_class_status'><input type='radio' id="+ class_id +" name="+ class_id +" value='1' checked><label for="+ class_id +">Enable</label><input type='radio' id="+class_desc.val()+" name="+ class_id +" value='0'><label for="+class_desc.val()+">Disable</label></div></td>";
									var disable = "<td style='text-align:center;'><div id="+ class_id +" class='rad_class_status'><input type='radio' id="+ class_id +" name="+ class_id +" value='1'><label for="+ class_id +">Enable</label><input type='radio' id="+class_desc.val()+" name="+ class_id +" value='0' checked><label for="+class_desc.val()+">Disable</label></div></td>";
									var ch = $('table#class').find('tr').length-2; 
									var clas = $("table#class tr:nth-child("+ch+")").attr('class');
									var odd_even = (clas == 'odd') ? 'even' : 'odd';
									var user_type = ($('#ut_id').val() == '4') ? 'Restaurant Staff' : 'Restaurant Manager';
									var add_tbl_row = "<tr class= "+ odd_even +" style='display: table-row'>";
										add_tbl_row += "<td>"+class_desc.val()+"</td>";
										
										if(status == 1){
											add_tbl_row += enable;
										}
										else {
											add_tbl_row += disable;
										}
										
										add_tbl_row += "<td style='text-align:center;'><input type='checkbox' name='delete' /></td>";
										add_tbl_row += "</tr>";
										
									$('table#class').append(add_tbl_row);
									
									$( '.rad_class_status' ).buttonset();
									$( "#dialog_add_class" ).dialog('close');
									build_dialog('dialog_new_class_confirm');
									$('#dialog_new_class_confirm').dialog('open'); 
									
								}
							});

						} // else //
													
					},
					Cancel: function() {
						$("input#input_class").css({'background-color' : ''});
						$("input#input_class").val("")
						$("div#error_msg").hide();
						$( this ).dialog( "close" );
					}
				}
				
			});
		};
		/********** END: CLASS **********/
		
		// function whether to show or not to show home page //
		function do_show_home(element){
		  if($('div#content_bottom').text().trim().length == 0){
			$(element).click();
			// console.log($(element));
			
		  }
        }		
		
	});
