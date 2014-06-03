<?php
	include('scripts.php'); 
	$var_func = new var_functions();
	
	if(!isset($_SESSION)){
		session_start();
	}
	//echo "<pre>",print_r($_SESSION['auth']),"</pre>";
	if($var_func->is_logged_in()){
	    $username = ucfirst($_SESSION['auth']['0']['fname']);
		$usertype_id = ucfirst($_SESSION['auth']['0']['user_type_id']);
		$branch_id = $_SESSION['auth']['0']['branch_id'];
		$account_type = ucwords(str_replace('_', ' ' ,$_SESSION['auth']['0']['user_type']));
	} else {
		echo "<script>window.location.assign('index.php');</script>";
	}
?>

<script>
$(document).ready(function(){
	$('#menu').slicknav({
		prependTo:'#slickdiv'
	});

	$('#menu').slicknav();
	$('.slicknav_menu').attr('style','display:block;');
});		
</script>

<style>

</style>

	<table id="tbl_left">
		<tr>
			<td>
				<a href="home.php"><img src="images/ifoods_logo_2.png" /></a>
			</td>
			
		</tr>
	</table>
	
	<div id="user_box">
		<table border="0">
			<tr>
				<td>
					<div class="col-lg-6" style="width: inherit; float: right;">
						<div class="input-group">
							<input type="text" class="form-control" id="header_search" name="header_search" placeholder="Search Product" />
							<span class="input-group-btn">
								<button class="btn btn-default" type="button">Go!</button>
							</span>
						</div><!-- /input-group -->
					</div><!-- /.col-lg-6 -->
				</td>
				<td style="text-align: center;"><img src="images/brand_logo.png" /></td>
				<td>
					<div id="userBox">
						<input type = "hidden" id = "ut_id" value="<?php echo $usertype_id; ?>">
						<input type = "hidden" id = "br_id" value="<?php echo $branch_id; ?>">
						<span>Name: <?php echo $username; ?></span></br>
						<span><?php echo $account_type; ?></span>
					</div>
				</td>
				
			</tr>
		</table>
	</div>
				
	<div id="menu_button_box">
		
		<table id="menuTable" border="0">
			<tr>
				<td>
					<div id="slickdiv">
						<ul id="menu" style="display:none;">
							<li><a href="update_profile.php">My Account</a></li>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</div>
				</td>
			</tr>
		</table><!-- /menuTable -->
		
	</div><!-- /menu_button_box -->

	