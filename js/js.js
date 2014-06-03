var food_id = '';
var list_distinct_category = [];
var img_base = '';	


			
$(document).ready(function(){
		
	var win_width = window.innerWidth/1.3;
	var win_height = window.innerHeight/1.05;
		
	$( "#radioset_best_seller" ).buttonset();
	$( "#radioset_latest_product" ).buttonset();
	$( "#radioset_promo" ).buttonset(); 
	$( "#radioset_status" ).buttonset();
	
	function set_distinct_category(){
		
		var data = {function_name: 'get_distinct_category', branch_id : $('#br_id').val() };
		$.ajax({
			type: "POST",
			url: "controller.php",
			data: data,
			success: function(response){
			   if(response != '')
			   {
				   console.log(response);
				   var obj = jQuery.parseJSON(response);
				   $('#inp_menu_cat').find('option').remove();
				   $('form').find('#inp_menu_cat').append($("<option></option>").attr("value",'').text('Choose one')).prop('selected', true);
						
				     $.each(obj, function(k, v) {
							$('form').find('#inp_menu_cat').append($("<option></option>").attr("value",v.menu_id).text(v.menu)); 
					 });
				   
				   $('form').find('#inp_menu_cat').append($("<option></option>").attr("value",'Other Category').text('Other Category'));
					 
				}else{
						$('form').find('#inp_menu_cat').append($("<option></option>").attr("value",'').text('No Categories'));
				}
			   
			}
		});
	}
	
	function set_distinct_class(){
		var data = {function_name: 'get_distinct_class'};
		$.ajax({
			url: 'controller.php',
			data: data,
			type: "POST",
			success: function(response){
			   if(response != '')
			   {
				   var obj = jQuery.parseJSON(response);
				   $('#inp_menu_class').find('option').remove();
				   $('form').find('#inp_menu_class').append($("<option></option>").attr("value",'').text('Choose one')).prop('selected', true);
						
				   $.each(obj, function(k, v) {
							$('form').find('#inp_menu_class').append($("<option></option>").attr("value",v.class_id).text(v.class_desc)); 
					 });
				 }else{
						$('form').find('#inp_menu_class').append($("<option></option>").attr("value",'').text('No Class Available'));
				}
			   
			}
		});
	}
	
	$('#inp_menu_cat').change(function(){
		if(this.value == 'Other Category'){
			$( "#dialog-form-category" ).dialog( "open" );
		}
	});
	
	$('#dialog-form-category').dialog({
	  autoOpen: false,
	  height: 200,	 
	  width: 400,
	  position: ['center',20],
	  modal: true,
	  buttons: {
		"Add": function() {
			var val = $('#inp_menu_cat_others').val();
			if ( $("#inp_menu_cat option[value='"+val+"']").length == 0 ){
				
				var data =  {function_name: 'add_category_menu', menu: val};
				$.ajax({
					url: 'controller.php',
					data: data,
					type: "POST",
					success: function(id){
						alert(id + " " + val);
						$("<option value="+id+">"+val+"</option>").prop('selected', true).insertBefore($("#inp_menu_cat option:last"));
					}			
				});
			}else{
				alert(val + " is already exist.");
				$("<option value="+val+">"+val+"</option>").prop('selected', true);
			}
			$( this ).dialog( "close" );	
		},
		Cancel: function() { 
			$( this ).dialog( "close" );	
			$('#inp_menu_cat_others').val('');
		}
	  },
	  close: function() {	
			$('#inp_menu_cat_others').val('');
	  }
	});
					
					
	$("#dialog-confirm").dialog({
		autoOpen: false,
		height: 200,	 
		width: 400,
		position: ['center',20],
		modal: true,
		create: function( event, ui ) {
			$(this).text("Are you sure you want to delete this item?");
		},
		buttons: {
			Yes: function() {
				var data = {function_name: 'product_delete', branch_id: $('#br_id').val(), food_id: food_id};
				$.ajax({
					url: 'controller.php',
					data: data,
					type: "POST",
					success: function(data){
						$('tr.'+food_id).fadeOut();
						
					}			
				});
				$( this ).dialog( "close" );
			},
			No: function() { $( this ).dialog( "close" );	}
		}
	});
				
	$( "#dialog-form" ).dialog({
      autoOpen: false,
      height: win_height,	 
      width: win_width,
      position: ['center',20],
	  modal: true,
	  open: function() {
		$('#dialog-form').find('#btn_submit_product').hide();
		
		var data = {food_id: food_id, function_name: 'get_product'};
		
		$.ajax({
			url: 'controller.php',
			data: data,
			type: "POST",
			success: function(response){
			
				var obj = jQuery.parseJSON(response);
				
				var class_id = (!obj[0]['class_id']) ? '' : obj[0]['class_id'];
				var food_oldprice = (!obj[0]['food_oldprice']) ? 0 : obj[0]['food_oldprice'];
				var food_latest = (!obj[0]['food_latest']) ? 0 : obj[0]['food_latest'];
				var food_best_seller = (!obj[0]['food_best_seller']) ? 0 : obj[0]['food_best_seller'];
				var food_promo = (!obj[0]['food_promo']) ? 0 : obj[0]['food_promo'];
				var food_discount = ((food_oldprice/obj[0]['food_newprice'])*100);
				
				$('#dialog-form').find('#inp_menu_cat [value='+class_id+']').attr('selected','selected');
				$('#dialog-form').find('#inp_menu_name').val(obj[0]['food_title']);
				$('#dialog-form').find('#inp_menu_desc').val(obj[0]['food_desc']);
				$('#dialog-form').find('#inp_old_menu_price').val(parseFloat(food_oldprice).toFixed(2));
				$('#dialog-form').find('#inp_new_menu_price').val(parseFloat(obj[0]['food_newprice']).toFixed(2));
				$('#dialog-form').find('#inp_menu_qty').val(obj[0]['food_quantity']);
				$('#dialog-form').find('#inp_discount').val(food_discount + "%");
				$('#dialog-form').find('#inp_menu_cat [value='+obj[0]['menu_id']+']').attr('selected','selected');
				$('#dialog-form').find('div#radioset_latest_product input[value='+food_latest+']').attr("checked","checked");
				$('#dialog-form').find('div#radioset_best_seller input[value='+food_best_seller+']').attr("checked","checked");
				$('#dialog-form').find('div#radioset_promo input[value='+food_promo+']').attr("checked","checked");
				$('#dialog-form').find('div#radioset_status input[value='+obj[0]['food_status']+']').attr("checked","checked");
				$('#manage_product').prepend('<div class="form-group temporary_image"><label for="image_view" class="col-sm-3 control-label">Image</label><div class="col-sm-8"><img id="image_view" src="data:image/png;base64,'+obj[0]['food_img']+'" /></div></div>');
				
			}
		});
		$('html').find("#inp_menu_image").change(function()	{	readImage( this );	});
	  },
	  create: function( event, ui ) {	
				$('#dialog-form').load('form_product.php #manage_product');  
				set_distinct_category(); 
				set_distinct_class(); 
	  },
      buttons: {
        "Update Product": function() {
			var ok = true;
			$('#manage_product input[type=text]:not(input[name="inp_menu_cat_others"]), #manage_product textarea').each(function(){
				if(!$(this).val()){	$(this).css('background-color', '#FF8073'); console.log(this); ok = false;}
				else{ $(this).css('background-color', '#fafafa'); }			
			});
			if(ok == true) submit_product('product_edit');
        },
        Cancel: function() { $( this ).dialog( "close" );	}
      },
      close: function() {	
			$('#dialog-form').find('.temporary_image').remove();	
	  }
    });
	
	
	//page: form_product
	$('form').find('#btn_submit_product').click(function(){

		var ok = true;
		$('#content_bottom #manage_product input[type=text]:not(input[name="inp_menu_cat_others"]), #content_bottom #manage_product textarea').each(function(){
			if(!$(this).val()){	$(this).css('background-color', '#FF8073'); console.log(this); ok = false;	}
			else{	$(this).css('background-color', '#fafafa');	}			
		});
		if(ok == true)	
			submit_product('product_add');
			
	});
	
	//page: form_product, submit form
	function submit_product(function_name){
		var food_img = $('form').find('#img_base_container').text();
		alert(food_img);
		var data = {post: $('#manage_product').serializeArray() , img: food_img, function_name: function_name, branch_id: $('#br_id').val(), food_id: food_id};
		console.log(data);
		$.ajax({
			url: 'controller.php',
			data: data,
			type: "POST",
			success: function(data){
				alert(data);
			}
		});
		
	}
	


//form_product.php - bind change function
$('html').find("#inp_menu_image").change(function()	{	readImage( this );	});

//search.php - onClick Search Button
	$('form').find('#btn_search').click(function()
	{
		var search_val = $('#inp_search').val();
		
		var data = {search_val: search_val , function_name: 'search', branch_id: $('#br_id').val()};
		
		$.ajax({
			url: 'controller.php',
			data: data,
			type: "POST",
			success: function(response){
				var obj = jQuery.parseJSON(response);
				var table = "<table style='width: 90%; margin: 0 auto;' class='table' id='products'><tr><td colspan = '3'>Menu</td><td>Status</td><td>Action</td></tr></thead>";
				
				if(obj.length === 0)
				{
					table += "<tr>";
					table += "<td colspan=6>No results.</td>";							 
					table += "</tr>";
				}
				else{
					var status = '';
					//console.log(obj);
					$.each(obj, function(k, v) {
						//display the key and value pair
						status = (v.food_status == '1') ? 'Available' : "Not available";
						
						var price = parseFloat(v.food_newprice).toFixed(2);
						table += "<tr class='"+v.food_id+"'>";
							table += "<td style='width: 15%;'><img src='data:image/png;base64,"+v.food_img+"'/></td>";						
							table += "<td colspan=2><strong>"+v.food_title+"</strong><br/>";
							table += v.food_desc+"<br/>Price: " + price;
							table += "<br/>Qty: " + v.food_quantity +"</td>";
							table += "<td>"+status+"</td>";
							table += "<td><a class='btn_edit btn btn-default col-xs-12 col-sm-12 col-md-12'><span class='glyphicon glyphicon-edit'></span>&nbsp;Edit</a>";
							table +="<br/><a class='btn_delete btn btn-default col-xs-12 col-sm-12 col-md-12' style='margin-top:2px;'><span class='glyphicon glyphicon-remove'></span>&nbsp; Delete</a></td>";							
						table += "</tr>";
					});
				}
				table += "</table>";
				$('#search_result').html(table).fadeIn();
				$.isLoading("hide");
				
				$('.table').find('.btn_edit').bind('click',function(){
					food_id = $(this).closest('tr').attr('class');
					console.log("ID:" +  food_id);
					$( "#dialog-form" ).dialog( "open" );
				});
				
				$('.btn_delete').bind('click',function(){
					food_id = $(this).closest('tr').attr('class');
					console.log("ID:" +  food_id);
					$( "#dialog-confirm" ).dialog( "open" );
				});	
			},
			error: function(){	console.log('error');	
			}
		});
		
	
	});
	

	$('.rad').click(function(){	$('#inp_menu_status').val($(this).attr('id'));	});
	setTimeout(function(){$('form').find('#btn_search').click();},500);
	

	

	
	//update_profile.php - get gender button value
	$('input:radio[id=radio1]').click(function() {
		$('input#gender_val').val('M')
	})
	$('input:radio[id=radio3]').click(function(){
		$('input#gender_val').val('F')
	})
	

	//search.php - insert new product button
	$('a#add_product').on('click',function(event){
		event.stopImmediatePropagation(); 
			event.preventDefault(); 
					
					$.ajax({
						url:'form_product.php',
						success: function (response){ 
							$('div#content_bottom').html("");
							$('div#content_bottom').append(response);
							set_distinct_category();
							set_distinct_class();
							$.isLoading("hide");
						}
					});
	});
	
	
/*
function: readImage
params: input field;
usage: Convert Image to Base64_Encode
Call: e.g.,  $('html').find("#input").change(function() { readImage( this ); });
author: Mahalia Rose
*/
function readImage(input){

	if ( input.files && input.files[0] ) {
		
		var FR = new FileReader();
			FR.onload = function(e) {
				$('form').find('#img_base_container').text(e.target.result);
				img_base = $('form').find('div#img_base_container').text();
				$('#image_view').attr('src',img_base);				
			};       

			FR.readAsDataURL( input.files[0] );
		
	}

}
	
});


	