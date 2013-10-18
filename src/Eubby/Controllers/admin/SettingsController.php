<?php namespace Eubby\Controllers\Admin;

use View, Input, Redirect, Auth;

class SettingsController extends AdminController
{
	public function getIndex()
	{
		$this->layout->content = View::make("theme::{$this->theme}.backend.settings");
		return $this->layout;
	}
}