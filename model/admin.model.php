<?php

class admin extends medoo
{
	public function cat_list()
	{
		$datas = $this->select("shop_cat", [
			"id",
			"catname"
		], [
			"ORDER" => "id"
		]);

		return $datas;
	}

	public function cat_add( $catname )
	{
		$last_cat_id = $this->insert("shop_cat", [
			"catname" => $catname
		]);

		return $last_cat_id;
	}

	public function cat_update( $cat )
	{
		$update_num = $this->update("shop_cat", [
			"catname" => $cat['catname']
		], [
			"id[=]" => $cat['id']
		]);

		return $update_num;
	}

	public function data_delete( $table , $id )
	{
		$delete_num = $this->delete($table, [
			"id[=]" => $id
		]);

		return $delete_num;
	}

	public function content_list( $deadline )
	{
		$datas = $this->select("shop_content", [
			"id",
			"title",
			"cat",
			"date",
			"picture",
			"url"
		], [
			"date[>]" => $deadline,
			"ORDER" => "date DESC",
			"ORDER" => "id DESC"
		]);

		return $datas;
	}

	public function dead_list( $deadline )
	{
		$datas = $this->select("shop_content", [
			"id",
			"title",
			"cat",
			"date",
			"picture",
			"url"
		], [
			"date[<=]" => $deadline,
			"ORDER" => "date DESC"
		]);

		return $datas;
	}

	public function content_add( $content )
	{
		$last_content_id = $this->insert("shop_content", [
			"title" => $content['title'],
			"cat" => $content['cat'],
			"date" => $content['date'],
			"picture" => $content['picture'],
			"url" => $content['url'],
		]);

		return $last_content_id;
	}

	public function get_content_by_id( $id )
	{
		$datas = $this->select("shop_content", [
			"id",
			"title",
			"cat",
			"date",
			"picture",
			"url"
		], [
			"id[=]" => $id
		]);

		return $datas;
	}

	public function content_update( $content )
	{
		$update_num = $this->update("shop_content", [
			"title" => $content['title'],
			"cat" => $content['cat'],
			"date" => $content['date'],
			"picture" => $content['picture'],
			"url" => $content['url']
		], [
			"id[=]" => $content['id']
		]);

		return $update_num;
	}

	public function passwd_update( $passwd )
	{
		$update_num = $this->update("shop_user", [
			"password" => $passwd
		], [
			"username[=]" => $_SESSION['user']
		]);

		return $update_num;
	}

	public function cat_to_name( $catid )
	{
		$datas = $this->select("shop_cat", [
			"catname"
		], [
			"id[=]" => $catid
		]);

		return $datas[0]['catname'];
	}
}