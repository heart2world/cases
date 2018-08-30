<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>案件查询系统</title>
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
		<div class="input-cell app-flex app-vertical-center">
			<label for="uanme">姓名:</label>
			<div class="input-control app-basis">
				<input type="text" placeholder="请在此输入姓名" v-model="uname" maxlength="10" />
			</div>
		</div>
		<div class="input-cell app-flex app-vertical-center">
			<label for="uanme">性别:</label>
			<div class="input-control app-basis">
				<select name="gender" v-model="gender">
					<option value="0">请选择性别</option>
					<option value="1">男</option>
					<option value="2">女</option>
					<option value="3">其他</option>
				</select>
			</div>
		</div>
		<div class="input-cell app-flex app-vertical-center">
			<label for="uanme">手机号:</label>
			<div class="input-control app-basis">
				<input type="tel" pattern="[0-9]*" placeholder="请在此输入登录手机号" v-model="phone" maxlength="11" />
			</div>
		</div>
		<div class="input-cell app-flex app-vertical-center">
			<label for="uanme">密码:</label>
			<div class="input-control app-basis">
				<input type="password" placeholder="请在此输入登录密码" v-model="pwd" maxlength="20" />
			</div>
		</div>
		<div class="input-cell app-flex app-vertical-center">
			<label for="uanme">验证码:</label>
			<div class="input-control app-basis">
				<input type="number" pattern="[0-9]*" placeholder="输入验证码" v-model="yzcode" maxlength="6" />
			</div>
			<div :class="{'disabled':!cando}" class="send-code-btn" @click="get_code($event);">获取验证码</div>
		</div>
		<div class="app-btn" data-role="register" @click="register($event);">注册</div>
		<div class="has-accout">
			<a href="<?php echo U('User/Login/index');?>">已有账号，直接登录</a>
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
			uname:'',
			gender:'0',
			phone:'',
			pwd:'',
			yzcode:'',
			cando:false
		},
		watch:{
			phone:function(){
				if(comJs._validateIsPhoneNum(this.phone)){
					this.cando = true;
				}else{
					this.cando = false;
				}

				return this.uname.replace(/\s/g,'');
			}
		},
		computed:{
			
		},
		methods:{
			get_code:function(evt){				
				$.ajax({
                    url: "<?php echo U('Api/Veryfity/send_msg');?>",
                    data: {send_address:this.phone,send_type:0},
                    type:'POST',
                    success: function (data) {
                        if (data.state==1) {                               
                            $.toast(data.error, 'forbidden');
                            return;
                        }else{
                        	comJs._sending(evt.target,60,this.cando,60); 
                        }
                    }
                });		
			},
			register:function(evt){
				if(this.uname == ''){
					$.toptip("请输入姓名",1500,'warning');
					return;
				}
				if(this.gender == 0){
					$.toptip("请选择性别",1500,'warning');
					return;
				}
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
				if(this.yzcode == ''){
					$.toptip("请输入验证码",1500,'warning');
					return;
				}

				//提交注册信息
				$.showLoading("提交中...");
				var profileInfo = {
                        "nicename": this.uname,
                        "sex" : this.gender,
                        "password" : this.pwd,
                        "mobile" :this.phone,
                        "yzcode":this.yzcode
                    };
				$.ajax({
                        url: "<?php echo U('User/Register/doregister');?>",
                        data: profileInfo,
                        type:'POST',
                        success: function (data) {
                            if (data.status==1) {                               
                                //数据提交成功后关闭提示
								setTimeout(function(){
									$.hideLoading();
									$.toast("注册成功！",'text',function(){
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