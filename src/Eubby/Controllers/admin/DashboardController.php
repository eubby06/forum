<?php namespace Eubby\Controllers\Admin;

use View, Input, Redirect, Auth;

class DashboardController extends AdminController
{
	public function getIndex()
	{
		$this->layout->content = View::make("theme::{$this->theme}.backend.dashboard");
		return $this->layout;
	}
}