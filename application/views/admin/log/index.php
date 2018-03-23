<h3 class="page-title">
<script type="text/javascript" src="<?=static_url('global/js/jquery.qrcode.min.js')?>"></script>
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
<!-- 		<li>
            Data Tables
            <i class="fa fa-angle-right"></i>
        </li> -->
    </ul>
</div>

<div class="row">

    <div class="col-md-12">
        <div class="portlet box grey-cascade">
            <div class="portlet-title">
                <div class="caption">
                    日志
                </div>
            </div>
            <div class="portlet-body">
                <div class="row table-toolbar">
                    <div class="col-md-6">
                        <div class="btn-group">
                        <form action='' method='get'>
                           <input type="text"  name="st" value="<?php echo $st;?>" class="Wdate form-control" style="width: 140px; height: 28px; cursor: pointer;display:inline" onclick="WdatePicker();">
                        -<input type="text"  name="et" value="<?php echo $et;?>" class="Wdate form-control" style="width: 140px; height: 28px; cursor: pointer;display:inline" onclick="WdatePicker();">
                        <button class="btn blue-madison" type="submit">查询</button>
                       </form>
                        </div>
                    </div>
                </div>
               
                <div class="table-responsive">
                     <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>用戶名</th>
                        <th>请求url</th>
                        <th>请求标题</th>
                        <th>说明</th>
                        <?php
                        if(checkRight("superadmin"))
                        {
                            echo "<th>ip</th>";
                        }
                        ?>
                        <th>时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list as $value):?>
                    <tr>
                    <td><?php echo $value['username'];?></td>
                    <td><?php echo $value['uri'];?></td>
                    <td><?php echo $value['mark'];?></td>
                    <td>
                    
                    <?php if($j = json_decode($value['mark_ext'],true)):?>
                      <pre><?php $r = var_export($j,true);echo $r;?></pre>
                    <?php else:?>
                    <?php echo $value['mark_ext'];?>
                    <?php endif;?>
                    
                    </td>
                    <?php
                    if(checkRight("superadmin"))
                    {
                    ?>
                    <td><?php echo $value['ip'];?></td>
                    <?php
                    }
                    ?>
                    
                    <td><?php echo $value['ctime'];?></td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                    </table>
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
            </div>
            
        </div>
        
    </div>

</div>