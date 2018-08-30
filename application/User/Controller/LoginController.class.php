<?php
namespace User\Controller;

use Common\Controller\HomebaseController;

class LoginController extends HomebaseController {
	
    // 前台用户登录
	public function index(){
	    $redirect=I('get.redirect','');
	    if(empty($redirect)){
	        $redirect=$_SERVER['HTTP_REFERER'];
	    }else{
	        $redirect=base64_decode($redirect);
	    }
	    session('login_http_referer',$redirect);
	    
	    if(sp_is_user_login()){ //已经登录时直接跳到首页
	        redirect(U('User/center/index'));
	    }else{
	        $this->display(":login");
	    }
	}

	// 前台用户忘记密码
	public function forgot_password(){
		$this->display(":forgot_password");
	}
	
	// 前台用户忘记密码提交(邮件方式找回)
	public function doforgot_password(){
		if(IS_POST){
			$mobile=I('post.mobile');
            if(!check_send_code($mobile,$_POST['yzcode'])){
                $this->ajaxReturn(['status'=>0,'msg'=>'短信验证码错误']);
            }        
            
            $users_model=M("Member");
            $userinfo =$users_model->where("mobile='$mobile'")->find();
            if(empty($userinfo))
            {
                $this->ajaxReturn(array('status'=>0,'msg'=>'该手机号未注册'));
            }       
            $data=array(                
                'password' => sp_password(trim($_POST['password']))                
            );
            
            $result = $users_model->where("id='".$userinfo['id']."'")->save($data);
            
            session('user',null);
            $this->ajaxReturn(array('status'=>1,'url'=>U('User/Login/index')));   
		}
	}
		
    // 登录验证提交
    public function dologin(){
    	
    	$users_model=M("member");
    	$where = array("user_status"=>1);
        $where['mobile']=I('post.mobile');
        $password=I('post.password');
        $result = $users_model->where($where)->find();
        
        if(!empty($result)){
            if(sp_compare_password($password, $result['password'])){
                session('user',$result);
                //写入此次登录信息
                $data = array(
                    'last_login_time' => date("Y-m-d H:i:s"),
                    'last_login_ip' => get_client_ip(0,true),
                );
                $users_model->where(array('id'=>$result["id"]))->save($data);
                $this->ajaxReturn(array('status'=>1,'url'=>U('User/center/index')));               
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>'用户名或密码错误')); 
            }
        }else{
           $this->ajaxReturn(array('status'=>0,'msg'=>'用户不存在')); 
        }
    }
	
}