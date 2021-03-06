<?php namespace Eubby\Controllers;

use View, Input, Redirect, Auth, Response;

class PostsController extends BaseController 
{

	public function postAjaxDelete()
	{
		$pid = Input::get('pid');
		
		$post = $this->getObject('post')->find($pid);

		if (is_null($post)) return Response::json(array('result' => 'fail', 'message' => 'Post not found.'));

		$post->delete();

		return Response::json(array('result' => 'success', 'message' => 'Post has been removed.'));
	}

	public function postAjaxUpdate()
	{
		$id = Input::get('id');
		
		$post = $this->getObject('post')->find($id);

		if (is_null($post)) return Response::json(array('result' => 'fail', 'message' => 'Post not found.'));

		$post->message = Input::get('text');
		$post->save();

		return Response::json(array('result' => 'success', 'message' => 'Post has been updated.'));
	}
}