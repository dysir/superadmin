<script src="<?=static_url('js/editright.js')?>" type="text/javascript"></script>
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
<input type="" id="uid" name="" value="<?php echo $_GET['id'];?>" style="display: none;">
<div id="editright">
	
</div>
<hr>
<div class="row">
	<div class="col-md-12">
		<button class="btn blue saveright">保存</button>
		<button class="btn btn-info clearright">清空选项</button>
		<a class="btn default" href="/m/user/index">返回</a>
	</div>
</div>