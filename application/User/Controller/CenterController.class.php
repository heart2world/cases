<?php
namespace User\Controller;

use Common\Controller\MemberbaseController;

class CenterController extends MemberbaseController {
	
	function _initialize(){
		parent::_initialize();
	}
	
    // 会员中心首页
	public function index() {
		
		$list =M('caselist')->where("userid='".$_SESSION['user']['id']."'")->select();
		$this->assign('caselist',$list);
    	$this->display(':center');
    }

    public function detail()
    {
    	$id=I('id','','intval');
    	$info =M('caselist')->find($id);
    	if(empty($info))
    	{
    		$this->error('该案件不存在',U('User/center/index'));
    	}
    	$list =M('caseupdate')->where("parentid='$id'")->order('addtime asc')->select();
    	$this->assign('info',$info);
    	$this->assign('cases',$list);
    	$this->display(':casedetail');
    }
    //退出
    public function logout(){
    	$ucenter_syn=C("UCENTER_ENABLED");
    	$login_success=false;
    	if($ucenter_syn){
    		include UC_CLIENT_ROOT."client.php";
    		echo uc_user_synlogout();
    	}
    	session("user",null);//只有前台用户退出
    	redirect(U('User/Login/index'));
    }
}
