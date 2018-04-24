$(function(){	
	//添加编辑一级目录
	$(".first_menu").click(function(){
		var $e = $("#firstmenu");
		var $this = $(this);
		//清空信息
		$e.find("input").each(function(){
			if( $this.attr("type") != "radio" )
			{
				$this.val("");
			}
		})
		$e.find(".menu_icon i").attr("class" ,"");
		$e.find(".errormsg").empty();
		$e.find("input[name='status']").eq(0).attr('checked',true);
		var aname = $this.parent().attr("aname");
		var aid = $this.parent().attr("aid");
		if(!aid)
		{
			//判定为添加目录
			var html = "添加一级目录";
			$e.find("h4").html(html);
			$e.modal("show");
			$e.find(".save").click(es);
			return false;
		}
		var html = "修改目录 <span style='color:#d64635;font-weight: 900;'>加载中...</span> ";
		$e.find("h4").html(html);
		$e.find("input[name='id']").val(aid);
		$e.modal("show");
		$e.find(".save").attr("disabled" , true);
		$.ajax({
			url:baseurl+"Manage/getMenu?id="+aid,
			success:function(res){
				if(res.code !=1)
				{
					htmlMsg($e.find(".errormsg") ,res.msg );
					return false;
				}
				var html = "修改目录 <span style='color:#d64635;font-weight: 900;'>"+aname+"</span> ";
				$e.find("h4").html(html);
				var data = res.data;
				for (var i in data) {
					if(i != 'status')
					{
						$e.find("input[name='"+i+"']").val(data[i]);
					}else{
						$e.find("input[name='"+i+"']").each(function(){
							$(this).val() == data['status']?$(this).attr('checked',true):$(this).attr('checked',false);
						})
					}
				}
				$e.find(".menu_icon i").attr("class" ,data['icon']);
				$e.find(".save").attr("disabled" , false);
				$e.find(".save").click(es)
			},
			error:function()
			{
				htmlMsg($e.find(".errormsg"));
				$e.find(".save").attr("disabled" , false);
			}
		})
		//保存修改的目录
		function es(){
			var mname = $e.find("input[name='mname']").val();
			if(!mname)
			{
				$e.find("input[name='mname']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='mname']").parent().parent().removeClass('has-error');
			}
			var icon = $e.find("input[name='icon']").val();
			if(!icon)
			{
				$e.find("input[name='icon']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='icon']").parent().parent().removeClass('has-error');
			}
			var action = $e.find("input[name='action']").val();
			// if(!action)
			// {
			// 	$e.find("input[name='action']").parent().parent().addClass('has-error');
			// 	return false;
			// }else{
			// 	$e.find("input[name='action']").parent().parent().removeClass('has-error');
			// }
			var id = $e.find("input[name='id']").val();
			var url = $e.find("input[name='url']").val();
			var radio = 1;
			$e.find("input[name='status']").each(function(){
				if ($(this).attr("checked") )
				{
					radio = $(this).val();
				}
			});
			var param = {
				mname:mname,
				url:url,
				icon:icon,
				action:action,
				radio:radio,
				id:id
			};
			var url = "Manage/editFirstMenu";
			if(!id)
			{
				url = "Manage/addFirstMenu";
			}
			$.ajax({
				url:baseurl+url,
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

	//添加编辑二级目录弹窗
	$(".second_menu").click(function(){
		var $e = $("#secondmenu");
		$e.find("input").each(function(){
			if( $(this).attr("type") != "radio" )
			{
				$(this).val("");
			}
		})
		$e.find(".menu_icon i").attr("class" ,"");
		$e.find(".errormsg").empty();
		$e.find("input[name='status']").eq(0).attr('checked',true);
		var aname = $(this).parent().attr("aname");
		var aid = $(this).parent().attr("aid");
		var atype=$(this).parent().attr("atype");
		if(!aid)
		{
			alertError("缺少参数");
			return false;
		}

		if(atype != "edit")
		{
			var html = "为<span style='color:#d64635;font-weight: 900;'>"+aname+"</span>添加子目录";
			$e.find("h4").html(html);
			$e.modal("show");
			$e.find(".save").off();
			var dirpath = getQueryString("dirpath");

			if(dirpath != "" && dirpath !=undefined){

				$e.find("input[name='url']").val(dirpath);
			}
			$e.find(".save").on("click",es);
			return false;
		}
		function es()
		{
			var mname = $e.find("input[name='mname']").val();
			if(!mname)
			{
				$e.find("input[name='mname']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='mname']").parent().parent().removeClass('has-error');
			}
			
			var icon = $e.find("input[name='icon']").val();
			if(!icon)
			{
				$e.find("input[name='icon']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='icon']").parent().parent().removeClass('has-error');
			}
			var url = $e.find("input[name='url']").val();
			if(!url)
			{
				$e.find("input[name='url']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='url']").parent().parent().removeClass('has-error');
			}

			var url = $e.find("input[name='url']").val();
			var action = $e.find("input[name='action']").val();
			var radio = 1;
			$e.find("input[name='status']").each(function(){
				if ($(this).attr("checked") )
				{
					radio = $(this).val();
				}
			});
			var param = {
				mname:mname,
				url:url,
				icon:icon,
				action:action,
				radio:radio,
				parent:aid,
			};
			$.ajax({
				url:baseurl+"Manage/addsecondmenu",
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

		var html = "<span style='color:#d64635;font-weight: 900;'>加载中...</span> ";
		$e.find("h4").html(html);
		$e.modal("show");
		$.ajax({
			url:baseurl+"Manage/getMenu?id="+aid,
			success:function(res){
				if(res.code !=1)
				{
					htmlMsg($e.find(".errormsg") ,res.msg );
					return false;
				}
				var data = res.data;
				$e.find(".errormsg").empty();
				var html = "修改 <span style='color:#d64635;font-weight: 900;'>"+data['mname']+" </span>";
				$e.find("h4").html(html);
				$e.find("input[name='mname']").val(data['mname']);
				$e.find("input[name='icon']").val(data['icon']);
				$e.find("input[name='url']").val(data['url']);
				$e.find("input[name='action']").val(data['action']);
				$e.find(".menu_icon i").attr("class",data['icon']);
				$e.find("input[name='status']").each(function(){
					$(this).val() == data['status']?$(this).attr('checked',true):$(this).attr('checked',false);
				})
				$e.find(".save").off();
				$e.find(".save").on("click",ed);
			},
			error:function()
			{
				htmlMsg($e.find(".errormsg"));
			}
		})

		function ed()
		{
			var mname =$e.find("input[name='mname']").val();
			if(!mname)
			{
				$e.find("input[name='mname']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='mname']").parent().parent().removeClass('has-error');
			}
			var icon = $e.find("input[name='icon']").val();
			if(!icon)
			{
				$e.find("input[name='icon']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='icon']").parent().parent().removeClass('has-error');
			}
			var url = $e.find("input[name='url']").val();
			if(!url)
			{
				$e.find("input[name='url']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='url']").parent().parent().removeClass('has-error');
			}

			var id = $e.find("input[name='id']").val();
			var action = $e.find("input[name='action']").val();
			var radio = 1;
			$e.find("input[name='status']").each(function(){
				if ($(this).attr("checked") )
				{
					radio = $(this).val();
				}
			});
			var param = {
				mname:mname,
				url:url,
				icon:icon,
				action:action,
				radio:radio,
				id:aid
			};
			$.ajax({
				url:baseurl+"Manage/editSecondMenu",
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
	//弹出添加权限编辑框
	$(".add_action_menu").click(function(){
		var aname = $(this).parent().attr("aname");
		var aid = $(this).parent().attr("aid");
		if(!aname || !aid)
		{
			alertError("缺少参数");
			return false;
		}
		var $e = $("#addactionmenu");
		$e.find("input[name='mname']").val();
		$e.find("input[name='action']").val();
		var html = "<span style='color:#d64635;font-weight: 900;'>添加权限</span> ";
		$e.find("h4").html(html);
		$e.modal("show");
		$e.find(".save").off();
		$e.find(".save").on("click",ad);
		function ad()
		{
			var action = $e.find("input[name='action']").val();
			var mname = $e.find("input[name='mname']").val();
			if(!action)
			{
				$e.find("input[name='action']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='action']").parent().parent().removeClass('has-error');
			}
			var param = {
				mname:mname,
				action:action,
				parent:aid,
			};
			$.ajax({
				url:baseurl+"Manage/addactionmenu",
				data:param,
				success:function(res){
					if(res.code !=1)
					{
						htmlMsg($e.find(".errormsg") ,res.msg );
						return false;
					}
					location.reload();
				},
				error:function()
				{
					htmlMsg($e.find("errormsg"));
				}
			})
		}
	})

	//弹出删除目录提示框
	$(".delete_first_menu").click(function(){
		var aname = $(this).parent().attr("aname");
		var aid = $(this).parent().attr("aid");
		if( !aid)
		{
			alertError("缺少参数");
			return false;
		}
		var $e = $("#deletemenu");
		var html = "确认删除 <span style='color:#d64635;font-weight: 900;'>"+aname+" </span> ?";
		$e.find("h4").html(html);
		$e.modal("show");
		$e.find(".deletesure").off();
		$e.find(".deletesure").on("click",de);
		function de()
		{
			$e.modal("hide");
			$.ajax({
				url:baseurl+"Manage/deleteMenu?id="+aid,
				success:function(res)
				{
					if(res.code!=1)
					{
						alertError(res.msg);
						return false;
					}
					location.reload();
				},
				error:function()
				{
					alertError('删除失败');
				}
			})
		}
	})
	//点击复制
	$("#fullicon .item").css("cursor","pointer");
	$("#fullicon .item").click(function(){
		var icon = $(this).find("span").attr("class");
		if( $("#firstmenu").css("display") == 'block' )
		{
			$("#firstmenu input[name='icon']").val(icon);
			$("#firstmenu").find(".menu_icon i").attr("class",icon);

		}else if($("#secondmenu").css("display") == 'block')
		{
			$("#secondmenu input[name='icon']").val(icon);
			$("#secondmenu").find(".menu_icon i").attr("class",icon);
		}
		$("#fullicon .close").click();
	})
	$(".sort_first_menu").click(function(){
		var parent = $(this).parent().attr("aid");

		if(!parent || parent == undefined || parent == "")
		{
			parent = 0;
		}
		$.loadajax({
			url:baseurl+"Manage/getSortMeun?parent="+parent,
			success:function(res){
				if(res.code !=1)
				{
					alertError(res.msg);
					return false;
				}
				var data = res.data;
				var html = "";
				if(data)
				{
					var arr = data['sortmenulist'];
					sorthtml(arr);
				}
				$("#sort_menu").modal("show");
				$("#sort_menu .save").one("click",function(){
					var sortarr = []
					var sortint = 1;
					$("#sort_menu .sort .badge").each(function(){
						var obj = {
							id:$(this).attr("aid"),
							sort:sortint,
						}
						sortarr.push(obj);
						sortint++;
					})
					$("#sort_menu").modal("hide");

					$.loadajax({
						url:baseurl+"Manage/updateSortMeun",
						data:{
							'sortarr':sortarr
						},
						type:"post",
						success:function(res){
							if(res.code!=1)
							{
								alertError(res.msg);
								return false;
							}
							location.reload();
						},error:function(){
							alertError(res.msg);
						}
					})
				})
			}
		})
	})


	function sorthtml(arr)
	{
		var html = "";

		for(var k in arr)
		{
			html+='<li class="list-group-item"><i class="'+arr[k]['icon']+'"></i>&nbsp;'+arr[k]['mname']+'<span aid="'+arr[k]['id']+'" class="badge badge-danger"><i class="fa fa-sort-asc"></i></span></li>';
		}
		$("#sort_menu .sort").html(html);
		$("#sort_menu .sort .badge").click(function(){
			var prev = $(this).parent().prev().clone(true);
			if(!prev)
			{
				return false;
			}
			console.log(prev);
			$(this).parent().prev().remove();
			$(this).parent().after(prev);
		})
	}
})