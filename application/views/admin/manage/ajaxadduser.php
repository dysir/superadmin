<div class="form-group">
    <label class="col-md-3 control-label">用户名</label>
    <div class="col-md-9">
        <input type="text" name="uname" class="form-control input-inline input-medium" placeholder="登录使用，字母数字组成 必填">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">昵称</label>
    <div class="col-md-9">
        <input type="text" name="nick_name" class="form-control input-inline input-medium" placeholder="用户昵称 必填">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">密码</label>
    <div class="col-md-9">
        <input type="text" name="pwd" class="form-control input-inline input-medium" placeholder="6位以上字母或数字组成">
    </div>
</div>
<?php
    if(!empty($arrlevel))
    {    
?>
<div class="form-group">
    <label class="col-md-3 control-label">用户级别</label>
    <div class="col-md-9">
        <select class="form-control input-inline input-medium" name="user_level">
            <?php
            foreach ($arrlevel as $key => $value) {
                echo "<option value={$key}>{$value}</option>";
            }
            ?>
        </select>
    </div>
</div>
<?php
    }
?>