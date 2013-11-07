<?php namespace Eubby\Controllers\Admin;

use View, Input, Redirect, Auth;

class DashboardController extends AdminController
{
	public function getIndex()
	{
		$stats = $this->provider->getForumStats()->find(1);

		$this->layout->content = View::make("theme::{$this->theme}.backend.dashboard")
									->with('stats', $stats);
		return $this->layout;
	}
}