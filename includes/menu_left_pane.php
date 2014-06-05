
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
	background: #f36f21;
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
	background: #f36f21;
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
			checkElement.slideUp('fast');
		}
		if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			$('.cssmenu ul ul:visible').slideUp('fast');
			checkElement.slideDown('fast');
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

<div>
	<div class='cssmenu'>	
		<ul>
			<li class='has-sub' style=""><a id='face_of_edsa' ><span>FACE OF EDSA</span></a>
				<ul>
					<li><a href='#' id="celebrity"><span>Celebrity</span></a></li>
					<li><a href='#' id="audiences"><span>Audiences</span></a></li>
					<li><a href='#' id='winners'><span>Winners</span></a></li>
				</ul>
			</li>
		</ul>
	</div><!-- /cssmenu -->
</div>
