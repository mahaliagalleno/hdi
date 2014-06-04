
	$(document).unbind().on('ready',function(event) {

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

		if($('#homeMainContainer').length > 0){
		
			if($('input#ut_id').val() == '1'){
				do_show_home('a#face_of_edsa');
				$.isLoading("hide");
			}
		}
		
	    // Display Celebrities Page
		$('a#celebrity').unbind().one('click',function(event){
			event.stopImmediatePropagation(); 
			event.preventDefault();
			$.ajax({
				type: 'POST',
				url:'controller.php',
				data: {'function_name':'get_celebrity'},
				success: function (resp){ 
					console.log(resp);
					var obj = jQuery.parseJSON(resp);
					
					$.ajax({
						type: 'POST',
						url:'view_celebrities.php',
						data: {'data':resp},
						success: function (response){
							$('div#content_bottom').html("");
							$('div#content_bottom').append(response);
							$.isLoading("hide");	
						}
					});	
				}
			});								
		});
		
	
		 // Display Audiences Page
		$('a#audiences').one('click',function(event){
			event.stopImmediatePropagation(); 
			event.preventDefault(); 
					
			$.ajax({
				url:'view_celebrities.php',
				success: function (response){ 
						$('div#content_bottom').html("");
						$('div#content_bottom').append(response);
						
						$.isLoading("hide");
				}
			});										
		});
		
			 // Display Audiences Page
		$('a#winners').one('click',function(event){
			event.stopImmediatePropagation(); 
			event.preventDefault(); 
					
			$.ajax({
				url:'view_celebrities.php',
				success: function (response){ 
						$('div#content_bottom').html("");
						$('div#content_bottom').append(response);
						
						$.isLoading("hide");
				}
			});										
		});
	
		function call_table_plugin(table_id){
			$('select').children().remove();
			$("#searchtable").show();
			$("table#"+table_id).advancedtable({searchField: "#search", loadElement: "#loader", searchCaseSensitive: false, ascImage: "css/images/up.png", descImage: "css/images/down.png", searchOnField: "#searchOn"});
		}
	
		// function whether to show or not to show home page //
		function do_show_home(element){
		  if($('div#content_bottom').text().trim().length == 0){
			$(element).click();
			// console.log($(element));
			
		  }
        }		
		
	});
