<?php namespace Eubby\Controllers;

use View, Input, Redirect, Auth;

class MembersController extends BaseController
{
	public function getIndex()
	{
		$members = $this->user->all();

		$this->layout->content = View::make("theme::{$this->theme}.frontend.members.index")
												->with('members', $members);
		return $this->layout;
	}

	public function getProfile($username = null)
	{
		if(is_null($username)) return Redirect::back();

		$member = $this->user->where('username',$username)->first();
		$profile = ($member->profile) ? $member->profile : null;

		if (!is_null($member))
		{
			$this->layout->content = View::make("theme::{$this->theme}.frontend.user.profile")
										->with('member', $member)
										->with('profile', $profile);

			return $this->layout;
		}

		return Redirect::back()->withErrors('Member could not be found.');
	}

	public function getStats($username = null)
	{
		if(is_null($username)) return Redirect::back();

		$member = $this->user->where('username',$username)->first();

		if (!is_null($member))
		{
			$this->layout->content = View::make("theme::{$this->theme}.frontend.user.stats")
										->with('member', $member);

			return $this->layout;
		}

		return Redirect::back()->withErrors('Member could not be found.');
	}

	public function getActivity($username = null)
	{
		if(is_null($username)) return Redirect::back();

		$member = $this->user->where('username',$username)->first();

		if (!is_null($member))
		{
			$this->layout->content = View::make("theme::{$this->theme}.frontend.user.activities")
										->with('member', $member);

			return $this->layout;
		}

		return Redirect::back()->withErrors('Member could not be found.');
	}

	public function getEdit($id = null)
	{
		return 'edit';
	}

	public function getDelete($id = null)
	{
		return 'delete';
	}
}