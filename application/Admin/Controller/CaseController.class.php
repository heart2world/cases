<?php
// +----------------------------------------------------------------------
// | 案件管理
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: gaoqiang <649180397@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class CaseController extends AdminbaseController {
    
	
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
		if($formget['casename'])
		{
			$where['casename'] = array('like',"%".$formget['casename']."%" );
		}
		$count=M('caselist')->where($where)->count();
		$page = $this->page($count, 20);
        $users = M('caselist')
            ->where($where)
            ->order("addtime DESC")
            ->limit($page->firstRow, $page->listRows)
            ->select();

		$this->assign("page", $page->show('Admin'));		
		$this->assign("list",$users);
		$this->assign("formget",$formget);
        $this->display();
	}
	
	// 案件添加
	public function add(){
		$this->display();
	}
	
	// 案件添加提交
	public function add_post(){
		if(IS_POST){
			$pdata =I('post.');
			if(empty($pdata['userid']))
			{
				$this->ajaxReturn(array('status'=>1,'msg'=>'请选择所属客户'));
			}
			if(empty($pdata['layer']))
			{
				$this->ajaxReturn(array('status'=>1,'msg'=>'请输入责任律师'));
			}
			if(empty($pdata['casename']))
			{
				$this->ajaxReturn(array('status'=>1,'msg'=>'请输入案件名称'));
			}
			if(empty($pdata['casedesc']))
			{
				$this->ajaxReturn(array('status'=>1,'msg'=>'请输入案件描述'));
			}
			$memberinfo =M('member')->where("id='".$pdata['userid']."'")->find();
			$pdata['addtime'] =time();
			$pdata['nicename'] =$memberinfo['nicename'];
			$pdata['mobile'] =$memberinfo['mobile'];
			$pdata['casedesc'] =strcontentjs(htmlspecialchars_decode($pdata['casedesc']));
			$res=M('caselist')->add($pdata);
			if($res)
			{
				$this->ajaxReturn(array('status'=>0,'msg'=>'保存成功'));
			}
		}
	}
	
	// 案件编辑
	public function edit(){
		$id=I("get.id",0,'intval');
		$ad=M('caselist')->where(array('id'=>$id))->find();

		$updatelist=M('caseupdate')->where("parentid='$id'")->order('addtime asc')->select();
		$this->assign($ad);
		$this->assign('updatelist',$updatelist);
		$this->display();
	}
	// 案件详情
	public function detail(){
		$id=I("get.id",0,'intval');
		$ad=M('caselist')->where(array('id'=>$id))->find();

		$updatelist=M('caseupdate')->where("parentid='$id'")->order('addtime asc')->select();
		$this->assign($ad);
		$this->assign('updatelist',$updatelist);
		$this->display();
	}
	// 案件编辑提交
	public function edit_post(){
		if (IS_POST) {
			$pdata =I('post.');

			if(empty($pdata['desc']))
			{
				$this->ajaxReturn(array('status'=>1,'msg'=>'请输入案件进展'));
			}
			$pdata['parentid'] =$pdata['id'];
			unset($pdata['id']);
			$pdata['addtime'] =time();
			$pdata['desc'] =strcontentjs(htmlspecialchars_decode($pdata['desc']));
			$res=M('caseupdate')->add($pdata);
			if($res)
			{
				M('caselist')->where("id='".$pdata['parentid']."'")->save(array('updatetime'=>time()));
				$this->ajaxReturn(array('status'=>0,'msg'=>'更新成功','url'=>U('Case/edit',array('id'=>$pdata['parentid']))));
			}
		}
	}
	
	// 案件删除
	public function delete(){
		$id = I("get.id",0,"intval");
		if (M('caselist')->delete($id)!==false) {
			M('caseupdate')->where("parentid='$id'")->delete();
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
	

	function getmembers()
    {
        $key =I('keyword','','trim');
        $list= M('member')->field('id,nicename,mobile')->where("nicename like '%$key%' or mobile like '%$key%'")->select();
        foreach ($list as $key => $value) {
            $list[$key]['value'] =$value['id'];
            $list[$key]['text'] =$value['nicename'].' '.$value['mobile'];          
        }
        $this->ajaxReturn(array('list'=>$list));

    }
}