<script src="<?=static_url('js/group.js')?>" type="text/javascript"></script>

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
<input type="" id="ugid" name="" value="<?php echo $_GET['id'];?>" style="display: none;">
<div>
	<div class="row" >
		<div class="col-md-12">
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-user"></i>权限分配
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
											$checked = in_array($v['id'], $arrCurentRight)?"checked":"";
							?>
					<div class="row">
						<div class="col-md-12">
							<h4><?php echo $v['mname'];?></h4>
							<ul class="rightlist">
								<li>
									<label class="checkbox-inline">
										<div>
											<span>
												<input <?php echo $checked;?> type="checkbox" value="<?php echo $v['id'];?>">
											</span>
										</div> 本目录访问 权限 
									</label>
								</li>
								<?php
								if(!empty($actionAllList[$v['id']]))
								{
									foreach ($actionAllList[$v['id']] as $ak => $av) {
										$checked = in_array($av['id'], $arrCurentRight)?"checked":"";
								?>
								<li>
									<label class="checkbox-inline">
										<div>
											<span>
												<input <?php echo $checked;?> type="checkbox" value="<?php echo $av['id'];?>">
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
										$checked = in_array($value['id'], $arrCurentRight)?"checked":"";
							?>
					<div class="row">
						<div class="col-md-12">
							<h4><?php echo $value['mname'];?></h4>
							<ul class="rightlist">
								<li>
									<label class="checkbox-inline">
										<div>
											<span>
												<input <?php echo $checked;?> type="checkbox" value="<?php echo $value['id'];?>">
											</span>
										</div> 本目录访问 权限  
									</label>
								</li>
									<?php
									if(!empty($actionAllList[$value['id']]))
									{
										foreach ($actionAllList[$value['id']] as $ak => $av) {

											$checked = in_array($av['id'], $arrCurentRight)?"checked":"";
									?>
								<li>
									<label class="checkbox-inline">
										<div>
											<span>
												<input <?php echo $checked;?> type="checkbox" value="<?php echo $av['id'];?>">
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
</div>
<hr>
<div class="row">
	<div class="col-md-12">
		<button class="btn blue saveright">保存</button>
		<button class="btn btn-info clearright">清空选项</button>
		<a class="btn default" href="/m/group/index">返回</a>
	</div>
</div>