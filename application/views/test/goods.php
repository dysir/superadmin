<h3 class="page-title">
<?php
echo $_current['mname'];
?> 
</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <?php
            echo $_current['mname'];
?> 
            <i class="fa fa-angle-right"></i>
        </li>
    </ul>
</div>
<div class="note note-success">
    <p>
        商品页面，添加商品，编辑，下架，删除，都可以配置单独的权限，后台简单调用权限接口，每个按钮和文字都可以控制，并在后台管理中给其他人配置操作权限。
    </p>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green-haze">
            <div class="portlet-title">
                <div class="caption">
                    <?php echo $_current['mname'];?>
                </div>
            </div>
            <div class="portlet-body">
                <?php
                if(checkRight("addgoods"))
                {
                ?>
                <div class="row table-toolbar">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <button class="btn btn-danger" id="addGoodsButton">
                            添加商品 <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>商品名</th>
                        <th>价格(元)</th>
                        <th>库存</th>
                        <th>状态</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <?php
                        if(checkRight("editgoods"))
                        {
                        ?>
                        <th>编辑</th>
                        <?php
                        }
                        if(checkRight("pullgoods")){
                        ?>
                        <th>上/下架</th>
                        <?php
                        }
                        if(checkRight("deletegoods")){
                        ?>
                        <th>删除</th>
                        <?php
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (! empty($list)) {
                        $arrStatus = getTableColumnInfo("goods" ,'status' ,'colmunvalue');
                        foreach ($list as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $value['name'];?></td>
                        <td><?php echo sprintf("%.2f",$value['price']/100);?></td>
                        <td><?php echo $value['num'];?></td>
                        <td>
                            <?php
                                echo ! empty($arrStatus[$value['status']]) ? $arrStatus[$value['status']] : "";
                            ?>  
                        </td>
                        <td><?php echo $value['ctime'];?></td>
                        <td><?php echo $value['mtime'];?></td>
                        <?php
                        if(checkRight("editgoods"))
                        {
                        ?>
                        <td>
                            <button aid="<?php echo $value['id'];?>" class="btn blue-madison btn-xs editGoods">
                            <i class="fa fa-edit"></i>
                            编辑</button>
                        </td>
                        <?php
                        }
                        if(checkRight("pullgoods")){
                        ?>
                        <td>
                            <?php
                                if($value['status'] == 1)
                                {
                                ?>
                                <button aid="<?php echo $value['id'];?>" class="btn yellow editstatus btn-xs">
                                <i class="fa fa-trash-o"></i>
                                下架
                                </button>
                                <?php
                                }else{
                                ?>
                                <button aid="<?php echo $value['id'];?>" class="btn blue editstatus btn-xs">
                                <i class="fa fa-trash-o"></i>
                                上架
                                </button>
                                <?php
                                }
                            ?>
                        </td>
                        <?php
                        }
                        if(checkRight("deletegoods"))
                        {
                        ?>
                        <td>
                            <button aid="<?php echo $value['id'];?>" class="btn btn-danger delete btn-xs">
                            <i class="fa fa-trash-o"></i>
                            删除
                            </button>
                        </td>
                        <?php
                        }
                        ?>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php

            echo $page_view;
?>
        </div>
    </div>
</div>
<div class="modal fade" id="editgoods" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">编辑商品</h4>
            </div>
            <div class="alert alert-warning" style="padding: 14px;">

            </div>
            <div class="errormsg">
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">商品名</label>
                        <div class="col-md-9">
                            <input type="text" name="name" class="form-control input-inline input-medium" placeholder="商品名 必填">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">价格(分)</label>
                        <div class="col-md-9">
                            <input type="text" name="price" class="form-control input-inline input-medium" placeholder="价格 必填">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">库存</label>
                        <div class="col-md-9">
                            <input type="text" name="num" class="form-control input-inline input-medium" placeholder="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">放弃</button>
                <button type="button" class="btn blue save">保存</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">确认删除</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">放弃</button>
                <button type="button" class="btn btn-danger sure">删除</button>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
window.onload=function(){
    $("#addGoodsButton").click(function(){
        $e = $("#editgoods");
        $e.find("input").each(function(){
            $(this).val("");
        })
        $e.modal("show");
        $e.find(".save").off();
        $e.find(".save").on("click",es);
        function es(){
            var name = $e.find("input[name='name']").val();
            if(!name)
            {
                $e.find("input[name='name']").parent().parent().addClass('has-error');
                return false;
            }else{
                $e.find("input[name='name']").parent().parent().removeClass('has-error');
            }
            var price = $e.find("input[name='price']").val();
            if(!price)
            {
                $e.find("input[name='price']").parent().parent().addClass('has-error');
                return false;
            }else{
                $e.find("input[name='price']").parent().parent().removeClass('has-error');
            }
            var num = $e.find("input[name='num']").val();

            var param = {
                name:name,
                price:price,
                num:num,
            };
            $e.find(".save").attr("disabled" , true);
            $.ajax({
                url:"/test/Goods/ajaxAddGoods",
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
                },
                complete:function(){
                    $e.find(".save").attr("disabled" , false);
                }
            })
        }
    })
    $(".editGoods").on("click",function(){
        $e = $("#editgoods");
        $e.find("input").each(function(){
            $(this).val("");
        })
        $e.find(".save").off();
        $e.find(".save").on("click",es)
        var id = $(this).attr("aid");
        $.loadajax({
            url:"/test/Goods/ajaxGetGoods?id="+id,
            success:function(res){
                if(res.code == 1)
                {
                    var data = res.data;
                    $e.find("input[name='name']").val(data['name']);
                    $e.find("input[name='price']").val(data['price']);
                    $e.find("input[name='num']").val(data['num']);
                    $e.modal("show");
                }else{
                    alertError(res.msg);
                }
            }
        })

        function es(){
            var name = $e.find("input[name='name']").val();
            if(!name)
            {
                $e.find("input[name='name']").parent().parent().addClass('has-error');
                return false;
            }else{
                $e.find("input[name='name']").parent().parent().removeClass('has-error');
            }
            var price = $e.find("input[name='price']").val();
            if(!price)
            {
                $e.find("input[name='price']").parent().parent().addClass('has-error');
                return false;
            }else{
                $e.find("input[name='price']").parent().parent().removeClass('has-error');
            }
            var num = $e.find("input[name='num']").val();

            var param = {
                name:name,
                price:price,
                num:num,
                id:id,
            };
            $e.find(".save").attr("disabled" , true);
            $.ajax({
                url:"/test/Goods/ajaxEditGoods",
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
                },
                complete:function(){
                    $e.find(".save").attr("disabled" , false);
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
                url:"/test/Goods/deleteGoods?id="+id,
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
    $(".editstatus").on("click",function(){
        var id = $(this).attr("aid");
        $.loadajax({
            url:"/test/Goods/editGoodsStatus?id="+id,
            success:function(res)
            {
                if(res.code == 1)
                {
                    location.reload();
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
}
</script>