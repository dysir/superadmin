<div class="col-md-12 form-inline"  style="margin-top:20px">        
    <button class="addjointableview btn btn-warning">添加为联查表</button>
    <div class="form-group">
        <select class="form-control jointablaname">
            <?php
            if(!empty($list)){
                foreach ($list as $key => $value) {
                    echo "<option title='{$value['table_comment']}' value='{$value['table_name']}'>{$value['table_name']}</option>";
                }
            }
            ?>
        </select>
    </div>
</div>
<div class="jointablecolumn">                

</div>
<script type="text/javascript">
	$(".addjointableview").click(function(){
		var obj = $(this);
		var jointable = obj.next().find("select").val();
		var jointablelist = globaldata['tableinfo']['jointablelist'];

		var bool = true;
		for(var i in jointablelist){
			if(jointablelist[i]['jointable'] == jointable){
				bool = false;
			}
		}
		if(!bool){
			alertError("关联表已存在，或清空关联表重新添加");
			return false;
		}
		obj.attr("disabled",true);
		obj.next().find("select").attr("disabled",true);
		var param = {
			'jointable':jointable
		}
		$.loadajax({
			url:baseurl+"Createtemp/getJoinTablecolumn",
			data:param,
			success:function(res){
				if(res.code!=1)
				{
					alertError(res.msg);
					return false;
				}
				var data = res.data;
				var columnview = data['columnview'];
				obj.parent().next(".jointablecolumn").html(columnview);

				var jointablecolumn = [];
				obj.parent().next().find('.joincolumevalue').each(function(){
					jointablecolumn.push($(this).val());
				})
				var jointableobj = {
					'jointable':jointable,
					'jointablecolume':jointablecolumn
				}
				globaldata['tableinfo']['jointablelist'].push(jointableobj);
				console.log(globaldata)
			},
			error:function(){
				alertError(res.msg);
			}
		})
	})
</script>