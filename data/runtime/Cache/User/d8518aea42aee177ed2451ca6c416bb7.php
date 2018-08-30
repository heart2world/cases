<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>忘记密码</title>
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
	<!--忘记密码-->
	<section class="form-container" id="app">
		<div class="input-cell app-flex app-vertical-center">
			<label for="uanme">手机号</label>
			<div class="input-control app-basis">
				<input type="tel" pattern="[0-9]*" placeholder="请在此输入登录手机号" v-model="phone" />
			</div>
		</div>
		<div class="input-cell app-flex app-vertical-center">
			<label for="uanme">新密码</label>
			<div class="input-control app-basis">
				<input type="password" placeholder="请在此输入登录密码" v-model="pwd" />
			</div>
		</div>
		<div class="input-cell app-flex app-vertical-center">
			<label for="uanme">再次确认</label>
			<div class="input-control app-basis">
				<input type="password" placeholder="请在此输入登录密码" v-model="pwd_confirm" />
			</div>
		</div>
		<div class="input-cell app-flex app-vertical-center">
			<label for="uanme">验证码</label>
			<div class="input-control app-basis">
				<input type="number" pattern="[0-9]*" placeholder="输入验证码" v-model="yzcode" maxlength="6" v-model="yzcode" />
			</div>
			<div :class="{'disabled':!cando}" class="send-code-btn" @click="get_code($event);">获取验证码</div>
		</div>
		<div class="app-btn" data-role="register" @click="refind($event);">确定</div>
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
			pwd:'',
			pwd_confirm:'',
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
                    data: {send_address:this.phone,send_type:1},
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
			refind:function(evt){
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
				if(this.pwd != this.pwd_confirm){
					$.toptip("前后密码不一致",1500,'warning');
					return;
				}
				if(this.yzcode == ''){
					$.toptip("请输入验证码",1500,'warning');
					return;
				}
				//找回密码
				$.showLoading("提交中...");
				var profileInfo = {
                        "mobile": this.phone,
                        "sex" : this.gender,
                        "password" : this.pwd,                     
                        "yzcode":this.yzcode
                    };
				$.ajax({
                        url: "<?php echo U('User/Login/doforgot_password');?>",
                        data: profileInfo,
                        type:'POST',
                        success: function (data) {
                            if (data.status==1) {                               
                                //数据提交成功后关闭提示
								setTimeout(function(){
									$.hideLoading();
									$.toast("密码找回成功！",'text',function(){
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