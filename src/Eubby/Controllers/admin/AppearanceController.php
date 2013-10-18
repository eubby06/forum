<?php namespace Eubby\Controllers\Admin;

use View, Input, Redirect, Auth;

class AppearanceController extends AdminController
{
	public function getIndex()
	{
		$this->layout->content = View::make("theme::{$this->theme}.backend.appearance");
		return $this->layout;
	}
}