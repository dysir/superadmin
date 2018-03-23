<script src="<?=static_url('js/group.js')?>" type="text/javascript"></script>
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
<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue animated fadeInRight">
            <div class="portlet-title">
                <div class="caption">
                    权限组
                </div>
            </div>
            <div class="portlet-body">
                <div class="row table-toolbar">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <a class="btn green" data-toggle="modal" href="#addgroup">
                            新建权限组 <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>权限组名</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <th>操作</th>
                        <th>删除</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (! empty($list)) {
                        foreach ($list as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $value['gname'];?></td>
                        <td><?php echo $value['ctime'];?></td>
                        <td><?php echo $value['mtime'];?></td>
                        <td>
                            <a class="btn blue-madison btn-xs" href="/m/group/editGroupRight?id=<?php echo $value['id'];?>">
                            <i class="fa fa-edit"></i>
                            查看编辑</a>
                        </td>
                        <td>
                            <button aid="<?php echo $value['id'];?>" class="btn btn-danger delete btn-xs">
                            <i class="fa fa-trash-o"></i>
                            删除</button>
                        </td>
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

<div class="modal fade" id="addgroup" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">新建权限组</h4>
            </div>
            <div class="errormsg">
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">权限组名</label>
                        <div class="col-md-9">
                            <input type="text" name="gname" class="form-control input-inline input-medium" placeholder="权限组名">
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