<?php
	if(!empty($list)){
		foreach ($list as $key => $value) {
?>
<div class="col-md-12  form-inline input-group-sm" style="margin-top: 20px;">
    <div class="checkbox" style="width: 160px;">
      <label>
        <input class="maincolumevalue" type="checkbox" value="<?php echo $value['COLUMN_NAME'];?>">
        <?php echo $value['COLUMN_NAME'];?>
      </label>
    </div>
    <div style="display: none;" > 	
	    <small>标题</small>
	    <input type="text" class="form-control maincolumecomment" style="margin-left: 20px;" value="<?php echo $value['column_comment'];?>"> 
	    <label style="margin-left: 20px;" title="如字段在配置文件中配置了解释，配置信息自动作为选项搜索，否则为普通文本搜索">
        <input class="maincolumesearch" type="checkbox" value="1">
        设为搜索项
      </label>
    </div>
</div>
<?php
		}
	}
?>
<script type="text/javascript">
	$(function(){
		$(".maincolumevalue").click(function(){
			var obj = $(this);
			if(obj.attr("checked") == 'checked'){
				obj.parent().parent().nextAll().css("display",'inline');
			}else{
				obj.parent().parent().nextAll().css("display",'none');
			}
		})
	})
</script>