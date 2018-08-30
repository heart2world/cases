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
</head>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="javascript:;">客户列表</a></li>
			<li><a href="<?php echo U('Member/add');?>">新增客户</a></li>
		</ul>
		<form class="well form-search" method="post" action="<?php echo U('Member/index');?>">
			客户姓名/手机：
			<input type="text" name="keyword" style="width: 150px;" value="<?php echo ((isset($formget["keyword"]) && ($formget["keyword"] !== ""))?($formget["keyword"]):''); ?>" placeholder="请输入客户姓名/手机">&nbsp;	
			<input type="submit" class="btn btn-primary" value="查询" />
			<a class="btn btn-danger" href="<?php echo U('Member/index');?>">清空</a>
		</form>
		<form class="js-ajax-form" action="" method="post">
			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr>
						
						<th style="min-width: 50px;text-align: center;">ID</th>
						<th style="min-width: 200px;text-align: center;">客户姓名</th>
						<th style="min-width: 200px;text-align: center;">客户电话</th>
						<th style="min-width: 100px;text-align: center;">性别</th>
						<th style="min-width: 150px;text-align: center;">添加时间</th>
						<th style="min-width: 200px;text-align: center;"><?php echo L('ACTIONS');?></th>
					</tr>
				</thead>
				<?php if(is_array($member)): foreach($member as $key=>$vo): ?><tr>					
                    <td style="text-align: center;"><b><?php echo ($vo["id"]); ?></b></td>                   
					<td style="text-align: center;"><?php echo ($vo["nicename"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["mobile"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["sex"]); ?></td>
					
					<td style="text-align: center;"><?php echo (date('Y-m-d H:i',$vo["addtime"])); ?></td>
					<td style="text-align: center;">
						<a class="btn js-ajax-delete"  style="padding: 2px 15px;color: black;" href="<?php echo U('member/delete',array('id'=>$vo['id']));?>"><?php echo L('DELETE');?></a>
						<a href='<?php echo U("member/edit",array("id"=>$vo["id"]));?>' style="padding: 2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-primary"><?php echo L('EDIT');?></a> 						
					</td>
				</tr><?php endforeach; endif; ?>
				
			</table>
			
			<div class="pagination"><?php echo ($page); ?></div>
		</form>
	</div>
	<script src="/public/js/common.js"></script>
	<script type="text/javascript">	
	   function loadArea(areaId,areaType) {
		    $.post("<?php echo U('Member/getArea');?>",{'areaId':areaId},function(data){
		        if(areaType=='district'){
		           $('#'+areaType).html('<option value="-1">镇/区</option>');
		        }
		        if(areaType!='null'){
		            $.each(data,function(no,items){
		            	if(items.region_name)
		            	{
			            	 opt = $("<option/>").text(items.region_name).attr("value", items.region_id);
			            	 $('#'+areaType).append(opt);
		            	}
		                
		            });
		            
		        }
		    });
		} 
  </script>
</body>
</html>