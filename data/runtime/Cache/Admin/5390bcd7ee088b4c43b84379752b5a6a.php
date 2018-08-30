<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
	<script type="text/javascript">
	//全局变量
	var GV = {
	    ROOT: "/",
	    WEB_ROOT: "/",
	    JS_ROOT: "public/js/",
	    APP:'<?php echo (MODULE_NAME); ?>'/*当前应用名*/
	};
	</script>
    <script src="/public/js/jquery.js"></script>
    <script src="/public/js/wind.js"></script>
    <script src="/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
    <script>
    	$(function(){
    		$("[data-toggle='tooltip']").tooltip();
    	});
    </script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
<style type="text/css">
.pic-list li {
	margin-bottom: 5px;
}
.controls{margin-top: 5px;}
</style>
</head>
<body>
	<div class="wrap js-check-wrap" id="app">
		<ul class="nav nav-tabs">
			<li class="active"><a href="javascript:;" target="_self">案件详情</a></li>
			<li><a href="javascript:history.back(-1);"><?php echo L('BACK');?></a></li>
		</ul>
		<form class="form-horizontal" id="tagforms" method="post" enctype="multipart/form-data">
			<fieldset style="border-radius: 5px;border:1px solid #ccc;">
				<div class="control-group" style="margin-top: 10px;">
					<label class="control-label">所属客户：</label>
					<div class="controls">
						<?php echo ($nicename); ?> <?php echo ($mobile); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">责任律师：</label>
					<div class="controls">
						<?php echo ($layer); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">案件名称：</label>
					<div class="controls">
						<?php echo ($casename); ?>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">案件描述：</label>
					<div class="controls">
						<?php echo ($casedesc); ?>
					</div>
				</div>				
			</fieldset>
			<hr/>
			<fieldset>
				<?php if(is_array($updatelist)): $i = 0; $__LIST__ = $updatelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><div class="control-group">
					<label class="control-label">最新进展：</label>
					<div class="controls">
						<?php echo ($va["desc"]); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">更新时间：</label>
					<div class="controls">
						<?php echo (date('Y-m-d H:i',$va["addtime"])); ?>
					</div>
				</div>
				<hr/><?php endforeach; endif; else: echo "" ;endif; ?>
			</fieldset>
		</form>
	</div>
	<script type="text/javascript" src="/public/js/common.js"></script>
	<script src="/public/js/vue.js"></script>
	<script src="/public/js/content_addtop.js"></script>
	<script src="/public/js/define_my.js"></script>
	<script src="/public/js/artDialog/artDialog.js"></script>

</body>
</html>