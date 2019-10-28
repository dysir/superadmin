<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title><?php $_titleHome =c("title");  echo $_titleHome.=(!empty($_title)?"_".$_title:"");  ?></title>
    <link href="<?=static_url('global/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css"/>
    <script src="<?=static_url('global/plugins/jquery.min.js')?>" type="text/javascript"></script>
    <script src="<?=static_url('global/plugins/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>

    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <style type="text/css">
  .footer{
    border-top: 4px solid #eee;
    height: 50px;
    background: white;
    text-align: center;
  }
  .footer h5{
    line-height:55px;
  }
  </style>
  <body>
    <div class="container-fluid">

    <link href="<?=static_url('editor/css/editormd.css')?>" rel="stylesheet" type="text/css"/>

    <div class="row" >
      <div class="col-md-12">
        <h2><?php echo empty($title)?"":$title;?></h2>
      </div>
      <div class="col-md-12 markdown-body" id="article_content" style="margin-top:20px;">
        <?php echo empty($html_content)?"":$html_content;?>
      </div>
    </div>


    </div>
    <div class="footer" style="margin-top: 20px;">
      <div class="row" style="margin-top: 20px;font-size: 20px;">
          <div class="col-xs-3" style="text-align: center;">
          </div>
          <div class="col-xs-6" style="text-align: center;">
              <div>关注</div>
          </div>
          <div class="col-xs-3" style="text-align: center;">
          </div>
        </div>
      <div class="row" style="margin-top: 20px;">

          <div class="col-xs-12" style="font-size: 20px;margin-bottom: 20px;">
            企鹅群：669852173
          </div>
      </div>

    </div>

  </body>
</html>