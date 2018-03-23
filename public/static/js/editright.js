window.onload=function()
{
	geteditright();
	$(".saveright").click(function(){
		var group = [];
		var right = [];
		$(".grouplist input").each(function(){
			$(this).is(':checked') && group.push($(this).val())
		})
		$(".rightare input").each(function(){
			$(this).is(':checked') && right.push($(this).val())
		})
		var uid = $("#uid").val();
		$.loadajax({
			url:baseurl+"user/saveUserRight",
			type:"post",
			data:{
				group:group,
				right:right,
				uid:uid
			},
			success:function(res)
			{
				if(res.code==1)
				{
					alertSuccess("添加成功");
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
		$(".grouplist input").each(function(){
			$(this).attr("checked" , false)
		})
		$(".rightare input").each(function(){
			$(this).attr("checked" , false)
		})
	})
}
function geteditright()
{
	var uid = $("#uid").val();
	$.loadajax({
		url:baseurl+"user/ajaxGetLoginUserRight",
		type:"post",
		data:{
			first:1,
			uid:uid
		},
		success:function(res){
			if(res.code==1)
			{
				var data = res.data;
				$("#editright").html(data['view']);
				reloadrightpage();
			}
		},error:function()
		{
			alertError("页面加载失败 ，请刷新");
		}
	})
}
function reloadrightpage()
{
	var uid = $("#uid").val();

	$(".grouplist input").click(function(){
		var group = [];
		var right = [];
		$(".grouplist input").each(function(){
			$(this).is(':checked') && group.push($(this).val())
		})
		$(".rightare input").each(function(){
			$(this).is(':checked') && right.push($(this).val())
		})

		$.loadajax({
			url:baseurl+"/User/ajaxGetLoginUserRight",
			type:"post",
			data:{
				group:group,
				right:right,
				uid:uid
			},
			success:function(res)
			{
				var data = res.data;
				$("#editright").html(data['view']);
				reloadrightpage();
			},error:function()
			{
				alertError("页面加载失败 ，请刷新");
			}
		})
		
	})
}