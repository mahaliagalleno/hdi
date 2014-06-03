$(document).ready(function(){

	$('button#sign_out').click(function(){
		//alert('s');
       	$.ajax({
			type:'POST',
			url:'controller.php',
			data : {'function_name': 'logout',
					},
			success: function(res){
			     console.log(res);
				window.location.assign('index.php');
			}
		});
	});

	$('#login_form').submit(function(event){
		event.preventDefault();
		var usr = $('input[name=login]');
		var pwd = $('input[name=password]');
		var required_fields = {'username': usr, 'password' : pwd };
		var check_fields = check_required_fields(required_fields);

		$.ajax({
			type:'POST',
			url:'controller.php',
			data : {'function_name': 'sha1_pass', 'pwd' : pwd.val(),  },
			success: function(response){
				$.ajax({
					type:'POST',
					url:'controller.php',
					data : {'function_name': 'login_user',
						'usr': usr.val(),
						'pwd': response,},
					success: function(response){
					//alert(response);
						if(response != '[]'){
							$('#err_message').fadeOut();
							$.ajax({
								type:'POST',
								url:'controller.php',
								data : {'function_name': 'login_success',
									'data': response,},
								success: function(res){
									window.location.assign('home.php');
								}
							});
							
							
						}else{
							$('#err_message').text('Incorrect username/password combination');
							$('#err_message').fadeIn();
						}
					}
				});
			}
		});		
	});

});


