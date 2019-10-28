<link href="<?=static_url('editor/css/editormd.css')?>" id="style_components" rel="stylesheet" type="text/css"/>

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
        <input type="text" value="<?php echo empty($_GET['id'])?"":$_GET['id'];?>" id="articleId" style="display: none;" name="">

            <input value="<?php echo empty($title)?"":$title;?>" type="text" class="form-control" id="articleTitle" placeholder="输入标题" style="margin-bottom: 20px;">
        
        <div id="test-editormd">
            <textarea style="display:none;"><?php echo empty($mark_content)?"":$mark_content;?></textarea>
        </div>
    </div>
    <div class="col-md-12">
        <?php
        if(empty($_GET['id'])){
        ?>
        <button type="button" id="createArticle" class="btn btn-danger">创建文章</button>
        <?php
        }else{
        ?>
          <button type="button" id="updateArticle" class="btn btn-danger">更新至数据库</button>
        <?php  
        }
        ?>
    </div>
</div>

<script src="<?=static_url('editor/editormd.js')?>"></script>
<script type="text/javascript">
    var testEditor;

    $(function() {
        testEditor = editormd("test-editormd", {
            width   : "100%",
            height  : 640,
            syncScrolling : "single",
            path    : "<?=static_url('editor/lib/')?>",
            saveHTMLToTextarea : true,
            onchange : function() {
                var mark_content = this.getValue();
                $.ajax({
                    url:"/Kb_article/saveArticle",
                    type:"post",
                    data:{
                        "id":$("#articleId").val(),
                        "mark_content":mark_content,
                        "title":$("#articleTitle").val(),
                    }
                })

            }
        });
        $("#createArticle").click(function(){
            
            if( !confirm("确认创建?") ){
                return false;
            }
            var mark_content = testEditor.getValue();
            var html_content = testEditor.getHTML();

            $.loadajax({
                url:"/Kb_article/addArticle",
                type:"post",
                data:{
                    "id":$("#articleId").val(),
                    "mark_content":mark_content,
                    "html_content":html_content,
                    "title":$("#articleTitle").val(),
                },
                success:function(res){
                    if(res.code !=1){
                        alert(res.msg);
                        return false;
                    }
                    location.reload();
                }
            })
        })
        $("#updateArticle").click(function(){

            var mark_content = testEditor.getValue();
            var html_content = testEditor.getHTML();

            $.loadajax({
                url:"/Kb_article/addupdateArticle",
                type:"post",
                data:{
                    "id":$("#articleId").val(),
                    "mark_content":mark_content,
                    "html_content":html_content,
                    "title":$("#articleTitle").val(),
                },
                success:function(res){
                    if(res.code !=1){
                        alert(res.msg);
                        return false;
                    }
                    location.reload();
                }
            })
        })
    });
</script>