<?php namespace Eubby\Controllers;

use View, Input, Redirect, Auth;

class ProfileController extends BaseController 
{
	public function getIndex($username)
	{
		return $username;
	}
}