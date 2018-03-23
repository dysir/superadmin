$(function(){	
	$("#addconfig").click(function(){
		var $e = $("#addconfig");
		$e.find(".save").off();
		$e.find(".save").on("click",es)
		//保存修改的目录
		function es(){
			var cname = $e.find("input[name='cname']").val();
			if(!cname)
			{
				$e.find("input[name='cname']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='cname']").parent().parent().removeClass('has-error');
			}
			var ckey = $e.find("input[name='ckey']").val();
			if(!ckey)
			{
				$e.find("input[name='ckey']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='ckey']").parent().parent().removeClass('has-error');
			}
			var cvalue = $e.find("input[name='cvalue']").val();
			if(!cvalue)
			{
				$e.find("input[name='cvalue']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='cvalue']").parent().parent().removeClass('has-error');
			}
			var mark = $e.find("input[name='mark']").val();

			var param = {
				cname:cname,
				ckey:ckey,
				cvalue:cvalue,
				mark:mark,
			};
			$.ajax({
				url:baseurl+"Config/ajaxAddConfig",
				type:"post",
				data:param,
				success:function(res){
					if(res.code !=1)
					{
						htmlMsg($e.find(".errormsg") ,res.msg );
						return false;
					}
					$e.find(".close").click();
					location.reload();
				},
				error:function()
				{
					htmlMsg($e.find("errormsg"));
				}
			})
		}
	})
	$(".delete").on("click",function(){
        var obj = this;
        $("#delete").modal("show");
        var id = $(this).attr("aid");
        $("#delete .sure").off();
        $("#delete .sure").on("click",function(){
            $("#delete").modal("hide");
            $.loadajax({
                url:baseurl+"Config/ajaxDelConfig",
                type:"post",
                data:{
                	id:id
                },
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
    $(".editconfig").click(function(){
		var $e = $("#editconfig");
		var aid = $(this).attr("aid");
		$e.find("input").each(function(){
			$(this).val("");
		})
		$.loadajax({
			url:baseurl+"Config/ajaxGetConfig",
			type:"post",
			data:{
				id:aid
			},
			success:function(res){
				if(res.code !=1)
				{
					alertError(res.msg)
					return false;
				}
				var data = res.data;
				$e.find(".errormsg").empty();
				$e.find("input[name='cname']").val(data['cname']);
				$e.find("input[name='ckey']").val(data['ckey']);
				$e.find("input[name='cvalue']").val(data['cvalue']);
				$e.find("input[name='mark']").val(data['mark']);
				$e.modal("show");
				$e.find(".save").off();
				$e.find(".save").on("click",ed);
			},
			error:function()
			{
				alertError(res.msg);
			}
		})

		function ed()
		{
			var cname = $e.find("input[name='cname']").val();
			if(!cname)
			{
				$e.find("input[name='cname']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='cname']").parent().parent().removeClass('has-error');
			}
			var ckey = $e.find("input[name='ckey']").val();
			if(!ckey)
			{
				$e.find("input[name='ckey']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='ckey']").parent().parent().removeClass('has-error');
			}
			var cvalue = $e.find("input[name='cvalue']").val();
			if(!cvalue)
			{
				$e.find("input[name='cvalue']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='cvalue']").parent().parent().removeClass('has-error');
			}

			var mark = $e.find("input[name='mark']").val();

			var param = {
				cname:cname,
				ckey:ckey,
				cvalue:cvalue,
				mark:mark,
				id:aid
			};

			$.ajax({
				url:baseurl+"Config/ajaxUpdateConfig",
				type:"post",
				data:param,
				success:function(res){
					if(res.code !=1)
					{
						htmlMsg($e.find(".errormsg") ,res.msg );
						return false;
					}
					$e.find(".errormsg").empty();
					location.reload();
				},
				error:function()
				{
					htmlMsg($e.find(".errormsg"));
				}
			})
		}
	})
})