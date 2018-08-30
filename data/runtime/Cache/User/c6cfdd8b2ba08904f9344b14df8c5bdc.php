<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8">
  <title>我的案件</title>
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
  <!--我的案件-->
  <section class="case-container">
    <header class="case-hd app-flex">
      <div class="case-name app-basis2">案件名称</div>
      <div class="case-name app-basis">更新时间</div>
    </header>
    <ul class="case-list">
      <?php if(is_array($caselist)): $i = 0; $__LIST__ = $caselist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="case-item">
        <a class="app-flex app-vertical-center" href="<?php echo U('User/center/detail',array('id'=>$va['id']));?>">
          <h4 class="app-basis2"><?php echo ($va["casename"]); ?></h4>
          <h5 class="app-basis"><?php if($va['updatetime'] != ''): echo (date('Y-m-d H:i',$va["updatetime"])); else: echo (date('Y-m-d H:i',$va["addtime"])); endif; ?></h5>
        </a>
      </li><?php endforeach; endif; else: echo "" ;endif; ?>
      <?php if(count($caselist) == 0): ?><center style="color: #398c9f;margin-top: 20px;font-size: 0.8rem;">您没有任何案件哦</center><?php endif; ?>
    </ul>
  </section>
  <div class="logout-btn">
    <a href="<?php echo U('User/Center/logout');?>">退出登录</a>
  </div>
</body>
<script src="/public/libs/fixed.js"></script>
</html>