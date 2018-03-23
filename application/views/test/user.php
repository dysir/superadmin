<select class='form-control input-inline' id='changeuser'>
<option value='-1'>--切换用户(测试权限使用)</option>
<?php foreach($user as $key=>$value):?>
<option value="<?php echo $value['id'];?>"><?php echo $value['username'];?></option>
<?php endforeach;?>
</select><span> 切换用户只限测试使用,正式的时候，需要把此接口删掉</span>

<script>
$(document).ready(function(){
	$("#changeuser").change(function(){
		$id = $("#changeuser").val();
		if ($id==-1){
			return false;
		}
		var param={
              id:$id
				};
		$.ajax({
            url:"/test/order/ajaxChangeUser",
            type:'post',
            data:param,
            success:function(res){
                if (res.code==1) {
                    alert("切换用户成功");
                    location.reload();
                }else{
                    alert("切换失败:"+res.msg);
                }  
            },
            error:function()
            {
                
            },
            complete:function(){
                
            }
        });
	});
});
</script>