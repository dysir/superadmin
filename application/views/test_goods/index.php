<h3 class="page-title">
<?php
echo empty($_current['mname'])?"":$_current['mname'];
?> 
</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <?php
            echo empty($_current['mname'])?"":$_current['mname'];
			?> 
            <i class="fa fa-angle-right"></i>
        </li>
    </ul>
</div>
<div class="note note-success">
    <p>
        描述...
    </p>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green-haze animated fadeInRight">
            <div class="portlet-title">
                <div class="caption">
                    <?php echo empty($_current['mname'])?"":$_current['mname'];?>
                </div>
            </div>
            <div class="portlet-body">
                <div class='row'>
                    <div class='col-md-12'>
                        <form method='get' action="/Test_goods/index">

                        </form>
                    </div>
                </div>
                <div class="table-responsive" style="margin-top:20px;">
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        
						<th>商品名</th>
						<th>价格</th>
						<th>库存</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (! empty($list)) {
                        foreach ($list as $key => $value) {
                            
                    ?>
                    <tr>
                        
						<td><?php echo $value['name'];?></td>
						<td><?php echo $value['price'];?></td>
						<td><?php echo $value['num'];?></td>
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