window.onload=function(){
    $("#addUserButton").click(function(){
        $e = $("#edituser");
        $e.modal("show");
        $e.find(".save").attr("disabled" , true);
        $.ajax({
            url:baseurl+"User/ajaxManageRight",
            success:function(res)
            {
                if(res.code==1)
                {
                    var data = res.data;
                    $("#edituser .form-body").html(data['addview']);
                    $e.find(".save").attr("disabled" , false);
                    $e.find(".save").click(es)
                }else{
                    htmlMsg($e.find(".errormsg") , res.msg);
                }
            },
            error:function(){
                htmlMsg($e.find(".errormsg"));
            }
        })
        function es(){
            var uname = $e.find("input[name='uname']").val();
            if(!uname)
            {
                $e.find("input[name='uname']").parent().parent().addClass('has-error');
                return false;
            }else{
                $e.find("input[name='uname']").parent().parent().removeClass('has-error');
            }
            var nick_name = $e.find("input[name='nick_name']").val();
            if(!nick_name)
            {
                $e.find("input[name='nick_name']").parent().parent().addClass('has-error');
                return false;
            }else{
                $e.find("input[name='nick_name']").parent().parent().removeClass('has-error');
            }
            var pwd = $e.find("input[name='pwd']").val();
            if(!pwd)
            {
                $e.find("input[name='pwd']").parent().parent().addClass('has-error');
                return false;
            }else{
                $e.find("input[name='pwd']").parent().parent().removeClass('has-error');
            }
            var user_level = $e.find("select[name='user_level']").val();

            var param = {
                uname:uname,
                nick_name:nick_name,
                pwd:md5(pwd),
                user_level:user_level,
            };
            $.ajax({
                url:baseurl+"user/ajaxAddUser",
                type:'post',
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
                url:baseurl+"User/deleteUser?id="+id,
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
    $(".changepwd").bind("click",function(){
        var id = $(this).attr("aid");
        $("#changepwdwindow").modal("show");
        $("#changepwdwindow .save").one("click",function(){
            var newpwd = $("#changepwdwindow input[name='newpwd']").val();
            if(!newpwd)
            {
                $("#changepwdwindow input[name='newpwd']").parent().parent().addClass('has-error');
                return false;
            }else{
                $("#changepwdwindow input[name='newpwd']").parent().parent().removeClass('has-error');
            }
            $("#changepwdwindow").modal("hide");
            $("#changepwdwindow input[name='newpwd']").val("");
            $.loadajax({
                url:baseurl+"User/ajaxAdminCPwd",
                type:"post",
                data:{
                    id:id,
                    pwd:md5(newpwd)
                },
                success:function(res)
                {
                    if(res.code == 1)
                    {
                        alertSuccess("修改成功");
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
    $(".changeuserinfo").bind("click",function(){
        var id = $(this).attr("aid");
        var $cw = $("#changeuserinfowindow");
        $.loadajax({
            url:baseurl+"User/getUserinfo?id="+id,
            success:function(res){
                if(res.code!=1)
                {
                    alertError(res.msg);
                    return false;
                }
                var data = res.data;
                $cw.modal("show");
                $cw.find("input[name='nick_name']").val(data['nick_name']);
                $cw.find("input[name='status']").each(function(){
                    $(this).val() == data['status']?$(this).attr('checked',true):$(this).attr('checked',false);
                })
                $cw.find(".save").one("click",savechange);
            }
        })
        function savechange()
        {
            var nick_name = $cw.find("input[name='nick_name']").val();
            if(!nick_name)
            {
                $cw.find("input[name='nick_name']").parent().parent().addClass('has-error');
                return false;
            }else{
                $cw.find("input[name='nick_name']").parent().parent().removeClass('has-error');
            }
            var status = 2;
            $cw.find("input[name='status']").each(function(){
                if ($(this).attr("checked") )
                {
                    status = $(this).val();
                }
            });
            var param = {
                nick_name:nick_name,
                status:status,
                id:id
            }
            $cw.modal("hide");
            $.loadajax({
                url:baseurl+"User/updatUserinfo",
                type:"post",
                data:param,
                success:function(res)
                {
                    if(res.code !=1)
                    {
                        alertError(res.msg);
                        return false;
                    }
                    location.reload();
                },
                error:function(){
                    alertError("修改失败");
                }
            })


        }
        // $("#changeuserinfowindow .save").one("click",function(){
        //     var newpwd = $("#changeuserinfowindow input[name='newpwd']").val();
        //     if(!newpwd)
        //     {
        //         $("#changeuserinfowindow input[name='newpwd']").parent().parent().addClass('has-error');
        //         return false;
        //     }else{
        //         $("#changeuserinfowindow input[name='newpwd']").parent().parent().removeClass('has-error');
        //     }
        //     $("#changeuserinfowindow").modal("hide");
        //     $("#changeuserinfowindow input[name='newpwd']").val("");
        //     $.loadajax({
        //         url:baseurl+"User/ajaxAdminCPwd",
        //         type:"post",
        //         data:{
        //             id:id,
        //             pwd:md5(newpwd)
        //         },
        //         success:function(res)
        //         {
        //             if(res.code == 1)
        //             {
        //                 alertSuccess("修改成功");
        //             }else{
        //                 alertError(res.msg);
        //             }
        //         },
        //         error:function()
        //         {
        //             alertError("请稍后重试");
        //         }
        //     })
        // })
    })
}