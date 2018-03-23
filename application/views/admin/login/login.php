<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.0
Version: 3.3.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Metronic | Login Options - Login Form 4</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->

<link href="<?=static_url('global/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?=static_url('global/plugins/uniform/css/uniform.default.css');?>" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?=static_url('pages/css/login.css')?>" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?=static_url('global/css/components.min.css')?>" id="style_components" rel="stylesheet" type="text/css"/>
<!-- <link href="../../assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="../../assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="../../assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="../../assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/> -->
<!-- END THEME STYLES -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
		后台管理系统
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
		<div class="form-title">
			<span class="form-title">Welcome.</span>
			<span class="form-subtitle">Please login.</span>
		</div>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
			Enter any username and password. </span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">用户名</label>
			<input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username"/>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">密码</label>
			<input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>
		</div>
		<?php

if ($isDis) :
    ?>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">验证码</label>
			<input class="form-control form-control-solid placeholder-no-fix" style='width:50%' type="password" autocomplete="off" placeholder="code" name="code"/>
		</div>
		<?php endif;

?>
		<div class="login-options">
			<h4>测试账号 admin</h4>
			<h4>测试密码 admin</h4>
			<h4><strong>欢迎进群讨论(企鹅)</strong> 669852173</h4>
			<a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=7afc186a1fc8d364c2f7b9e0b184df09fc43fe1fd881da33057bb497e4ef356b"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="gophper" title="gophper"></a>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary btn-block uppercase">Login</button>
		</div>
		<div class="form-actions">
			<!--  <div class="pull-left">
				<label class="rememberme check">
				<input type="checkbox" name="remember" value="1"/>Remember me </label>
			</div>
			<div class="pull-right forget-password-block">
				<a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
			</div>-->
		</div>
	<!-- END LOGIN FORM -->
	<!-- BEGIN FORGOT PASSWORD FORM -->
<!-- 	<form class="forget-form"  method="post">
		<div class="form-title">
			<span class="form-title">Forget Password ?</span>
			<span class="form-subtitle" id="errormsg"></span>
		</div>
		<div class="form-group">
			<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
		</div>
		<div class="form-actions">

		</div>
	</form> -->
</div>
<div class="copyright hide">
	 2014 © Metronic. Admin Dashboard Template.
</div>
<!-- END LOGIN -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?=static_url('global/plugins/respond.min.js')?>"></script>
<script src="<?=static_url('global/plugins/excanvas.min.js')?>"></script> 
<![endif]-->
<script src="<?=static_url('global/plugins/jquery.min.js')?>" type="text/javascript"></script>
<!-- jquery 版本兼容 -->
<script src="<?=static_url('global/plugins/jquery-migrate.min.js')?>" type="text/javascript"></script>
<script src="<?=static_url('global/plugins/jquery.blockui.min.js')?>" type="text/javascript"></script>
<script src="<?=static_url('global/plugins/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>
<!-- cookie插件 -->
<script src="<?=static_url('global/plugins/jquery.cokie.min.js')?>" type="text/javascript"></script>
<script src="<?=static_url('global/plugins/uniform/jquery.uniform.min.js')?>" type="text/javascript"></script>


<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- 表单验证插件 -->
<script src="<?=static_url('global/plugins/jquery-validation/js/jquery.validate.min.js')?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?=static_url('global/js/metronic.js')?>" type="text/javascript"></script>
<script src="<?=static_url('global/js/md5.min.js')?>" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {     
	Metronic.init(); // init metronic core components
	//Login.init();
});

$(function(){
	$("button[type='submit']").bind("click",function(){
		var param= GetRequest();
		$go = param['go']?param['go']:"/";

		if( $("input[name='username']").val()=='' || $("input[name='password']").val()==''){
			alert("密码或账户不能为空");
		}else{
			$.ajax({
				type:'post',
                url:'/m/auth/login',
				dataType:'json',				
				data:{
					uname:$("input[name='username']").val(),
					pwd:md5($("input[name='password']").val()),
					code:$("input[name='code']").val()
				},
				success:function (result){					
					if(result.code==1){
						console.log($go);
						window.location.href=$go;
					}else{
						alert(result.msg);
					}
				},
				error:function(){
					alert('error');
					
				}
			});
		}
	});

	$(document).keydown(function(event){
		if(event.keyCode==13){
			$("button[type='submit']").click();
	    }
	})
	function GetRequest() { 
		var url = location.search; //获取url中"?"符后的字串 
		var theRequest = new Object(); 
		if (url.indexOf("?") != -1) { 
		var str = url.substr(1); 
		strs = str.split("&"); 
		for(var i = 0; i < strs.length; i ++) { 
		theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]); 
		} 
		} 
		return theRequest; 
		} 
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>