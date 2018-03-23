		</div>
	</div>
</div>
<div class="page-footer">
	<div class="page-footer-inner">
		 权限管理系统 开发中...
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?=static_url('global/plugins/respond.min.js')?>"></script>
<script src="<?=static_url('global/plugins/excanvas.min.js')?>"></script> 
<![endif]-->
<!-- jquery 版本兼容 -->
<script src="<?=static_url('global/plugins/jquery-migrate.min.js')?>" type="text/javascript"></script> 
<script src="<?=static_url('global/plugins/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>
<script src="<?=static_url('global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')?>" type="text/javascript"></script>
<script src="<?=static_url('global/plugins/jquery.blockui.min.js')?>" type="text/javascript"></script>
<!-- <script src="<?=static_url('global/plugins/uniform/jquery.uniform.min.js')?>" type="text/javascript"></script> -->
<!-- END CORE PLUGINS -->
<script src="<?=static_url('global/js/metronic.js')?>" type="text/javascript"></script>
<script src="<?=static_url('pages/js/quick-sidebar.js')?>" type="text/javascript"></script>
<script src="<?=static_url('pages/js/layout.js')?>" type="text/javascript"></script>
<script src="<?=static_url('global/js/md5.min.js')?>" type="text/javascript"></script>
<script src="<?=static_url('/js/WDatePicker/WdatePicker.js')?>" type="text/javascript" language="javascript"> </script>
<script src="<?=static_url('js/func.js')?>" type="text/javascript"></script>
<script src="<?=static_url('js/manage.js')?>" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {
	Layout.init(); // init current layout
   	Metronic.init(); // init metronic core components
	QuickSidebar.init(); // init quick sidebar
});
</script>
</body>
</html>