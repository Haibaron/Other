<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>导航列表</title>
	<style type="text/css">
		.top-nav{ width:1000px;  margin:0 auto;}
		.top-nav>li{ float:left; position:relative; border-right:1px solid #51b3ff; border-left:1px solid #2473be; }
		.top-nav>li:hover, .top-nav>li.current{ background:url(../images/nav-bg.png) no-repeat left -18px top 0px;}
		.top-nav>li>a:hover, .top-nav>li .sub-nav:hover ~ a{ background:url(../images/nav-bg.png) no-repeat right -18px top 0; color:gold}
		.top-nav>li:first-child{ border-left:0;}
		.top-nav>li:last-child{ border-right:0;}
		.top-nav>li.cantactus{ border-right:0px; }
		.top-nav>li>a{ display:block; padding:0px 10px 0px;  height:50px; line-height:50px; text-align:center; color:#fff ; font-size:20px; font-family:"BankGothic";  }

		.top-nav>li .sub-nav{ position:absolute; background:#1f6cb3;  display:none; z-index:1456; top:50px; left:-1px; width:495px ; padding: 10px 5px 15px; border-bottom:2px solid #1c61a1; box-shadow:1px 3px 10px #1c609e inset; border:#1f6cb3;  }
		.top-nav>li .sub-nav li{ float:left; height:30px;  line-height:30px;  width:150px; border-top:1px solid #1c61a1; border-bottom:1px solid #2277c6 ; margin:0 7px }
		.top-nav>li .sub-nav li a:hover{ background:url(../images/nav-bg.png) no-repeat right -18px bottom 0;}
		.top-nav>li .sub-nav li:hover{ background:url(../images/nav-bg.png) no-repeat left -18px bottom 0;  }	
		.top-nav>li .sub-nav li a{ display:block;  height:30px;  line-height:30px ;padding-left:10px;  font-size:11px; color:#fff; }
		.top-nav>li:hover .sub-nav{ display:block; margin-top: 0;}
	</style>
</head>
<body>
	   <ul class="top-nav">
				<foreach name="navConfig" item="nav">
				   <li class="{$nav.code}">
						<notempty name="nav.navs">
						<ul class="sub-nav">
							<foreach name="nav.navs" item="subNav">	
								<li><a href="{$subNav.url}" title="{$subNav.title}">{$subNav.title}</a></li>
							</foreach>
								<li><a href="{:U('/Game')}">More+</a></li>
						</ul>
						</notempty>
						<a href="{$nav.url}" title="{$nav.title}">{$nav.title}<notempty name="nav.navs"></notempty></a>
					</li>
				</foreach>
			</ul>
</body>
</html>