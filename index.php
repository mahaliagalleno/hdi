<?php
	include('scripts.php');
	include('var_functions.php');
	
	$var_func = new var_functions();
    if($var_func->is_logged_in()){

		echo "<script>  window.location.assign('home.php'); </script>"; 
		die();
	}

 ?>
<style>

</style>

<body id="login_body">
 
<div id="loginMainContainer">
 
<div id="logoBox"><img src="images/ifoods_logo.png" /></div>
 
<div id="containerBox">
		
	<div id="BoxHeader"><table><tr><td>LOGIN TO ADMIN PANEL</td></tr></table></div>
	
	<form method="post" action="#" id="login_form" target="_top">

		<div id = "err_message" style = "background-color:#FF8073; display:none;"></div>
			
		<table class='formTable' border="0">
			<tr>
				<td>Username</td><td>Password</td>
			</tr>
			<tr>
				<td class="td_padding_left"><input type="text" id="login_username" name="login"></td><td class="td_padding_left"><input type="password" id="login_password" name="password"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="hidden" name="function_name" value="login_user"></td>
			</tr>

			<tr>
				<td><a href="">Forgot your password?</a></td>
				<td><input type="submit" value="Login"></td>
			</tr>
		</table>
		
	</form>

	<div id="BoxFooter" style=""><span class="glyphicon glyphicon-copyright-mark"></span><span> iFoods Corporation | All Rights Reserved 2014</span></div>
	
</div><!-- /containerBox -->

</div><!-- /loginMainContainer -->

</body><!-- /login_body -->

