<h3 class="page-title">
<?php echo $_current['mname'];?> 
</h3>
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<?php echo $_current['mname'];?> 
			<i class="fa fa-angle-right"></i>
		</li>
	</ul>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="alert alert-success">
			<strong>一级目录管理</strong>
			<a class="btn btn-xs green pull-right first_menu" href="#">
				<i class="fa fa-plus"></i> 添加一级目录 
			</a>
			<a class="btn btn-xs blue-madison pull-right sort_first_menu" href="#" style="margin-right: 20px;" sort="1">
				<i class="fa fa-sort-alpha-asc"></i> 一级目录排序
			</a>
		</div>
		<ul class="ver-inline-menu tabbable margin-bottom-10 firstmenulist animated fadeInDown">
			<?php
			if(!empty($menulist))
			{
				$active = true;
				foreach ($menulist as $menu) {

					if(!empty($_COOKIE['active']))
					{
						$active = $_COOKIE['active']=="#tab_".$menu['id']?true:false;
					}
			?>
			<li class='<?php echo $active?"active":"";?>'>
				<a data-toggle="tab" aname="<?php echo $menu['mname'];?>" aid="<?php echo $menu['id'];?>" href="#tab_<?php echo $menu['id'];?>" aria-expanded="true">
					<i style="top:0px" class="<?php echo $menu['icon'];?>"></i> <span><?php echo $menu['mname'];?></span>
					<i style="top:0px" class="icon-plus pull-right second_menu popovers" data-content="没有子目录自动作为访问目录，拥有子目录自动作为分类目录" data-original-title="添加子目录" data-container="body" data-trigger="hover"></i>
					<i style="top:0px" class="icon-trash pull-right delete_first_menu popovers" data-content="拥有子目录时，无法删除。自动删除已配置权限" data-original-title="删除当前目录" data-container="body" data-trigger="hover"></i>
					<i style="top:0px" class="icon-note pull-right first_menu" title="修改当前目录"></i> 
					<i style="top:0px" class="icon-equalizer pull-right sort_first_menu" title="排序"></i> 
				</a>
				<span class='<?php echo $active?"after":"";?>'>
				</span>
			</li>
			<?php
					$active = false;
				}
			}
			?>
		</ul>
	</div>
	<div class="col-md-8">
		<div class="alert alert-warning">
			<strong>二级目录或权限管理</strong>
		</div>
		<div class="tab-content  animated fadeInRight">
			<?php
			if(!empty($menulist))
			{
				$arrStyle = array(
					"default",
					"success",
					"warning",
					"danger",
				);
				$active = true;
				foreach ($menulist as $menu) {
					if(!empty($_COOKIE['active']))
					{
						$active = $_COOKIE['active']=="#tab_".$menu['id']?true:false;
					}
			?>
			<div id="tab_<?php echo $menu['id'];?>" class="tab-pane <?php echo $active?"active":"";?>">
				<?php
				if(!empty($menu['_list']))
				{
					$arrStatus = getTableColumnInfo("plat_menu" ,'status' ,'colmunvalue');
					foreach ($menu['_list'] as $v) {
				?>
				<div class="alert alert-info " style="padding: 0px;overflow: hidden;"  aname="<?php echo $v['mname'];?>" aid="<?php echo $v['id'];?>" atype="edit">
					<span style="position: relative;top: 8px;padding-left:5px;">
						<i class="<?php echo $v['icon'];?>"></i> <?php echo trim($v['mname']);?>
					</span>
					<a href="#" class="btn purple-plum pull-right add_action_menu" title="添加权限" style="margin-left: 5px;">
						<i class="fa fa-plus"></i> 添加
					</a>
					<a href="#" class="btn red-sunglo pull-right delete_first_menu" title="删除目录" style="margin-left: 5px;">
						<i class="fa fa-trash-o"></i> 删除
					</a>

					<a href="#" class="btn btn-primary pull-right second_menu" title="修改当前目录" style="margin-left: 5px;">
						<i class="fa fa-edit" ></i> 修改
					</a>
				</div>
				<table class="table table-hover">
					<thead>
						<tr>
							<th>权限名称</th>
							<th>权限别名</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>当前目录权限</td>
							<td><?php echo $v['action'];?></td>
							<td></td>
						</tr>
						<?php
						if(!empty($actionlist[$v['id']]))
						{
							foreach ($actionlist[$v['id']] as  $action) {
						?>
						<tr>
							<td><?php echo $action['mname'];?></td>
							<td><?php echo $action['action'];?></td>
							<td aid="<?php echo $action['id'];?>"  aname="<?php echo $action['mname'];?>">
								<button class="btn btn-xs btn-danger delete_first_menu">
								<i class="fa fa-trash-o"></i>
								删除</button>
							</td>
						</tr>
						<?php
							}
						}
						?>
					</tbody>
				</table>
				<?php
					}
				}else{
				?>
				<div aname="<?php echo $menu['mname'];?>" aid="<?php echo $menu['id'];?>" >
					<a href="#" class="btn purple-plum pull-right add_action_menu" title="添加权限" style="margin-left: 5px;">
						<i class="fa fa-plus"></i> 添加
					</a>
				</div>
				<table class="table table-hover">
					<thead>
						<tr>
							<th>权限名称</th>
							<th>权限别名</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>当前目录权限</td>
							<td><?php echo $menu['action'];?></td>
							<td></td>
						</tr>
						<?php
						if(!empty($actionlist[$menu['id']]))
						{
							foreach ($actionlist[$menu['id']] as  $action) {
						?>
						<tr>
							<td><?php echo $action['mname'];?></td>
							<td><?php echo $action['action'];?></td>
							<td aid="<?php echo $action['id'];?>"  aname="<?php echo $action['mname'];?>">
								<button class="btn btn-xs btn-danger delete_first_menu">删除</button>
							</td>
						</tr>
						<?php
							}
						}
						?>
					</tbody>
				</table>
				<?php

				}
				?>
			</div>
			<?php
					$active = false;
				}
			}
			?>
		</div>
	</div>
</div>
<style type="text/css">
	.sort li .badge{
		cursor:pointer;
	}
</style>
<div name="modals">
	<!-- 一级目录排序 -->
	<div class="modal fade" id="sort_menu" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">目录排序</h4>
				</div>
				<div class="errormsg">
				</div>
				<div class="modal-body form-horizontal">
					<div class="form-body">
						<ul class="feeds sort">
							
						</ul>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">放弃</button>
					<button type="button" class="btn blue save">保存</button>
				</div>
			</div>
		</div>
	</div>
	<!-- 添加修改一级目录 -->
	<div class="modal fade" id="firstmenu" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="alert alert-warning" style="padding: 14px;">
					权限别名若已被使用在项目中，修改将导致原权限限制失效
				</div>
				<div class="errormsg">
				</div>
				<div class="modal-body form-horizontal">
					<input type="" name="id" style="display: none;">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label">目录名</label>
							<div class="col-md-9">
								<input type="text" name="mname" class="form-control input-inline input-medium" placeholder="目录展示名 必填">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">访问地址</label>
							<div class="col-md-9">
								<input type="text" name="url" class="form-control input-inline input-medium" placeholder="格式 /class/function">
								<span class="help-block">拥有子目录的分类目录可不填写</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">权限别名</label>
							<div class="col-md-9">
								<input type="text" name="action" class="form-control input-inline input-medium" placeholder="必须填写">
								<span class="help-block">默认与访问地址相同</span>
							</div>
						</div>
						<div class="form-group menu_icon">
							<label class="col-md-3 control-label">图标</label>
							<div class="col-md-9" style="padding-top: 9px;">
								<input type="text" name="icon" class="form-control input-inline input-medium" placeholder="eg: icon-home" style="display: none;">
								<a data-toggle="modal" href="#fullicon" class="btn btn-xs btn-success">选择图标</a>
								<i style="margin-left: 10px;position: relative;top: 2px;" aria-hidden="true" class=""></i>
								<br/>
								<span class="help-block">窄屏时只展示图标 可选图标</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">是否显示</label>
							<div class="col-md-9 radio-list" style="padding-left: 35px;">
								<label class="radio-inline">
								<div class=""><span class="checked"><input type="radio" name="status" value="1" checked ></span></div> 显示 </label>
								<label class="radio-inline">
								<div class=""><span class=""><input type="radio" name="status" value="2"></span></div> 隐藏 </label>
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

	<!-- 为一级目录添加修改子目录 -->
	<div class="modal fade" id="secondmenu" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="alert alert-warning" style="padding: 14px;">
					添加子目录后，该目录将作为分类目录使用
				</div>
				<div class="errormsg">
				</div>
				<div class="modal-body form-horizontal">
					<input type="" name="id" style="display: none;">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label">目录名</label>
							<div class="col-md-9">
								<input type="text" name="mname" class="form-control input-inline input-medium" placeholder="目录展示名 必填">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">访问地址</label>
							<div class="col-md-9">
								<input type="text" name="url" class="form-control input-inline input-medium" placeholder="格式 class/function">
								<span class="help-block">必须填写</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">权限别名</label>
							<div class="col-md-9">
								<input type="text" name="action" class="form-control input-inline input-medium" placeholder="默认与访问地址相同">
								<span class="help-block">默认与访问地址相同</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">图标</label>
							<div class="col-md-9 menu_icon" style="padding-top: 9px;">
								<input type="text" name="icon" class="form-control input-inline input-medium" placeholder="eg: icon-home" style="display: none;">
								<a data-toggle="modal" href="#fullicon" class="btn btn-xs btn-success">选择图标</a>
								<i style="margin-left: 10px;position: relative;top: 2px;" aria-hidden="true" class=""></i>
								<br/>
								<span class="help-block">窄屏时只展示图标 可选图标</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">是否显示</label>
							<div class="col-md-9 radio-list" style="padding-left: 35px;">
								<label class="radio-inline">
								<div class=""><span class="checked"><input type="radio" name="status" value="1" checked ></span></div> 显示 </label>
								<label class="radio-inline">
								<div class=""><span class=""><input type="radio" name="status" value="2"></span></div> 隐藏 </label>
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

	<!-- 为目录添加权限 -->
	<div class="modal fade" id="addactionmenu" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="errormsg">
				</div>
				<div class="modal-body form-horizontal">
					<input type="" name="id" style="display: none;">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label">权限名</label>
							<div class="col-md-9">
								<input type="text" name="mname" class="form-control input-inline input-medium" placeholder="权限描述，选填">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">权限别名</label>
							<div class="col-md-9">
								<input type="text" name="action" class="form-control input-inline input-medium" placeholder="必须填写">
								<span class="help-block">必须填写且唯一</span>
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
	<!-- 图标弹窗列表 -->
	<div class="modal fade" id="fullicon" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-full">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">可选图标列表</h4>
				</div>
				<div class="alert alert-warning">
					点击选择
				</div>
				<div class="modal-body">
					<div class="simplelineicons-demo">
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-user"></span>
						&nbsp;icon-user </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-user-female"></span>
						&nbsp;icon-user-female </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-users"></span>
						&nbsp;icon-users </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-user-follow"></span>
						&nbsp;icon-user-follow </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-user-following"></span>
						&nbsp;icon-user-following </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-user-unfollow"></span>
						&nbsp;icon-user-unfollow </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-trophy"></span>
						&nbsp;icon-trophy </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-speedometer"></span>
						&nbsp;icon-speedometer </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-social-youtube"></span>
						&nbsp;icon-social-youtube </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-social-twitter"></span>
						&nbsp;icon-social-twitter </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-social-tumblr"></span>
						&nbsp;icon-social-tumblr </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-social-facebook"></span>
						&nbsp;icon-social-facebook </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-social-dropbox"></span>
						&nbsp;icon-social-dropbox </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-social-dribbble"></span>
						&nbsp;icon-social-dribbble </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-shield"></span>
						&nbsp;icon-shield </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-screen-tablet"></span>
						&nbsp;icon-screen-tablet </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-screen-smartphone"></span>
						&nbsp;icon-screen-smartphone </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-screen-desktop"></span>
						&nbsp;icon-screen-desktop </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-plane"></span>
						&nbsp;icon-plane </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-notebook"></span>
						&nbsp;icon-notebook </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-moustache"></span>
						&nbsp;icon-moustache </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-mouse"></span>
						&nbsp;icon-mouse </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-magnet"></span>
						&nbsp;icon-magnet </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-magic-wand"></span>
						&nbsp;icon-magic-wand </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-hourglass"></span>
						&nbsp;icon-hourglass </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-graduation"></span>
						&nbsp;icon-graduation </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-ghost"></span>
						&nbsp;icon-ghost </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-game-controller"></span>
						&nbsp;icon-game-controller </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-fire"></span>
						&nbsp;icon-fire </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-eyeglasses"></span>
						&nbsp;icon-eyeglasses </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-envelope-open"></span>
						&nbsp;icon-envelope-open </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-envelope-letter"></span>
						&nbsp;icon-envelope-letter </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-energy"></span>
						&nbsp;icon-energy </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-emoticon-smile"></span>
						&nbsp;icon-emoticon-smile </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-disc"></span>
						&nbsp;icon-disc </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-cursor-move"></span>
						&nbsp;icon-cursor-move </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-crop"></span>
						&nbsp;icon-crop </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-credit-card"></span>
						&nbsp;icon-credit-card </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-chemistry"></span>
						&nbsp;icon-chemistry </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-bell"></span>
						&nbsp;icon-bell </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-badge"></span>
						&nbsp;icon-badge </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-anchor"></span>
						&nbsp;icon-anchor </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-action-redo"></span>
						&nbsp;icon-action-redo </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-action-undo"></span>
						&nbsp;icon-action-undo </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-bag"></span>
						&nbsp;icon-bag </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-basket"></span>
						&nbsp;icon-basket </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-basket-loaded"></span>
						&nbsp;icon-basket-loaded </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-book-open"></span>
						&nbsp;icon-book-open </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-briefcase"></span>
						&nbsp;icon-briefcase </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-bubbles"></span>
						&nbsp;icon-bubbles </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-calculator"></span>
						&nbsp;icon-calculator </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-call-end"></span>
						&nbsp;icon-call-end </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-call-in"></span>
						&nbsp;icon-call-in </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-call-out"></span>
						&nbsp;icon-call-out </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-compass"></span>
						&nbsp;icon-compass </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-cup"></span>
						&nbsp;icon-cup </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-diamond"></span>
						&nbsp;icon-diamond </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-direction"></span>
						&nbsp;icon-direction </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-directions"></span>
						&nbsp;icon-directions </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-docs"></span>
						&nbsp;icon-docs </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-drawer"></span>
						&nbsp;icon-drawer </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-drop"></span>
						&nbsp;icon-drop </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-earphones"></span>
						&nbsp;icon-earphones </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-earphones-alt"></span>
						&nbsp;icon-earphones-alt </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-feed"></span>
						&nbsp;icon-feed </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-film"></span>
						&nbsp;icon-film </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-folder-alt"></span>
						&nbsp;icon-folder-alt </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-frame"></span>
						&nbsp;icon-frame </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-globe"></span>
						&nbsp;icon-globe </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-globe-alt"></span>
						&nbsp;icon-globe-alt </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-handbag"></span>
						&nbsp;icon-handbag </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-layers"></span>
						&nbsp;icon-layers </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-map"></span>
						&nbsp;icon-map </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-picture"></span>
						&nbsp;icon-picture </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-pin"></span>
						&nbsp;icon-pin </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-playlist"></span>
						&nbsp;icon-playlist </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-present"></span>
						&nbsp;icon-present </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-printer"></span>
						&nbsp;icon-printer </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-puzzle"></span>
						&nbsp;icon-puzzle </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-speech"></span>
						&nbsp;icon-speech </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-vector"></span>
						&nbsp;icon-vector </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-wallet"></span>
						&nbsp;icon-wallet </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-arrow-down"></span>
						&nbsp;icon-arrow-down </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-arrow-left"></span>
						&nbsp;icon-arrow-left </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-arrow-right"></span>
						&nbsp;icon-arrow-right </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-arrow-up"></span>
						&nbsp;icon-arrow-up </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-bar-chart"></span>
						&nbsp;icon-bar-chart </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-bulb"></span>
						&nbsp;icon-bulb </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-calendar"></span>
						&nbsp;icon-calendar </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-control-end"></span>
						&nbsp;icon-control-end </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-control-forward"></span>
						&nbsp;icon-control-forward </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-control-pause"></span>
						&nbsp;icon-control-pause </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-control-play"></span>
						&nbsp;icon-control-play </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-control-rewind"></span>
						&nbsp;icon-control-rewind </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-control-start"></span>
						&nbsp;icon-control-start </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-cursor"></span>
						&nbsp;icon-cursor </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-dislike"></span>
						&nbsp;icon-dislike </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-equalizer"></span>
						&nbsp;icon-equalizer </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-graph"></span>
						&nbsp;icon-graph </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-grid"></span>
						&nbsp;icon-grid </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-home"></span>
						&nbsp;icon-home </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-like"></span>
						&nbsp;icon-like </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-list"></span>
						&nbsp;icon-list </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-login"></span>
						&nbsp;icon-login </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-logout"></span>
						&nbsp;icon-logout </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-loop"></span>
						&nbsp;icon-loop </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-microphone"></span>
						&nbsp;icon-microphone </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-music-tone"></span>
						&nbsp;icon-music-tone </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-music-tone-alt"></span>
						&nbsp;icon-music-tone-alt </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-note"></span>
						&nbsp;icon-note </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-pencil"></span>
						&nbsp;icon-pencil </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-pie-chart"></span>
						&nbsp;icon-pie-chart </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-question"></span>
						&nbsp;icon-question </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-rocket"></span>
						&nbsp;icon-rocket </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-share"></span>
						&nbsp;icon-share </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-share-alt"></span>
						&nbsp;icon-share-alt </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-shuffle"></span>
						&nbsp;icon-shuffle </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-size-actual"></span>
						&nbsp;icon-size-actual </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-size-fullscreen"></span>
						&nbsp;icon-size-fullscreen </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-support"></span>
						&nbsp;icon-support </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-tag"></span>
						&nbsp;icon-tag </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-trash"></span>
						&nbsp;icon-trash </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-umbrella"></span>
						&nbsp;icon-umbrella </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-wrench"></span>
						&nbsp;icon-wrench </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-ban"></span>
						&nbsp;icon-ban </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-bubble"></span>
						&nbsp;icon-bubble </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-camcorder"></span>
						&nbsp;icon-camcorder </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-camera"></span>
						&nbsp;icon-camera </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-check"></span>
						&nbsp;icon-check </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-clock"></span>
						&nbsp;icon-clock </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-close"></span>
						&nbsp;icon-close </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-cloud-download"></span>
						&nbsp;icon-cloud-download </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-cloud-upload"></span>
						&nbsp;icon-cloud-upload </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-doc"></span>
						&nbsp;icon-doc </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-envelope"></span>
						&nbsp;icon-envelope </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-eye"></span>
						&nbsp;icon-eye </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-flag"></span>
						&nbsp;icon-flag </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-folder"></span>
						&nbsp;icon-folder </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-heart"></span>
						&nbsp;icon-heart </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-info"></span>
						&nbsp;icon-info </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-key"></span>
						&nbsp;icon-key </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-link"></span>
						&nbsp;icon-link </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-lock"></span>
						&nbsp;icon-lock </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-lock-open"></span>
						&nbsp;icon-lock-open </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-magnifier"></span>
						&nbsp;icon-magnifier </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-magnifier-add"></span>
						&nbsp;icon-magnifier-add </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-magnifier-remove"></span>
						&nbsp;icon-magnifier-remove </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-paper-clip"></span>
						&nbsp;icon-paper-clip </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-paper-plane"></span>
						&nbsp;icon-paper-plane </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-plus"></span>
						&nbsp;icon-plus </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-pointer"></span>
						&nbsp;icon-pointer </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-power"></span>
						&nbsp;icon-power </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-refresh"></span>
						&nbsp;icon-refresh </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-reload"></span>
						&nbsp;icon-reload </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-settings"></span>
						&nbsp;icon-settings </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-star"></span>
						&nbsp;icon-star </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-symbol-female"></span>
						&nbsp;icon-symbol-female </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-symbol-male"></span>
						&nbsp;icon-symbol-male </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-target"></span>
						&nbsp;icon-target </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-volume-1"></span>
						&nbsp;icon-volume-1 </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-volume-2"></span>
						&nbsp;icon-volume-2 </span>
						</span>
						<span class="item-box">
						<span class="item">
						<span aria-hidden="true" class="icon-volume-off"></span>
						&nbsp;icon-volume-off </span>
						</span>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- 删除目录弹窗 -->
	<div class="modal fade" id="deletemenu" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title"></h4>
				</div>
				<input value="" name="id" style="display: none;">
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">放弃</button>
					<button type="button" class="btn btn-danger deletesure">确认删除</button>
				</div>
			</div>
		</div>
	</div>

</div>