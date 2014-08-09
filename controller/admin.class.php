<?php

class adminController extends medoo
{
	function __construct()
	{
		check_login();
	}

	function index()
	{
		$database = new admin();
		$datas['a'] = __FUNCTION__;
		$deadline = date('Y-m-d',strtotime('-3 day'));
		$datas['contents'] = $database->content_list( $deadline );
		$datas['dead'] = $database->dead_list( $deadline );
		$datas['cat'] = $database->cat_list();

		$size_contents = count($datas['contents']);
		$size_dead = count($datas['dead']);
		for ($i=0; $i < $size_contents; $i++) { 
			$datas['contents'][$i]['catname'] = $database->cat_to_name( $datas['contents'][$i]['cat'] );
		}
		for ($i=0; $i < $size_dead; $i++) { 
			$datas['dead'][$i]['catname'] = $database->cat_to_name( $datas['dead'][$i]['cat'] );
		}
		$this->display( $datas );
	}

	function cat()
	{
		$database = new admin();
		$datas['a'] = __FUNCTION__;
		$datas['cats'] = $database->cat_list();
		$this->display( $datas );
	}

	function delete_cat()
	{
		header("Content-type: text/html; charset=utf-8");
		$catid = addslashes($_GET['id']);
		$database = new admin();
		$result = $database->data_delete( 'shop_cat', $catid );
		if ($result == 1) {
			echo "<script>";
			echo "alert('删除成功');";
	      	echo "window.location.href = '?c=admin&a=cat' ";
	      	echo "</script>";
		}
		else{
			echo "<script>";
			echo "alert('删除失败，可能是由于该分类下的内容还未全部删除。');";
	      	echo "window.location.href = '?c=admin&a=cat' ";
	      	echo "</script>";
		}
		header("Content-type: text/html; charset=utf-8");
		
	}

	function delete_content()
	{
		header("Content-type: text/html; charset=utf-8");
		$contentid = addslashes($_GET['id']);
		$database = new admin();
		$result = $database->data_delete( 'shop_content', $contentid );
		if ($result == 1) {
			echo "<script>";
			echo "alert('删除成功');";
	      	echo "window.location.href = '?c=admin&a=index' ";
	      	echo "</script>";
		}
		else{
			echo "<script>";
			echo "alert('删除失败');";
	      	echo "window.location.href = '?c=admin&a=index' ";
	      	echo "</script>";
		}
	}

	function add_cat()
	{
		header("Content-type: text/html; charset=utf-8");
		$catname = addslashes($_POST['catname']);

		$database = new admin();
		$result = $database->cat_add( $catname );
		if ($result) {
			echo "<script>";
			echo "alert('添加分类成功');";
	      	echo "window.location.href = '?c=admin&a=cat' ";
	      	echo "</script>";
		}
		else{
			echo "<script>";
			echo "alert('添加分类失败');";
	      	echo "window.location.href = '?c=admin&a=cat' ";
	      	echo "</script>";
		}
	}

	function add_content()
	{
		header("Content-type: text/html; charset=utf-8");
		$content['title'] = addslashes($_POST['title']);
		$content['cat'] = addslashes($_POST['cat']);
		$content['date'] = addslashes($_POST['date']);
		$content['picture'] = addslashes($_POST['picture']);
		$content['url'] = addslashes($_POST['url']);

		$database = new admin();
		$result = $database->content_add( $content );
		if ($result) {
			echo "<script>";
			echo "alert('添加内容成功');";
	      	echo "window.location.href = '?c=admin&a=index' ";
	      	echo "</script>";
		}
		else{
			echo "<script>";
			echo "alert('添加内容失败');";
	      	echo "window.location.href = '?c=admin&a=index' ";
	      	echo "</script>";
		}
	}

	function update_cat()
	{
		header("Content-type: text/html; charset=utf-8");
		$cat['id'] = addslashes($_POST['pk']);
		$cat['catname'] = addslashes($_POST['value']);

		//print_r($_POST);
		$database = new admin();
		$result = $database->cat_update( $cat );
		if ($result) {
			echo $cat['catname'];
		}
		else{
			echo 'failed';
		}
	}

	function editcontent(){
		$id = addslashes($_GET['id']);

		$datas['a'] = 'index';
		$database = new admin();
		$datas['cat'] = $database->cat_list();
		$datas['content'] = $database->get_content_by_id( $id );
		$this->display( $datas );
	}

	function save_content()
	{
		header("Content-type: text/html; charset=utf-8");
		$content['id'] = addslashes($_POST['id']);
		$content['title'] = addslashes($_POST['title']);
		$content['cat'] = addslashes($_POST['cat']);
		$content['date'] = addslashes($_POST['date']);
		$content['picture'] = addslashes($_POST['picture']);
		$content['url'] = addslashes($_POST['url']);

		$database = new admin();
		$result = $database->content_update( $content );
		if ($result) {
			echo "<script>";
			echo "alert('编辑保存成功');";
	      	echo "window.location.href = '?c=admin&a=index' ";
	      	echo "</script>";
		}
		else{
			echo "<script>";
			echo "alert('编辑保存失败');";
	      	echo "window.location.href = '?c=admin&a=index' ";
	      	echo "</script>";
		}
	}

	function passwd()
	{
		$database = new admin();
		$datas['a'] = __FUNCTION__;
		$datas['cats'] = $database->cat_list();
		$this->display( $datas );
	}

	function save_passwd()
	{
		header("Content-type: text/html; charset=utf-8");
		$pass = addslashes($_POST['passwd']);

		$passwd = md5($pass);

		$database = new admin();
		$result = $database->passwd_update( $passwd );
		if ($result) {
			echo "<script>";
			echo "alert('密码修改成功');";
	      	echo "window.location.href = '?c=login&a=logout' ";
	      	echo "</script>";
		}
		else{
			echo "<script>";
			echo "alert('密码修改失败');";
	      	echo "window.location.href = '?c=admin&a=index' ";
	      	echo "</script>";
		}
	}

}