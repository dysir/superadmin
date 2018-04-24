$(function(){
	//添加主表
	$("#addmaintable").click(function(){
		$("#tablecolumn").html("");
		$("#jointablelist").html("");
		globaldata['tableinfo'] = {};
		var maintable = $("#maintable").val();
		var param = {
			'maintable':maintable
		}
		$.loadajax({
			url:baseurl+"Createtemp/getTablecolumn",
			data:param,
			success:function(res){
				if(res.code!=1)
				{
					alertError(res.msg);
					return false;
				}
				var data = res.data;
				var maintablecolume = [];
				$("#tablecolumn").html(data['columnview']);
				$("#tablecolumn .maincolumevalue").each(function(){
					maintablecolume.push($(this).val());
				})
				//用于表关联
				globaldata['tableinfo'] = {
					//主表
					'maintable':maintable,
					'maintablecolume':maintablecolume,
					//关联表信息
					'jointablelist':[
						/*
							数据结构
							{
								jointable:'',
								jointablecolume:[]
							}
						*/
					]
				}
			},
			error:function(){
				alertError(res.msg);
				return false;
			}

		})
	})

	$("#addjointable").click(function(){



		if(!globaldata['tableinfo']||!globaldata['tableinfo']['maintable'] ){
			alertError("请先选择主表");
			return false;
		}
		var maintable = globaldata['tableinfo']['maintable'];
		var param = {
			'maintable':maintable
		}

		$.loadajax({
			url:baseurl+"Createtemp/getJoinTable",
			data:param,
			success:function(res){
				if(res.code!=1)
				{
					alertError(res.msg);
					return false;
				}
				var data = res.data;
				var maintablecolume = [];
				$("#jointablelist").append(data['jointableview']);
			},
			error:function(){
				alertError(res.msg);
			}

		})
	})
	//清空联查表
	$("#deletejointable").click(function(){
		$("#jointablelist").html("");
		globaldata['tableinfo']['jointablelist']=[];
	})
	//提交
	$("#createtemp").click(function(){
		$("#createfile").modal("show");
		$("#createfile .save").off();
		$("#createfile .save").on("click",function(){
			$("#createfile").modal("hide");

			var maintable = $("#maintable").val();
			if(!maintable){
				alertError("缺少主表");
				return false;
			}

			var maintablecolume = [];
			$("#tablecolumn .maincolumevalue").each(function(){
				var othis = $(this);
				if( !othis.is(":checked") ){
					return true
				}

				var comment = othis.parent().parent().next().find(".maincolumecomment").val();
				var search = 0;
				if(othis.parent().parent().next().find(".maincolumesearch").attr('checked')){
					search = othis.parent().parent().next().find(".maincolumesearch").val();
				}
				var odata = {
					'k':othis.val(),//字段名
					't':comment,//标题
					's':search //搜索字段
				}
				maintablecolume.push(odata);
			})
			var joinlist = [];

			$("#jointablelist .jointablaname").each(function(){
				var othis = $(this);
				var odata = {
					'table':othis.val(),
					'colume':[]
				}
				othis.parent().parent().next().find(".joincolumeinfolist").each(function(){
					var jdata = $(this);
					if( !jdata.find(".joincolumevalue").is(":checked") ){
						return true
					}

					var search = 0;
					if(jdata.find(".leftjoinolumesearch").attr('checked')){
						search = jdata.find(".leftjoinolumesearch").val();
					}
									
					var ocolume = {
						'k':jdata.find(".joincolumevalue").val(),
						't':jdata.find(".joincolumncomment").val(),
						//设为搜索项
						's':search,
						//关联表名及字段
						'l':jdata.find(".leftjoincolmunvalue").text(),
					};
					odata['colume'].push(ocolume)
				})
				joinlist.push(odata)
			})

			var coldata = {
				'maintable':maintable,//主表名
				'maintablecolume':maintablecolume,//主表字段
				'joinlist':[
					/*
						{
							table:"",
							colume:[
								{
									'k':"", //字段
									't':"", //标题
									'f':"", //重命名
									'l':""  //关联表名及字段
								}
							]
						}
					*/
				],
				'filename':$("#filename").val()

			};
			coldata['joinlist']=joinlist;

			$.loadajax({
				url:baseurl+"Createtemp/creater",
				type:"post",
				data:coldata,
				success:function(res){
					if(res.code!=1)
					{
						alertError(res.msg);
						return false;
					}

					// var data = res.data;

					// var info = "<pre>"+
					// 		   	"<button class='btn btn-success btn-xs'>添加为目录</button>"+
					// 		   	" <button class='btn btn-danger btn-xs deletefile' aid='"+data['file_id']+"'>移除文件</button>"+
					// 		   	"<br><br>创建时间："+data['file_ctime']+"<br>";
					// 		   "</pre>";

					// for(var i in data['file']){
					// 	info+=data['file'][i]+"<br>";
					// }
					// info+="</pre>";
					// $(".rescreateinfo").prepend(info);
					// return true;
					location.reload();
				},
				error:function(){
					alertError(res.msg);
				}

			})
		})
	})
	$(".deletefile").on("click",function(){
		var id = $(this).attr("aid");
		var othis = $(this);
		$.loadajax({
			confirm:"文件将被删除，请确认不是在使用中的目录!",
			url:baseurl+"Createtemp/deletefile?id="+id,
			success:function(res){
				if(res.code == 1){
					othis.parent().parent().remove();
					alertSuccess(res.msg);
				}else{
					alertError(res.msg);
				}
			},
			error:function(){
				alertError("操作失败");
			}
		})
	})
})