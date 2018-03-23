<style type="text/css">
	.rightlist li{
		float: left;
		width: 200px;
		word-wrap:break-word; 
	}
	.rightlist{
		list-style-type:none
	}
</style>
<?php
	if(!empty($arrGroup))
	{
?>
<div class="row" >
	<div class="col-md-12">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-users"></i>权限组管理
				</div>
			</div>
			<div class="portlet-body">
				<div class="row grouplist">
					<div class="col-md-12">
						<ul class="rightlist">
							<?php
								foreach ($arrGroup as $gk => $gv) {
									$checked = in_array($gv['id'], $arrCurentGroup)?"checked":"";
							?>
							<li>
								<label class="checkbox-inline">
									<div>
										<span>
											<input <?php echo $checked;?> type="checkbox" value="<?php echo $gv['id'];?>">
										</span>
									</div> <?php echo $gv['gname'];?> 权限 
								</label>
							</li>
							<?php
								}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	}
?>
<div class="row" >
	<div class="col-md-12">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-user"></i>独立权限分配
				</div>
			</div>
			<div class="portlet-body rightare">

						<?php
						if(!empty($arrAllMenuKv))
						{
							foreach ($arrAllMenuKv as $key => $value) {
								if(!empty($value['_list']) )
								{
									foreach ($value['_list'] as $k => $v) {
										if(!in_array($v['action'], $arrRight))
										{
											continue;
										}
										$checked = in_array($v['action'], $arrCurentRight)?"checked":"";
						?>
				<div class="row">
					<div class="col-md-12">
						<h4><?php echo $v['mname'];?></h4>
						<ul class="rightlist">
							<li>
								<label class="checkbox-inline">
									<div>
										<span>

											<input <?php echo $checked;?> type="checkbox" value="<?php echo $v['action'];?>">
										</span>
									</div> 本目录访问 权限 
								</label>
							</li>
							<?php
							if(!empty($actionAllList[$v['id']]))
							{
								foreach ($actionAllList[$v['id']] as $ak => $av) {
									if(!in_array($av['action'], $arrRight))
									{
										continue;
									}
									$checked = in_array($av['action'], $arrCurentRight)?"checked":"";
							?>
							<li>
								<label class="checkbox-inline">
									<div>
										<span>
											<input <?php echo $checked;?> type="checkbox" value="<?php echo $av['action'];?>">
										</span>
									</div> <?php echo $av['mname'];?> 
								</label>
							</li>
							<?php
								}
							}
							?>
						</ul>
					</div>
				</div>
						<?php		
									}
								}else{
									if(!in_array($value['action'], $arrRight))
									{
										continue;
									}
									$checked = in_array($value['action'], $arrCurentRight)?"checked":"";
						?>
				<div class="row">
					<div class="col-md-12">
						<h4><?php echo $value['mname'];?></h4>
						<ul class="rightlist">
							<li>
								<label class="checkbox-inline">
									<div>
										<span>
											<input <?php echo $checked;?> type="checkbox" value="<?php echo $value['action'];?>">
										</span>
									</div> 本目录访问 权限  
								</label>
							</li>
								<?php
								if(!empty($actionAllList[$value['id']]))
								{
									foreach ($actionAllList[$value['id']] as $ak => $av) {

										if(!in_array($av['action'], $arrRight))
										{
											continue;
										}
										$checked = in_array($av['action'], $arrCurentRight)?"checked":"";
								?>
							<li>
								<label class="checkbox-inline">
									<div>
										<span>
											<input <?php echo $checked;?> type="checkbox" value="<?php echo $av['action'];?>">
										</span>
									</div> <?php echo $av['mname'];?> 
								</label>
							</li>
								<?php
									}
								}
								?>
						</ul>
					</div>
				</div>
				<?php
								}
							}
						}
						?>
			</div>
		</div>
	</div>
</div>