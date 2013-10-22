<?php namespace Eubby\Controllers\Admin;

use View, Input, Redirect, Auth;

class AppearanceController extends AdminController
{
	public function getIndex()
	{
		$settings = $this->settings->find(1);

		$this->layout->content = View::make("theme::{$this->theme}.backend.appearance")
										->with('settings', $settings);
		return $this->layout;
	}

	public function postIndex()
	{
		$settings = $this->settings->find(1);

		$settings->update(array('theme' => Input::get('theme')));

		return Redirect::back()->with('success', 'Theme has been selected.');
	}
}