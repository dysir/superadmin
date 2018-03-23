<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>后台管理系统</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?=static_url('global/plugins/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?=static_url('global/plugins/simple-line-icons/simple-line-icons.min.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?=static_url('global/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?=static_url('global/css/components.min.css')?>" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?=static_url('global/css/animate.css')?>" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?=static_url('pages/css/layout.css')?>" rel="stylesheet" type="text/css"/>
<link href="<?=static_url('global/plugins/uniform/css/uniform.default.css')?>" rel="stylesheet" type="text/css"/>
<script src="<?=static_url('global/plugins/jquery.min.js')?>" type="text/javascript"></script>
<link href="<?=static_url('/js/WDatePicker/skin/WdatePicker.css')?>" rel="stylesheet" type="text/css">
<link id="style_color" href="<?=static_url('pages/css/themes/default.css')?>" rel="stylesheet" type="text/css"/>

<!-- END THEME STYLES -->
<!-- <link rel="shortcut icon" href="favicon.ico"/> -->
</head>
<body class="page-header-fixed page-quick-sidebar-over-content ">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<div class="page-logo" style="font-size: 17px;margin-top: 10px;font-weight: 800;color: white;">
               后台管理 <span style="color:#d64635;">系统</span>        
        </div>
		<div class="menu-toggler sidebar-toggler hide">
		</div>
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<div class="top-menu">
			<ul class="nav navbar-nav pull-right">
				<li class="dropdown dropdown-user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<?php
						$userinfo = checkLogin();
						?>
					<img alt="" class="img-circle" src="<?=static_url('global/img/dh.jpg')?>"/>
					<span class="username username-hide-on-mobile">
					<?php echo empty($userinfo['nick_name'])?$userinfo['username']:$userinfo['nick_name'];?> </span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-default">
						<li>
							<a href="#" id="changeselfpwd">
							<i class="icon-lock"></i> 修改密码 </a>
						</li>
						<li>
							<a href="#" id="refreshRight">
							<i class="icon-calendar"></i> 权限刷新 </a>
						</li>
						<li class="divider">
						</li>
						<li>
							<a href="/m/auth/logout">
							<i class="icon-key"></i>登出 </a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="modal fade" id="changeselfpwdwindow" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">修改密码</h4>
            </div>
            <div class="errormsg">
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-body">
                	<div class="form-group">
                        <label class="col-md-3 control-label">原始密码</label>
                        <div class="col-md-9">
                            <input type="password" name="oldpwd" class="form-control input-inline input-medium" placeholder="新密码">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">新密码</label>
                        <div class="col-md-9">
                            <input type="password" name="newpwd" class="form-control input-inline input-medium" placeholder="新密码">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">放弃</button>
                <button type="button" class="btn blue save">保存</button>
            </div>
        </div>
    </div>
</div>
<div class="clearfix">
</div>
<div class="page-container">
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<div class="sidebar-toggler">
					</div>
				</li>
				<li class="sidebar-search-wrapper">
					<form class="sidebar-search " action="/">
						<a href="javascript:;" class="remove">
						<i class="icon-close"></i>
						</a>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
							<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
							</span>
						</div>
					</form>
				</li>
				<?php
    if (! empty($_menulist)) {
        $start = 0;
        
        foreach ($_menulist as $menu) {
        	$active = "";
            if (empty($menu['_list'])) {
                $active = $menu['url'] == $_current['url'] ? "active" : "";
                ?>
				<li class="<?php
                
echo $active;
                ?>">
					<a href="<?php
                
echo $menu['url'];
                ?>">
					<i class="<?php
                
echo $menu['icon'];
                ?>"></i>
					<span class="title">
					<?php
                
echo $menu['mname'];
                ?> </span>
					</a>
				</li>
				<?php
            } else {

                foreach ($menu['_list'] as $v) {
                    $v['url'] == $_current['url'] && empty($active) ? $active = " active open " : "";
                }
                ?>
				<li class="<?php
                
echo $start == 0 ? "start" : "";
                ?> <?php
                
echo empty($active)?"":$active;
                ?>">
					<a href="javascript:;">
					<i class="<?php
                
echo $menu['icon'];
                ?>"></i>
					<span class="title"><?php
                
echo $menu['mname'];
                ?></span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<?php
                foreach ($menu['_list'] as $v) {
                    $active = $v['url'] == $_current['url'] ? "active" : "";
                    ?>
						<li class="<?php
                    
echo $active;
                    ?>">
							<a href="<?php
                    
echo $v['url'];
                    ?>">
							<i class="<?php
                    
echo $v['icon'];
                    ?>"></i>
							<?php
                    
echo $v['mname'];
                    ?></a>
						</li>
						<?php
                }
                ?>
					</ul>
				</li>
				<?php
            }
            $start ++;
        }
    }
    ?>
			</ul>
		</div>
	</div>
	<div class="page-content-wrapper">
		<div class="page-content">