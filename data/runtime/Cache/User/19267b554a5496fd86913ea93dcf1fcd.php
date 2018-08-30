<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>登录</title>
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
	<link rel="stylesheet" href="/public/libs/weui/weui.min.css">
	<link rel="stylesheet" href="/public/libs/weui/jquery-weui.css">
	<script src="/public/libs/jq.min.js"></script>
	<script src="/public/libs/v.min.js"></script>
</head>
<body>
	<!--注册-->
	<section class="form-container" id="app">
		<div class="input-cell app-flex app-vertical-center" style="margin: 2.25rem 0;">
			<label for="uanme">手机号</label>
			<div class="input-control app-basis">
				<input type="tel" pattern="[0-9]*" placeholder="请在此输入登录手机号" v-model="phone" />
			</div>
		</div>
		<div class="input-cell app-flex app-vertical-center" style="margin: 2.25rem 0;">
			<label for="uanme">密码</label>
			<div class="input-control app-basis">
				<input type="password" placeholder="请在此输入登录密码"  v-model="pwd"/>
			</div>
		</div>
		<div class="app-btn" data-role="login" @click="login($event);">登录</div>
		<div class="forgot-pwd">
			<a href="<?php echo U('User/Login/forgot_password');?>">忘记密码？</a>
		</div>
		<div class="has-accout">
			<a href="<?php echo U('User/Register/index');?>">还没有(时济律师事务所)账号，去注册</a>
		</div>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/script/common.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
	$.toast.prototype.defaults.duration = 3000;

	var app = new Vue({
		el:'#app',
		data:{
			phone:'',
			pwd:''
		},
		methods:{
			login:function(evt){
				if(this.phone == ''){
					$.toptip("请输入手机号",1500,'warning');
					return;
				}
				if(!comJs._validateIsPhoneNum(this.phone)){
					$.toptip("请输入合法手机号",1500,'warning');
					return;
				}
				if(this.pwd == ''){
					$.toptip("请输入密码",1500,'warning');
					return;
				}

				//提交用户登录信息
				$.showLoading("正在登录...");
				$.ajax({
                        url: "<?php echo U('User/Login/dologin');?>",
                        data: {mobile:this.phone,password:this.pwd},
                        type:'POST',
                        success: function (data) {
                            if (data.status==1) {                               
                                //数据提交成功后关闭提示
  								setTimeout(function(){
  									$.hideLoading();
  									$.toast("登录成功！",'text',function(){
  										setTimeout(function(){
  											//跳转会员中心
  											location.href=data.url;
  										},500);
  									})
  								},1500)
                            }
                            else {
                                //跳转到预定失败界面
                                $.hideLoading();
                                $.toast(data.msg, 'forbidden');
                            }
                        }
                    });				
			}
		}
	});
</script>
</html>