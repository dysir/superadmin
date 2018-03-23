$(function(){
	$("#addgroup .save").click(function(){
		var gname = $("#addgroup input[name='gname']").val();
		if(!gname)
		{
			$("#addgroup input[name='gname']").parent().parent().addClass('has-error');
			return false;
		}else{
			$("#addgroup input[name='gname']").parent().parent().removeClass('has-error');
		}
		$("#addgroup").modal("hide");
		$.loadajax({
			url:baseurl+"Group/ajaxAddGroup?gname="+gname,
			success:function(res)
			{
				if(res.code==1)
				{
					location.reload();
				}else{
					alertError(res.msg);
				}
			},
			error:function(){
				alertError("添加失败，请稍后重试");
			}
		})
	})
	$(".delete").on("click",function(){
        var obj = this;
        $("#delete").modal("show");
        var id = $(this).attr("aid");
        $("#delete .sure").off();
        $("#delete .sure").on("click",function(){

            $("#delete").modal("hide");
            $.loadajax({
                url:baseurl+"Group/ajaxDelGroup?id="+id,
                success:function(res)
                {
                    if(res.code == 1)
                    {
                        $(obj).parent().parent().remove();
                    }else{
                        alertError(res.msg);
                    }
                },
                error:function()
                {
                    alertError("请稍后重试");
                }
            })
        })
    })
    $(".saveright").click(function(){
		var right = [];
		$(".rightare input").each(function(){
			$(this).is(':checked') && right.push($(this).val())
		})
		var ugid = $("#ugid").val();
		$.loadajax({
			url:baseurl+"Group/saveUserGroupRight",
			type:"post",
			data:{
				right:right,
				ugid:ugid
			},
			success:function(res)
			{
				if(res.code==1)
				{
					alertSuccess("修改成功");
				}else{
					alertError(res.msg);
				}
			},
			error:function()
			{
				alertError("添加失败，请重试");
			}
		})
	})
	$(".clearright").click(function(){
		$(".rightare input").each(function(){
			$(this).attr("checked" , false)
		})
	})
})