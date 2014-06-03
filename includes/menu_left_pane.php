
<style>
@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,600,300);
@charset 'UTF-8';
/* Base Styles */
.cssmenu,
.cssmenu ul,
.cssmenu li,
.cssmenu a {
  margin: 0;
  padding: 0;
  border: 0;
  list-style: none;
  font-weight: normal;
  text-decoration: none;
  line-height: 1;
  font-family: 'Open Sans', sans-serif;
  font-size: 14px;
  position: relative;
}
.cssmenu a {
  line-height: 1.3;
}
.cssmenu {
	float: left;
	width: 250px;
}
.cssmenu > ul > li > a {
	padding-right: 40px;
	font-size: 25px;
	font-weight: bold;
	display: block;
	background: #ed1144;
	color: #ffffff;
	border-bottom: 1px solid #ffffff;
	text-transform: uppercase;
}
.cssmenu > ul > li > a > span {
	background: #7f7f7f;
	padding: 10px;
	display: block;
	font-size: 13px;
	font-weight: 300;
	cursor: pointer;
}
.cssmenu > ul > li > a:hover {
	text-decoration: none;
}
.cssmenu > ul > li.active {
	border-bottom: none;
}
.cssmenu > ul > li.active > a {
	color: #fff;
}
.cssmenu > ul > li.active > a span {
	/*background: #bd0e36;*/
	background: #ed1144;
}
.cssmenu span.cnt {
	position: absolute;
	top: 8px;
	right: 15px;
	padding: 0;
	margin: 0;
	background: none;
}

/* Sub menu */

.cssmenu ul ul {
	display: none;
}
.cssmenu ul ul li {
	border: 1px solid #e0e0e0;
	border-top: 0;
}
.cssmenu ul ul a {
	padding: 10px;
	display: block;
	color: #7f7f7f;
	font-size: 13px;
	margin-left: 15px;
}
.cssmenu ul ul a:hover {
	color: #bd0e36;
}
.cssmenu ul ul li {
	background: #ffffff;
}
.cssmenu ul ul li.even {
	background: #fff;
}
</style>

<script>
$(document).ready(function(){

	$('.cssmenu > ul > li > a').click(function() {
		$('.cssmenu li').removeClass('active');
		$(this).closest('li').addClass('active');
		var checkElement = $(this).next();
		
		if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
			$(this).closest('li').removeClass('active');
			checkElement.slideUp('normal');
		}
		if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			$('.cssmenu ul ul:visible').slideUp('normal');
			checkElement.slideDown('normal');
		}
		if($(this).closest('li').find('ul').children().length == 0) {
			return true;
		} else {
			return false;	
		}		
	});
	
	$('div.cssmenu').find('a').children('span').click(function() {
		$('h4#menu_label').text($(this).text());
	});
});
</script>
<!-- SYSTEM ADMIN -->
<div id="system_admin" style="display: none;">
	<div class='cssmenu'>
		<ul>
			<li class='has-sub' style=""><a><span>USER MGMT</span></a>
				<ul>
					<li><a href='#' id="restaurants"><span>Restaurants</span></a></li>
					<li><a href='#' id="add_restaurant"><span>Add Restaurant</span></a></li>
					<li><a href='#' id='sysad_report'><span>Report</span></a></li>
				</ul>
			</li>
			<li class='has-sub' style=""><a><span>CATEGORY MGMT</span></a>
				<ul>
					<li><a href='#' id="class" ><span>Class</span></a></li>
					<li><a href='#' id='product' ><span>Menus</span></a></li>
					<li><a href='#'><span>Add Menu</span></a></li>
					<li><a href='#'><span>Payment Method</span></a></li>
					<li><a href='#'><span>Add Payment Method</span></a></li>
					<li><a href='#'><span>Order Type</span></a></li>
					<li><a href='#'><span>Add Order Type</span></a></li>
					<li><a href='#'><span>Restaurant Type</span></a></li>
					<li><a href='#'><span>Add Restaurant Type</span></a></li>
				</ul>
			</li>
			<li class='has-sub' style=""><a><span>TRANSACTIONS</span></a>
				<ul>
					<li><a href='#' ><span>Pending</span></a></li>
					<li><a href='#'><span>Delivered</span></a></li>
					<li><a href='#' ><span>Cancelled</span></a></li>
				</ul>
			</li>
			<li class='has-sub' style=""><a><span>AD MANAGEMENT</span></a>
				<ul>
					<li><a href='#' ><span>Front</span></a></li>
					<li><a href='#'><span>Top</span></a></li>
					<li><a href='#' ><span>Right</span></a></li>
					<li><a href='#' ><span>Bottom</span></a></li>
					<li><a href='#' ><span>Left</span></a></li>
				</ul>
			</li>
		</ul>
	</div>
</div><!-- /system_admin -->

<!-- RESTAURANT ADMIN -->
<div id="resto_admin" style="display: none;">
	<div class='cssmenu'>	
		<ul>
			<li class='has-sub' style=""><a><span>USER MGMT</span></a>
				<ul>
					<li><a href='#' id='product'><span>Products</span></a></li>
					<li><a href='#' id='manager'><span>Manager</span></a></li>
					<li><a href='#'><span>Brand</span></a></li>
					<li><a href='#' id='product'><span>Branches</span></a></li>
					<li><a href='#' id='staff'><span>Add Branches</span></a></li>
					<li><a href='#' id='resadmin_report'><span>Report</span></a></li>
				</ul>
			</li>
			<li class='has-sub' style=""><a><span>TRANSACTIONS</span></a>
				<ul>
					<li><a href='#' ><span>Pending</span></a></li>
					<li><a href='#'><span>Delivered</span></a></li>
					<li><a href='#' ><span>Cancelled</span></a></li>
				</ul>
			</li>
			<li class='has-sub' style=""><a><span>AD MANAGEMENT</span></a>
				<ul>
					<li><a href='#' ><span>Front</span></a></li>
					<li><a href='#'><span>Top</span></a></li>
					<li><a href='#' ><span>Right</span></a></li>
					<li><a href='#' ><span>Bottom</span></a></li>
					<li><a href='#' ><span>Left</span></a></li>
				</ul>
			</li>
		</ul>
	</div><!-- /cssmenu -->
</div><!-- /resto_admin -->

<!-- MANAGER -->
<div id="manager" style="display: none;">
	<div class='cssmenu'>		
		<ul>	
			<li class='has-sub'><a><span>USER MGMT</span></a>
				<ul>
					<li><a href='#'  id = 'staff'><span>Staff</span></a></li>
				</ul>
			</li>
			<li class='has-sub'><a><span>FOOD MGMT</span></a>
				<ul>
					<li><a href='#' id= 'product'><span>Foods</span></a></li>
					<li><a href='#' id= 'add_product'><span>Add Foods</span></a></li>
				</ul>
			</li>
			<li class='has-sub' style=""><a><span>TRANSACTIONS</span></a>
				<ul>
					<li><a href='#'  id = 'all_trans'><span>All</span></a></li>
					<li><a href='#' id = 'pending_trans' ><span>Pending</span></a></li>
					<li><a href='#' id = 'delivered_trans'><span>Delivered</span></a></li>
					<li><a href='#' id = 'cancelled_trans' ><span>Cancelled</span></a></li>
				</ul>
			</li>
		</ul>
	</div><!-- /cssmenu -->
</div><!-- /manager -->

<!-- STAFF -->
<div id="staff" style="display: none;">	
	<div class='cssmenu'>		
		<ul>	
			<li class='has-sub'><a><span>FOOD MGMT</span></a>
				<ul>
					<li><a href='#'><span>Foods</span></a></li>
					<li><a href='#'><span>Add Foods</span></a></li>
				</ul>
			</li>
			<li class='has-sub' style=""><a><span>TRANSACTIONS</span></a>
				<ul>
					<li><a href='#' ><span>Pending</span></a></li>
					<li><a href='#'><span>Delivered</span></a></li>
					<li><a href='#' ><span>Cancelled</span></a></li>
				</ul>
			</li>
		</ul>
	</div><!-- /cssmenu -->
</div><!-- /staff -->
