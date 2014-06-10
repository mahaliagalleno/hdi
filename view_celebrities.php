<?php

	include('scripts.php');
	$data = json_decode($_POST['data'],true);
	
?>
 <html>
	<head>
	
	</head>
	<body>
		<div id='alert_msg' class="" style='display:none;'></div>
		<div id='dialog-remove' style='display:none;' >Are you sure you want to delete selected files?</div>
		
		<a class="btn btn-default" id="add_celebrity" ><span class="glyphicon glyphicon-plus"></span>&nbsp;Add New Celebrity</a>
		<br/>
		<div id='form_new_celebrity' style='margin-top: 10px;'>
			<form class="form-horizontal" role="form" style='display:none;' id='form_celebrity'>
			
				<div class="form-group">	
					<label for="inputName" class="col-sm-3 control-label">Celebrity:</label>
					<div class="col-sm-8">
					  <input type="name" class="form-control" name="celebrity_name" placeholder="Full Name">
					</div>
				</div>
				
				<div class="form-group">			  
				   <label for="lbl_best_seller" class="col-sm-3 control-label">Status :</label>
				   <div class="col-sm-8">
						<div id="radioset_celebrity_status">
						 <input type="radio" id="rad_celebrity_status_1" name="radio_celebrity_status" value="1" checked >
						 <label for="rad_celebrity_status_1">Enable</label>
						 <input type="radio" id="rad_celebrity_status_2" name="radio_celebrity_status" value="0" >
						 <label for="rad_celebrity_status_2">Disable</label>
						</div>
				   </div>
				</div>
			    <div class="form-group">
				   <div class="col-sm-offset-3 col-sm-8">
				     <button type="button" class="btn btn-default" id='submit_celebrity'>Submit</button>
				   </div>
			    </div>
			</form>
		</div>
		
		<div id='results'>
		
		<table class="normal" id="searchtable" border="0" cellspacing="4" cellpadding="0" style="display:none; width: 100%; margin-bottom: 10px;">
			<tr>
				<td width="80%">
					Search / Filter:  <select id="searchOn" name="searchOn" style="display:none;"/>&nbsp;&nbsp;
					<input name="search" type="text" id="search" style="display:none;" />
				</td>
				<td width="20%">
					<div id="loader" style="display:none;"><img src="css/images/loader.gif" alt="Laoder" /></div>
				</td>
			</tr>	
		</table><!-- /searchtable -->
		<form  id='list_celebrity'>
		<table width="100%" id="celebrity" class="advancedtable" border="0" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th>Name of Celebrity</th>
					<th style="text-align: center;">Status</th>
					<th style="text-align: center; display:none;">Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($data as $val)
					{
						
						extract($val);
						$rad_id1 = $celebrity_id."_a";
						$rad_id2 = $celebrity_id."_b";
						
						$enable = "
								<div id='$celebrity_id' class='rad_celebrity_status'>
									<input type='radio' id='$rad_id1' name='$celebrity_id' value='1' checked/>
									<label for='$rad_id1'>Enable</label>
									<input type='radio' id='$rad_id2' name='$celebrity_id' value='0'/>
									<label for='$rad_id2'>Disable</label>
								</div>";
						$disable = "
								<div id='$celebrity_id' class='rad_celebrity_status'>
									<input type='radio' id='$rad_id1' name='$celebrity_id' value='1'/>
									<label for='$rad_id1'>Enable</label>
									<input type='radio' id='$rad_id2' name='$celebrity_id' value='0' checked/>
									<label for='$rad_id2'>Disable</label>
								</div>
						";
						
						echo "
						<tr> 
							<td class='$celebrity_id'>$celebrity</td>
							
							<td>";
							if($celebrity_status == 0){ echo $disable;	}else{echo $enable;}
								
						echo "</td>
							<td style='text-align: center; display:none;'>
								<input type='checkbox' id='$celebrity_id' name='celebrity_delete' />
							</td>
						</tr>
						";
						
					}
				?>
			</tbody>
		</table><!-- /staff -->
		</form>
		<div class='nav_buttons'>
		<a class="btn btn-default" id="remove_celebrity" style='float:right;' disabled><span class="glyphicon glyphicon-remove"></span>&nbsp;Delete Selected</a>
		<a class="btn btn-default" id="update_celebrity" style='float:right;' ><span class="glyphicon glyphicon-saved"></span>&nbsp;Save Updates</a>	
		</div>
	
		<script language="javascript" type="text/javascript">
			$(document).ready(function() {
				$("#radioset_status").buttonset();
				$('select#searchOn').children().remove();
				$("#searchtable").show();
				$("table#celebrity").advancedtable({searchField: "#search", loadElement: "#loader", searchCaseSensitive: false, ascImage: "css/images/up.png", descImage: "css/images/down.png", searchOnField: "#searchOn", sorting: false});
			});
		</script>
	</body>
</html>