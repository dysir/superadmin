<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="utf-8"/>
	<title>后台管理系统</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta content="" name="description"/>
	<meta content="" name="author"/>
	<link href="/static/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="/static/global/plugins/jquery.min.js" type="text/javascript"></script>
	<script src="/static/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<style type="text/css">	
	.login{
		   background-color: #5c97bd;
	}
	.container{
		background-color: white;
		margin-top: 20px;
		padding-bottom: 20px;
	}
	.container label{
		text-align: right;
	}
	.right{
		color: green;
	}
	.error{
		color: red;
	}
	.items{
		margin-top: 10px;
	}
	pre{
		height: 400px;
	}
</style>
<body class="login">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header">
				  <h1>安装 <small>后台管理系统</small></h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="row items">
					<div class="form-group">
				    	<label class="col-md-3">php 版本</label>
				    	<span class="col-md-4">
				    		<?php
				    			echo PHP_VERSION;
				    		?>
				    	</span>
				    	<span class="col-md-5">
				    		<?php
				    		if(version_compare(PHP_VERSION, '5.4', '>=') ){
				    			echo "<span class='right'>√</span>";
				    		}else{
				    			echo "<span class='error'>x</span>";
				    		}
				    		?>
				    	</span>
				  	</div>
				</div>
				<div class="row items">
					<div class="form-group">
				    	<label class="col-md-3">环境</label>
				    	<span class="col-md-4">
				    		<?php
				    			echo PHP_SAPI;
				    		?>
				    	</span>
				    	<span class="col-md-5">
							<?php
				    		if(in_array(PHP_SAPI, ['fpm-fcgi','cgi-fcgi','apache2handler']) ){
				    			echo "<span class='right'>√</span>";
				    		}else{
				    			echo "<span class='error'>x</span>";
				    		}
				    		?>
				    	</span>
				  	</div>
				</div>
				<?php
					if(PHP_SAPI == "apache2handler"){
				?>
				<div class="row items">
					<div class="form-group">
				    	<label class="col-md-3">mod_rewrite</label>
				    	<span class="col-md-4">
				    		<?php
				    			if(isRewriteMod()){
				    				echo "开启";
				    			}else{
				    				echo "未开启";
				    			}
				    		?>
				    	</span>
				    	<span class="col-md-5">
							<?php
				    		if(isRewriteMod() ){
				    			echo "<span class='right'>√</span>";
				    		}else{
				    			echo "<span class='error'>x</span>";
				    		}
				    		?>
				    	</span>
				  	</div>
				</div>
				<?php
					}elseif(PHP_SAPI == "fpm-fcgi"||PHP_SAPI == "cgi-fcgi"){
				?>
				<div class="row items">
					<div class="form-group">
				    	<label class="col-md-3">重定向</label>
				    	<span class="col-md-9" >
				    		nginx需配置重定向隐藏index.php(已配置请忽略) eg:
				    		<a href="/install/test.conf" target="_blank">查看</a>
				    	</span>
				  	</div>
				</div>
				<?php
					}
				?>
				<div class="row items">
					<div class="form-group">
				    	<label class="col-md-3">配置权限</label>
				    	<span class="col-md-9">
				    		<?php
				    		$path = "../../application/config";
				    		if(!is_writable($path)){
				    			echo "配置文件目录没有权限，请手动配置数据库配置文件database.php，并复制到application/config目录下";
				    		}else{
				    			echo "<span class='right'>√</span>";
				    		}
				    		?>
				    	</span>
				  	</div>
				</div>
				<div class="row items form-horizontal" style="margin-top: 50px;">
					<div class="form-group">
				    	<label class="col-md-3">数据库地址(ip)</label>
				    	<div class="col-md-9">
				    		<input id="host" class="form-control" type="" name="">
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label class="col-md-3">用户名</label>
				    	<div class="col-md-9">
				    		<input id="name" class="form-control" type="" name="">
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label class="col-md-3">密码</label>
				    	<div class="col-md-9">
				    		<input id="pwd" class="form-control" type="" name="">
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label class="col-md-3">数据库名</label>
				    	<div class="col-md-9">
				    		<input id="dbname" class="form-control" type="" name="">
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<div class="col-md-12" style="text-align: right;">
				    		<button class="btn btn-danger" onclick="createDB()">创建</button>
				    	</div>
				  	</div>
				</div>

			</div>
			<div class="col-md-6">
				<pre><p id="createDB"></p><p id="createconfig"></p><p id="createlock"></p></pre>
			</div>
		</div>

	</div>
</body>
<?php
function isRewriteMod()
{
  if (function_exists('apache_get_modules'))
  {
    $aMods = apache_get_modules();
    $bIsRewrite = in_array('mod_rewrite', $aMods);
  }
  else
  {
    $bIsRewrite = (strtolower(getenv('HTTP_MOD_REWRITE')) == 'on');
  }
  return $bIsRewrite;
}
?>

<script type="text/javascript">

var host ="";
var name ="";
var pwd ="";
var dbname ="";


function createDB(){
	$("#createDB").html("数据库创建中...");
	host = $("#host").val();
	name = $("#name").val();
	pwd = $("#pwd").val();
	dbname = $("#dbname").val();

	if(!host||!name||!pwd||!dbname){
		alert("缺少数据库配置参数");
		return false;
	}
	$.ajax({
		url:"/install/cdb.php",
		type:"post",
		data:{
			host:host,
			name:name,
			pwd:pwd,
			dbname:dbname,
		},
		success:function(res){
			if(res.code!=1){
				$("#createDB").html("<span style='color:red'>"+res.msg+"</span>");
			}else{
				$("#createDB").html("<span style='color:green'>数据库创建成功</span>");
				createconfig();
			}
		},
		error:function(){
			$("#createDB").html("<span style='color:red'>数据库创建失败</span>");
		}
	})
}

function createconfig(){
	$("#createconfig").html("创建数据库配置文件...");
	host = $("#host").val();
	name = $("#name").val();
	pwd = $("#pwd").val();
	dbname = $("#dbname").val();

	if(!host||!name||!pwd||!dbname){
		alert("缺少数据库配置参数");
		return false;
	}
	$.ajax({
		url:"/install/createconfig.php",
		type:"post",
		data:{
			host:host,
			name:name,
			pwd:pwd,
			dbname:dbname,
		},
		success:function(res){
			if(res.code!=1){
				$("#createconfig").html("<span style='color:red'>创建失败，查看application/config目录是否没有创建权限，或手动配置database.php文件并复制到application/config目录下即可</span>");
			}else{
				$("#createconfig").html("<span style='color:green'>数据库配置文件创建成功</span>");
				createlock();
			}
		},
		error:function(){
			$("#createconfig").html("<span style='color:red'>创建失败，查看application/config目录是否没有创建权限，或手动配置database.php文件并复制到application/config目录下</span>");
		}
	})
}
function createlock(){
	$("#createlock").html("创建锁文件...");

	if(!host||!name||!pwd||!dbname){
		alert("缺少数据库配置参数");
		return false;
	}
	$.ajax({
		url:"/install/createlock.php",
		success:function(res){
			if(res.code!=1){
				$("#createlock").html("<span style='color:red'>创建失败，查看根目录是否没有创建权限，或手动在根目录创建lock文件即可</span>");
			}else{
				$("#createlock").html("<span style='color:green'>锁文件创建成功</span><a href='/'>跳转首页</a>");
				window.location.href='/';
			}
		},
		error:function(){
			$("#createlock").html("<span style='color:red'>创建失败，查看根目录是否没有创建权限，或手动在根目录创建lock文件即可</span>");
		}
	})
}

</script>