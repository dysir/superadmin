<script src="<?=static_url('js/systemconfig.js')?>" type="text/javascript"></script>
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
    </ul>
</div>

<div class="row">

    <div class="col-md-12">
        <div class="note note-danger">
			<p>
			 注:此功能为系统配置，调用方式:gconfig("配置的ckey")\
			</p>
		</div>
        <div class="portlet box grey-cascade animated fadeInRight">
            <div class="portlet-title">
                <div class="caption">
                    系统配置
                </div>
            </div>
            <div class="portlet-body">
                <div class="row table-toolbar">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <a class="btn green" href="#addconfig" data-toggle="modal">
                            添加自定义配置 <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                     <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>变量名称</th>
                        <th>变量key</th>
                        <th>变量value</th>
                        <th>说明</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($config as $value):?>
                    <tr>
                    <td><?php echo $value['cname'];?></td>
                    <td><?php echo $value['ckey'];?></td>
                    <td><?php echo $value['cvalue'];?></td>
                    <td><?php echo $value['mark'];?></td>
                    <td>
                        <button aid="<?php echo $value['id'];?>" class="btn blue-madison btn-xs editconfig">
                            <i class="fa fa-edit"></i>
                            编辑
                        </button>
                     <?php if ($value['type']!=1):?>
                        <button aid="<?php echo $value['id'];?>" class="btn btn-danger delete btn-xs">
                            <i class="fa fa-trash-o"></i>
                            删除
                        </button>
                     <?php endif;?>
                    </td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addconfig" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="errormsg">
            </div>
            <div class="modal-body form-horizontal">
                <input type="" name="id" style="display: none;">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">配置名称</label>
                        <div class="col-md-9">
                            <input type="text" name="cname" class="form-control input-inline input-medium" placeholder="配置名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">key</label>
                        <div class="col-md-9">
                            <input type="text" name="ckey" class="form-control input-inline input-medium" placeholder="调用时使用的key">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">值</label>
                        <div class="col-md-9">
                            <input type="text" name="cvalue" class="form-control input-inline input-medium" placeholder="配置的值，可以是任何结构">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">说明</label>
                        <div class="col-md-9">
                            <input type="text" name="mark" class="form-control input-inline input-medium" placeholder="配置说明">
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
<div class="modal fade" id="editconfig" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="errormsg">
            </div>
            <div class="modal-body form-horizontal">
                <input type="" name="id" style="display: none;">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">配置名称</label>
                        <div class="col-md-9">
                            <input type="text" name="cname" class="form-control input-inline input-medium" placeholder="配置名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">key</label>
                        <div class="col-md-9">
                            <input type="text" name="ckey" class="form-control input-inline input-medium" placeholder="调用时使用的key">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">值</label>
                        <div class="col-md-9">
                            <input type="text" name="cvalue" class="form-control input-inline input-medium" placeholder="配置的值，可以是任何结构">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">说明</label>
                        <div class="col-md-9">
                            <input type="text" name="mark" class="form-control input-inline input-medium" placeholder="配置说明">
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