$(document).ready(function(){

	var win_width = window.innerWidth/1.3;
	var win_height = window.innerHeight/1.05;

	radio_buttonset( "#radioset_celebrity_status" );
	
	setTimeout(function(){
		radio_buttonset(".rad_celebrity_status");
		$('input[name=celebrity_delete]').change(function(){
			var checked = $('input[name=celebrity_delete]:checked').length > 0;
			if (checked){
				$('#remove_celebrity').removeAttr('disabled');
			}else{
				$('#remove_celebrity').attr('disabled','disabled');
			}
		})
	,400});

	$('a#add_celebrity').click(function(){
	   $('form#form_celebrity').slideToggle('fast');
	});
	
	$('button#submit_celebrity').click(function(){
		var celebrity_name = $('input[name=celebrity_name]');
		var celebrity_status = $('input[name=radio_celebrity_status]:checked').val();
		var required = [celebrity_name];
		
		var count_err = check_required_fields(required);
	
		if(count_err == 0)
		{	
			$.ajax({
				type: 'POST',
				url:'controller.php',
				data: {'celebrity':celebrity_name.val(),'celebrity_status':celebrity_status,'function_name':'add_celebrity'},
				success: function (response){
					var rad_id1 = response+'_a';
					var rad_id2 = response+'_b';
					if(response > 0){
					
						var td = '<tr><td>'+celebrity_name.val()+'</td><td><div id="'+response+'" class="rad_celebrity_status">';
								td += '<input type="radio" id="'+rad_id1+'" name="'+response+'" value="1"/>';
								td += '<label for="'+rad_id1+'">Enable</label>';
								td += '<input type="radio" id="'+rad_id2+'" name="'+response+'" value="0"/>';
								td += '<label for="'+rad_id2+'">Disable</label>';
							td += '</div><td></tr>';
						$("table#celebrity tbody tr:first").before(td);
						var message = 'Celebrity added successfully.';
						set_alert_box('#alert_msg', 'alert alert-success', message);
						
					}else{
						var message = 'Unable to add celebrity.';
						set_alert_box('#alert_msg', 'alert alert-danger', message);
					}
					
				}
			});	
		}
	});
	
	/*
	* Author: Mahalia Rose Galleno
	* Function Name: set_alert_box
	* Usage: Confimation Message Pop up
	* Params: {Element: div element, alert_msg: alert message to be displayed,
			   alert_type: 'alert-success','alert-info','alert-warning','alert-danger'}, 
	*/
	function set_alert_box(element, alert_type, alert_msg){
		$(element).removeAttr('class');
		$(element).addClass(alert_type);
		$(element).html(alert_msg);
		$(element).fadeIn().delay(2000).fadeOut('slow');
	}
	
	$('a#remove_celebrity').click(function(){
		var selected_celebrity = [];
		$('input[name="celebrity_delete"]:checked').each(function() {
		  selected_celebrity.push(this.id);
		});
		$.ajax({
			type: 'POST',
			url:'controller.php',
			data: {'data':selected_celebrity,'function_name':'delete_celebrity'},
			success: function (response){
				var message = 'All selected files are deleted.';
				set_alert_box('#alert_msg', 'alert alert-success', message);
				$('input[name="celebrity_delete"]:checked').each(function() {
				  $(this).closest('tr').remove();
				});	
			}
		});	
	});

	/*
		Author: Mahalia Rose
		Function Name: radio_buttonset
		Usage: Add function to radio button
		Parameter: input element
	*/
	function radio_buttonset(element){
		$(element).buttonset();
		$(element + ' span').css({
		   'font-weight' : 'initial',
		   'font-family' : 'Calibri',
		   'font-size' : 'initial',
		});
		$(element + ' label').css({
		   'width' : '50%',
		});
	}
		
});



		