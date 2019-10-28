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
                        <form method='get' action="/Kb_article/index">

                        </form>
                    </div>
                </div>
                <div class="table-responsive" style="margin-top:20px;">
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        
						<th>标题</th>
						<th>分类</th>
						<th>修改时间</th>
                        <th>创建时间</th>
                        <th>编辑</th>
						<th>预览</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (! empty($list)) {
                        foreach ($list as $key => $value) {
                            
                    ?>
                    <tr>
                        
						<td><?php echo $value['title'];?></td>
						<td><?php echo $value['tags'];?></td>
						<td><?php echo $value['mtime'];?></td>
                        <td><?php echo $value['ctime'];?></td>
                        <td><a class="btn btn-danger btn-xs" href="/kb_article/updateArticle?id=<?php echo $value['id'];?>">编辑</a></td>
						<td><button aid="<?php echo $value['id'];?>" class="btn btn-warning btn-xs viewaritcle">预览</button><a href="/kb_article/articleInfoById?id=<?php echo $value['id'];?>" class="btn btn-success btn-xs">页面效果</a></td>
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
<div class="modal fade" id="viewaritcle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">预览</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    $(function(){
        $(".viewaritcle").click(function(){
            $("#viewaritcle").modal("show");
            var id = $(this).attr("aid");
            $.loadajax({
                url:"/Kb_article/getView?id="+id,
                success:function(res){
                    if(res.code!=1){
                        alert(res.msg);
                        return false;
                    }
                    data = res.data;
                    $("#viewaritcle .modal-body").html(data["html_content"]);
                }
            })
        })
    })
</script>