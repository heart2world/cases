<?php
// +----------------------------------------------------------------------
// | 会员管理
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: gaoqiang <649180397@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class MemberController extends AdminbaseController {
	public function index()
	{
		$where = array();
		/**搜索条件**/
		
		$formget = array_merge($_GET,$_POST);
		$keyword =$formget['keyword'];		
		if($keyword){
            $keyword_complex=array();
            $keyword_complex['nicename']  = array('like', "%$keyword%");
            $keyword_complex['mobile']  = array('like',"%$keyword%");
            $keyword_complex['_logic'] = 'or';
            $where['_complex'] = $keyword_complex;
		}
		
		$count=M('member')->where($where)->count();
		$page = $this->page($count, 20);
        $users = M('member')
            ->where($where)
            ->order("addtime DESC")
            ->limit($page->firstRow, $page->listRows)
            ->select();
        
		foreach ($users as $key => $value) {
			switch ($value['sex']) {
				case '1':
					$users[$key]['sex'] ='男';
					break;
				case '2':
					$users[$key]['sex'] ='女';
					break;
				default:
					$users[$key]['sex'] ='其他';
					break;
			}

		}
		$this->assign("page", $page->show('Admin'));
		
		$this->assign("member",$users);
		$this->assign("formget",$formget);
        $this->display();
	}
	public function add()
	{
		$this->display();
	}
	public function add_post()
	{
		if(IS_POST)
		{
			$pdata =I('post.');
			if(empty($pdata['nicename']))
			{
				$this->ajaxReturn(array('status' =>1 ,'msg'=>'请输入客户姓名' ));
			}
			if(empty($pdata['mobile']))
			{
				$this->ajaxReturn(array('status' =>1 ,'msg'=>'请输入客户电话' ));
			}else
			{
				if(!preg_match('/^1[34578]{1}\d{9}$/',trim($pdata['mobile'])))
				{
					$this->ajaxReturn(array('status' =>1 ,'msg'=>'请输入正确的电话' ));				
				}
			}
			$count =M('member')->where("mobile='".$pdata['mobile']."'")->count();
			if($count >0)
			{
				$this->ajaxReturn(array('status' =>1 ,'msg'=>'此客户电话已经存在' ));	
			}
			$pdata['user_status']=1;
			$pdata['addtime']=time();
			$pdata['password'] = sp_password('123456');
			$res=M('member')->add($pdata);
			if($res)
			{
				$this->ajaxReturn(array('status' =>0 ,'msg'=>'保存成功' ));	
			}
		}
	}
	public function edit()
	{
		$id = I('get.id',0,'intval');		
		$user=M('member')->where(array("id"=>$id))->find();
		$this->assign($user);
		$this->display();
	}
	
	public function edit_post(){
		if (IS_POST) {
			$pdata =I('post.');
			if(empty($pdata['nicename']))
			{
				$this->ajaxReturn(array('status' =>1 ,'msg'=>'请输入客户姓名' ));
			}
			if(empty($pdata['mobile']))
			{
				$this->ajaxReturn(array('status' =>1 ,'msg'=>'请输入客户电话' ));
			}else
			{
				if(!preg_match('/^1[34578]{1}\d{9}$/',trim($pdata['mobile'])))
				{
					$this->ajaxReturn(array('status' =>1 ,'msg'=>'请输入正确的电话' ));				
				}
			}
			if($pdata['mobile'] !=$pdata['oldmobile'])
			{
				$count =M('member')->$count =M('member')->where("mobile='".$pdata['mobile']."'")->count();
				if($count >0)
				{
					$this->ajaxReturn(array('status' =>1 ,'msg'=>'此客户电话已经存在' ));	
				}
			}
			$res=M('member')->where("id='".$pdata['id']."'")->save($pdata);
			$this->ajaxReturn(array('msg'=>'保存成功','status'=>0));
		}
	}
	// 客户删除
	public function delete(){
	    $id = I('get.id',0,'intval');

		if (M('member')->delete($id)!==false) {
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
}