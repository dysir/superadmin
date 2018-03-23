<h3 class="page-title">
<script type="text/javascript" src="<?=static_url('global/js/jquery.qrcode.min.js')?>"></script>
<script src="<?=static_url('global/js/md5.min.js')?>" type="text/javascript"></script>
<script src="<?=static_url('js/user.js')?>" type="text/javascript"></script>
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
<div class="note note-success">
    <p>
        用户拥有多个权限组和独立权限时，取并集。
    </p>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue-hoki animated fadeInRight">
            <div class="portlet-title">
                <div class="caption">
                    登录用户列表
                </div>
            </div>
            <div class="portlet-body">
                <div class="row table-toolbar">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <button class="btn green" id="addUserButton">
                            添加用户 <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>登录名</th>
                        <th>昵称</th>
                        <th>级别</th>
                        <th>谷歌验证码密码</th>
                        <th>状态</th>
                        <th>创建时间</th>
                        <th>最新更新时间</th>
                        <th>修改用户信息</th>
                        <th>修改密码</th>
                        <th>权限</th>
                        <th>删除用户</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (! empty($list)) {
                        $arrStatus = getTableColumnInfo("user" ,'status' ,'colmunvalue');
                        $arrLevel = getTableColumnInfo("user" ,'user_level' ,'colmunvalue');
                        foreach ($list as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $value['username'];?></td>
                        <td><?php echo $value['nick_name'];?></td>
                        <td><?php echo ! empty($arrLevel[$value['user_level']]) ? $arrLevel[$value['user_level']] : "";?></td>
                        <td>
                            <?php
                            if (!empty($value['gcode'])) {
                            ?>
                            <a class="btn btn-default btn-xs" href="#erwm<?=$value['id']?>" data-toggle="modal"><?=$value['gcode']?></a>
                             <script type="text/javascript">
                                   $(function(){
                                      var jj = "<?=$value['id']?>";
                                      var url = "<?=$value['gcode']?>";
                                      $("#erwm"+jj+"img").qrcode(url);
                                  })
                              </script>
                            <?php
                            }
                            ?>
                            <div id="erwm<?=$value['id']?>" class="modal fade" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" style="    width: 280px;">
                                  <div class="modal-content" style="    width: 280px;padding: 10px;" id="erwm<?=$value['id']?>img"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php
                                echo ! empty($arrStatus[$value['status']]) ? $arrStatus[$value['status']] : "";
                            ?>  
                        </td>
                        <td><?php echo $value['ctime'];?></td>
                        <td><?php echo $value['mtime'];?></td>
                        <td><button aid="<?php echo $value['id'];?>" class="btn blue-hoki btn-xs changeuserinfo">
                            <i class="fa fa-edit"></i> 修改用户信息</button></td>
                        <td><button aid="<?php echo $value['id'];?>" class="btn purple btn-xs changepwd">
                            <i class="fa fa-lock"></i> 修改密码</button></td>
                        <td>
                            <?php
                            if($value['user_level'] != 4)
                            {
                            ?>
                            <a class="btn blue-madison btn-xs" href="/m/user/editright?id=<?php echo $value['id'];?>">
                            <i class="fa fa-edit"></i>
                            查看编辑</a>
                            <?php
                            }
                            ?>
                        </td>
                        <td>
                            <button aid="<?php echo $value['id'];?>" class="btn btn-danger delete btn-xs">
                            <i class="fa fa-trash-o"></i>
                            删除
                            </button>
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
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php

            echo $page_view;
?>
        </div>
    </div>
</div>
<div class="modal fade" id="edituser" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">添加用户</h4>
            </div>
            <div class="alert alert-warning" style="padding: 14px;">

            </div>
            <div class="errormsg">
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-body">
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
<div class="modal fade" id="changepwdwindow" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">修改密码</h4>
            </div>
            <div class="errormsg">
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">新密码</label>
                        <div class="col-md-9">
                            <input type="password" name="newpwd" class="form-control input-inline input-medium" placeholder="新密码">
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
<div class="modal fade" id="changeuserinfowindow" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">修改用户信息</h4>
            </div>
            <div class="errormsg">
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">昵称</label>
                        <div class="col-md-9">
                            <input type="text" name="nick_name" class="form-control input-inline input-medium" placeholder="昵称">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">状态</label>
                        <div class="col-md-9 radio-list" style="padding-left: 35px;">
                            <label class="radio-inline">
                            <div class=""><span class=""><input type="radio" name="status" value="2" ></span></div> 正常 </label>
                            <label class="radio-inline">
                            <div class=""><span class=""><input type="radio" name="status" value="3"></span></div> 锁定 </label>
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