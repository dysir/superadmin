<style type="text/css">
	#leftjoincolmunlist li{
		line-height: 1.4;
		list-style: none;
	}
</style>
<?php
	if(!empty($list)){
		foreach ($list as $key => $value) {
?>
<div class="col-md-12  form-inline input-group-sm joincolumeinfolist" style="margin-top: 20px;">
    <div class="checkbox" style="width: 160px;">
      <label>
        <input class="joincolumevalue" type="checkbox" value="<?php echo $value['COLUMN_NAME'];?>">
        <?php echo $value['COLUMN_NAME'];?>
      </label>
    </div>
    <div style="display: none;" > 	
	    <small>描述</small>
	    <input type="text" class="form-control joincolumncomment" style="margin-left: 20px;" value="<?php echo $value['column_comment'];?>"> 
	    <button class="btn btn-success btn-xs leftjoincolmun" style="margin-left: 20px;">关联表字段</button>
	    <small class="leftjoincolmunvalue"></small>
	    <label style="margin-left: 20px;" title="如字段在配置文件中配置了解释，配置信息自动作为选项搜索，否则为普通文本搜索">
        	<input class="leftjoinolumesearch" type="checkbox" value="1">
        设为搜索项
      	</label>
    </div>
</div>
<div class="modal fade" id="leftjoincolmunlist" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">选择关联字段(点击确认)</h4>
			</div>
			<div class="errormsg">
			</div>
			<div class="modal-body form-horizontal">
				<div class="form-body">
					<div class="row modalcolmunlist">

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">放弃</button>
			</div>
		</div>
	</div>
</div>
<?php
		}
	}
?>
<script type="text/javascript">
	$(function(){
		$(".joincolumevalue").click(function(){
			var obj = $(this);
			if(obj.attr("checked") == 'checked'){
				obj.parent().parent().nextAll().css("display",'inline');
			}else{
				obj.parent().parent().nextAll().css("display",'none');
			}
		})

		$(".leftjoincolmun").click(function(){
			var obj = $(this);
			var arrtablelist = [];
			if(!globaldata['tableinfo']['maintable']){
				alertError("缺少主表");
				return false;
			}
			arrtablelist.push({
				'table':globaldata['tableinfo']['maintable'],
				'list':globaldata['tableinfo']['maintablecolume']
			});
			for(var i in globaldata['tableinfo']['jointablelist']){
				arrtablelist.push({
					'table':globaldata['tableinfo']['jointablelist'][i]['jointable'],
					'list':globaldata['tableinfo']['jointablelist'][i]['jointablecolume'],
				});
			}
			var columnhtml = "";
			for (var i in arrtablelist) {
				columnhtml += '<div class="col-md-6" style="margin-top: 20px;"><div class="list-group">';
				var list = arrtablelist[i]['list'];
				var table = arrtablelist[i]['table'];
				for(var ic in list){
					columnhtml += '<button type="button" class="list-group-item">'+table+'.'+list[ic]+'</button>';
				}
				columnhtml +='</div></div>';
			}
			$("#leftjoincolmunlist .modalcolmunlist").html(columnhtml);
			$("#leftjoincolmunlist").modal("show");
			$("#leftjoincolmunlist .modalcolmunlist button").off();
			$("#leftjoincolmunlist .modalcolmunlist button").on("click",function(){
				obj.next().text($(this).text());
				$("#leftjoincolmunlist").modal("hide");
				$("#leftjoincolmunlist .modalcolmunlist").html("");
			});

		})
	})
</script>