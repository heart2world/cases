<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>案件详情</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="apple-mobile-web-app-title" content="案件查询">
	<meta name="format-detection" content="telephone=no,address=no,email=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="renderer" content="webkit">
	<meta name="HandheldFriendly" content="true">
	<meta name="screen-orientation" content="portrait">
	<meta name="x5-orientation" content="portrait">
	<meta name="full-screen" content="yes">
	<meta name="keywords" content="案件查询系统">
	<meta name="description" content="案件查询系统">
	<link rel="stylesheet" href="/public/style/base.min.css">
	<link rel="stylesheet" href="/public/style/app.css">
	<script src="/public/libs/jq.min.js"></script>
	<script src="/public/libs/v.min.js"></script>
</head>
<body>
	<!--案件详情-->
	<section class="case-info" style="padding-top: 0px;">
		<section class="case-wrap">
			<div class="case-mititle">案件名称：&nbsp;<?php echo ($info["casename"]); ?></div>
			<div class="case-mititle">责任律师：&nbsp;<?php echo ($info["layer"]); ?></div>
			<div class="case-mititle">案件描述：&nbsp;</div>
			<div class="case-text">
				<?php echo ($info["casedesc"]); ?>
			</div>
			<div class="case-title">创建时间：&nbsp;<?php echo (date('Y-m-d H:i',$info["addtime"])); ?></div>
		</section>
		<?php if(is_array($cases)): $i = 0; $__LIST__ = $cases;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><section class="case-wrap">
			<div class="case-mititle">最新进展：&nbsp;</div>
			<div class="case-text">
				<?php echo ($va["desc"]); ?>
			</div>
			<div class="case-title">更新时间：&nbsp;<?php echo (date('Y-m-d H:i',$va["addtime"])); ?></div>
		</section><?php endforeach; endif; else: echo "" ;endif; ?>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
</html>