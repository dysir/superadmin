<script src="<?=static_url('js/autotemp.js')?>" type="text/javascript"></script>

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
        此功能可以直接根据选择的表及联查表生成相应的 controller,model,view一应生成相应的列表查询文件。
        <br><b>所选字段若在custom 配置了字段描述数组，字段展示会自动匹配，若该字段被设定为搜索项，同样会自动匹配配置项。</b>
        <br><b>如果有字段需要解释展示，建议配置到配置文件。</b>
    </p>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 form-inline">        
                <button id="addmaintable" class="btn btn-success">添加为主表</button>
                <div class="form-group">
                    <select class="form-control" id="maintable">
                        <?php
                        if(!empty($list)){
                            foreach ($list as $key => $value) {
                                echo "<option title='{$value['table_comment']}' value='{$value['table_name']}'>{$value['table_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div id="tablecolumn">
            </div>
        </div>
        <div class="row" id="jointablelist">
            
        </div>
        <div class="row" style="margin-top:20px">
            <div class="col-md-12">
                <button id="addjointable" class="btn btn-primary">添加联查表</button>
                <button id="deletejointable" class="btn btn-danger">清空联查表</button>
            </div>
        </div>
    </div>
</div>
<div class="row" style="margin-top:20px">
    <div class="col-md-6">
        <input type="" class="form-control" id="filename" name="filename" placeholder="文件名，默认为主表名，不建议自定义。">
    </div>
</div>
<div class="row" style="margin-top:20px">
    <div class="col-md-6">
        <div class="form" id="createform">
			<div class="form-group">
				<button class="btn btn-danger" id="createtemp">开 始 生 成</button>
			</div>
        </div>
    </div>
</div>
<div class="row" style="margin-top:20px">

    <?php
    if(!empty($arrCreateloglist)){
        foreach ($arrCreateloglist as $key => $value) {
    ?>
    <div class="col-md-12 rescreateinfo">
        <pre><a href="/m/manage/navigation?dirpath=<?php echo $value['dirname'];?>" target="_blank" class="btn btn-success btn-xs">添加为目录</a> <button class="btn btn-danger btn-xs deletefile" aid=<?php echo $value['id'];?>>移除文件</button><br><br>创建时间：<?php echo $value['ctime'];?><br><?php
            echo str_replace(",", "<br>", $value['file']);
        ?></pre>
    </div>
    <?php
        }
    }
    ?>
</div>
<div class="modal fade" id="createfile" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color:#d64635;font-weight: 900;">确认生成目录?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">放弃</button>
                <button type="button" class="btn btn-danger save" data-dismiss="modal">确认</button>
            </div>
        </div>
    </div>
</div>