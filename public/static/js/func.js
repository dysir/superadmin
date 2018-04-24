//页面提示条
function htmlMsg(obj , msg , errormsg )
{
	if(!msg){
		msg = '错误 请稍后重试';
	}
	if(!errormsg){
		errormsg = '提示';
	}
	obj.html('<div class="alert alert-danger"><strong>'+errormsg+'</strong> '+ msg +' </div>');
}
//弹出提示框
function alertError(errormsg)
{
	if(!errormsg)
	{
		errormsg = '发生错误';
	}
	errormsg = '<span style="color:#d64635;font-weight: 900;">'+errormsg+'</span>';
	var html = '<div class="modal fade" id="error" tabindex="-1" role="basic" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button><h4 class="modal-title">'+errormsg+'</h4></div><div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button></div></div></div></div>';
	$("body").append(html);
	$("#error").modal("show");
}
//弹出提示框
function alertSuccess(errormsg)
{
	if(!errormsg)
	{
		errormsg = '操作成功';
	}
	errormsg = '<span>'+errormsg+'</span>';
	var html = '<div class="modal fade" id="error" tabindex="-1" role="basic" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button><h4 class="modal-title">'+errormsg+'</h4></div><div class="modal-footer"><button type="button" class="btn btn btn-primary" data-dismiss="modal">确定</button></div></div></div></div>';
	$("body").append(html);
	$("#error").modal("show");
}
function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var reg_rewrite = new RegExp("(^|/)" + name + "/([^/]*)(/|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    var q = window.location.pathname.substr(1).match(reg_rewrite);
    if(r != null){
        return unescape(r[2]);
    }else if(q != null){
        return unescape(q[2]);
    }else{
        return null;
    }
}
var baseurl = "/m/";
var globaldata = {};
$.extend({
	loadajax:function(obj)
	{	
		myajax = function(o){
			Metronic.blockUI({
	            boxed: true
	        });
	        obj.complete = function()
	        {
	        	Metronic.unblockUI();
	        }
			$.ajax(obj);
		}
		if(obj.confirm != undefined){
			$("body #my_confirm_html").remove();
			var confirmHtml = 
			'<div class="modal fade" id="my_confirm_html" tabindex="-1" role="basic" aria-hidden="true">'+
				'<div class="modal-dialog">'+
					'<div class="modal-content">'+
						'<div class="modal-header">'+
							'<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>'+
							'<h4 class="modal-title">'+
								obj.confirm +
							'</h4>'+
						'</div>'+
						'<div class="modal-footer">'+
							'<button type="button" class="btn btn-default confirm_cancel" data-dismiss="modal">取消</button>'+
							'<button type="button" class="btn btn-danger confirm_save" data-dismiss="modal">确定</button>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>';
			$("body").append(confirmHtml);
			$("body #my_confirm_html").modal("show");

			$("#my_confirm_html .confirm_save").on("click",function(){
				$("body #my_confirm_html").modal("hide");
				myajax(obj);
			})
			$("#my_confirm_html .confirm_cancel").on("click",function(){
				$("body #my_confirm_html").modal("hide");
			})
		}else{
			myajax(obj);
		}



	}
})
// 修改密码
$(function(){
	$("#changeselfpwd").click(function(){
		var $e = $("#changeselfpwdwindow");
		$e.modal("show");
		$e.find("input").each(function(){
			$(this).val("");
		})
		$e.find(".save").off();
		$e.find(".save").click(function(){
			var oldpwd = $e.find("input[name='oldpwd']").val();
			if(!oldpwd)
			{
				$e.find("input[name='oldpwd']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='oldpwd']").parent().parent().removeClass('has-error');
			}
			var newpwd = $e.find("input[name='newpwd']").val();
			if(!newpwd)
			{
				$e.find("input[name='newpwd']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='newpwd']").parent().parent().removeClass('has-error');
			}
			$e.modal("hide");

			$.loadajax({
				url:"/m/User/ajaxChangePwd",
				type:"post",
				data:{
					opwd:md5(oldpwd),
					npwd:md5(newpwd),
				},
				success:function(res){
					if(res.code==1)
					{
						alertSuccess("修改修改，请重新登录");
						window.location.href="/m/Auth/logout";
					}else{
						alertError(res.msg);
					}
				},error:function(){
					alertError("修改失败，请重试");
				}
			})
		})
	})
	$("#refreshRight").click(function(){
		$.loadajax({
			url:"/m/User/refreshRight",
			success:function(res){
				if(res.code==1)
				{
					location.reload();
				}else{
					alertError(res.msg);
				}
			},error:function(){
				alertError("刷新失败，请重试");
			}
		})
	})
	$(".note").addClass("animated flipInX");
})