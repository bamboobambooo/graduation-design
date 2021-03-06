<?php
require "isLogin.php";
require "../common/class/smarty.php";
require "../common/class/sepPage.php";
if(isset($_GET['page'])){
	$pageNow=$_GET['page'];
}else{
	$pageNow=1;
};

if(isset($_GET['keyword'])&&!empty($_GET['keyword'])){
	$keyword=$_GET['keyword'];
	if(isset($_GET['type'])&&$_GET['type']==0){
		$type=$_GET['type'];
		$condition="where (sign(locate('$keyword',title))+sign(locate('$keyword',context))+sign(locate('$keyword',u_name)))>0";
	}
	if(isset($_GET['type'])&&$_GET['type']==1){
		$type=$_GET['type'];
		$condition="where (sign(locate('$keyword',title))+sign(locate('$keyword',context))+sign(locate('$keyword',u_name)))>0 and checked=0";
	}
	if(isset($_GET['type'])&&$_GET['type']==2){
		$type=$_GET['type'];
		$condition="where (sign(locate('$keyword',title))+sign(locate('$keyword',context))+sign(locate('$keyword',u_name)))>0 and checked=1";
	}

	$params = array(
	    'table'=>'thanks', #(必须)
	    'pageNow'  =>$pageNow,  #(必须)
	    'condition'=>$condition,
	    'pageRows' =>12, #(可选) 默认为15
    	'order'=>'p_date'
	);
}else{
	if(isset($_GET['type'])&&$_GET['type']==1){
		$type=$_GET['type'];
		$condition="where checked=0";
	}else if(isset($_GET['type'])&&$_GET['type']==2){
		$type=$_GET['type'];
		$condition="where checked=1";
	}else{
		$type=0;
		$condition='';
	}

	$keyword='';
	$params = array(
	    'table'=>'thanks', #(必须)
	    'pageNow'  =>$pageNow,  #(必须)
	    'condition'=>$condition,
	    'pageRows' =>12, #(可选) 默认为15
    	'order'=>'p_date'
	);
}
if(!isset($_GET['type'])){
	$type=0;
}
$smarty=new SmartyProject();
$sepPage = new page($params);
$page=$sepPage->showData();
if(isset($_GET['keyword'])&&!empty($_GET['keyword'])){
	if($page['list']){
		foreach($page['list'] as $key=>$value){
			foreach($value as $key2=>$value2){
				//print_r($value2."<br>");
				if($key2!='id'){
					$value2=str_ireplace($keyword, "<font color='#ff0000'>".$keyword."</font>", $value2);
						//echo $content."<br>";
					$page['list'][$key][$key2]=$value2;
				}
				
			}
		}
	}
}


$smarty->assign('page',$page);
$smarty->assign('keyword',$keyword);
$smarty->assign('type',$type);

// print_r($page);
$smarty->assign('mid',$mid);
$smarty->assign('mname',$mname);
$smarty->assign('mheadImg',$mheadImg);
$smarty->assign('title','thank');
$smarty->display('admin/t_list.tpl');
?>