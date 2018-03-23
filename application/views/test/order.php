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
        为方便测试 ，下面添加了切换用户功能，后台管理中配置了权限，可以通过这里切换用户来测试权限功能。正式环境需删除功能。
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
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                            <form method='get' action="/test/order/index">
                                <label>
                                    <select class="form-control input-inline" name="status">
                                        <option value="">全部订单</option>
                                        <?php
                                                $arrStatus = getTableColumnInfo("order" ,'status' ,'colmunvalue');
                                                foreach($arrStatus as $k=>$v)
                                                {
                                        ?>
                                        <option <?php echo !empty($_GET['status'])&&$_GET['status']==$k?"selected":"";?> value="<?=$k?>"><?=$v?></option>
                                        <?php
                                                }
                                        ?>
                                    </select>
                                </label>
                                <label>
                                    <input type="text" name="" class="form-control" placeholder="12312">
                                </label>
                            <button class="btn blue-madison" type='submit'>查询</button>
                            <form>
                        <div style="margin: 15px 0;">
                          <?php echo $cuser;?>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>订单编号</th>
                        <th>商品名称</th>
                        <th>商品价格</th>
                        <th>实付金额</th>
                        <th>状态</th>
                        <th>支付时间</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (! empty($list)) {
                        $arrStatus = getTableColumnInfo("order" ,'status' ,'colmunvalue');
                        foreach ($list as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $value['order_id'];?></td>
                        <td><?php echo $value['name'];?></td>
                        <td><?php echo sprintf("%.2f",$value['price']/100);?></td>
                        <td><?php echo sprintf("%.2f",$value['pay']/100);?></td>
                        <td>
                            <?php
                            echo empty($arrStatus[$value['status']])?$value['status']:$arrStatus[$value['status']];
                            ?>
                        </td>
                        <td><?php echo $value['pay_time'];?></td>
                        <td><?php echo $value['ctime'];?></td>
                        <td><?php echo $value['mtime'];?></td>
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
<script type="text/javascript">

</script>