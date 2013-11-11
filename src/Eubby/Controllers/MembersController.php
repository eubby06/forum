<?php namespace Eubby\Controllers;

use View, Input, Redirect, Auth;

class MembersController extends BaseController
{
	public function getIndex()
	{
		$members = $this->getObject('user')->paginate(10);

		$this->layout->content = View::make("theme::{$this->theme}.frontend.user.index")
												->with('members', $members);
		return $this->layout;
	}

	public function getProfile($username = null)
	{
		if(is_null($username)) return Redirect::back();

		$member = $this->getObject('user')->where('username',$username)->first();
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

		$member = $this->getObject('user')->where('username',$username)->first();

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

		$member = $this->getObject('user')->where('username',$username)->first();

		if (!is_null($member))
		{
			$this->layout->content = View::make("theme::{$this->theme}.frontend.user.activities")
										->with('member', $member);

			return $this->layout;
		}

		return Redirect::back()->withErrors('Member could not be found.');
	}

	public function postGroup()
	{
		$do = (Input::get('do')) ? Input::get('do') : null;
		$uid = (Input::get('uid')) ? Input::get('uid') : null;
		$group = (Input::get('group')) ? Input::get('group') : null;

		//no need to proceed if two vars are null
		if (is_null($do) || is_null($uid) || is_null($group)) return Redirect::back();

		$member = $this->getObject('user')->find($uid);

		if ($member)
		{
			$member->groups()->sync(array($group));
			return Redirect::back()->with('success', 'Group has been changed.');
		}

		return Redirect::back()->withError('User could not be found');
	}

	public function getGroup()
	{
		$do = (Input::get('do')) ? Input::get('do') : null;
		$uid = (Input::get('uid')) ? Input::get('uid') : null;

		//no need to proceed if two vars are null
		if (is_null($do) || is_null($uid)) return Redirect::back();

		//get member
		$member = $this->getObject('user')->find($uid);
		$groups = $this->getObject('group')->groupsForHtml();

		if ($do == 'change')
		{
			$this->layout->content = View::make("theme::{$this->theme}.frontend.user.group")
										->with('member', $member)
										->with('groups', $groups);

			return $this->layout;		
		}

		return Redirect::back();
	}

	public function getSuspend($id = null)
	{
		if(is_null($id)) return Redirect::back();

		$moderator = $this->getObject('acl')->getUser();
		$member = $this->getObject('user')->find($id);

		if (is_null($member->ban))
		{
			$this->getObject('ban')->create(array(
				'user_id' => $member->id,
				'moderator_id' => $moderator->id
				));
			return Redirect::back()->with('success', 'User has been banned.');
		}
		else if (!$member->isSuspended())
		{
			$member->ban->unbanned = 0;
			$member->ban->save();

			return Redirect::back()->with('success', 'User has been banned.');
		}
			
		return Redirect::back()->withErrors('User could not be banned.');
	}

	public function getUnSuspend($id = null)
	{
		if(is_null($id)) return Redirect::back();

		$member = $this->getObject('user')->find($id);

		if ($member->isSuspended())
		{
			$member->ban->update(array('unbanned' => '1'));

			return Redirect::back()->with('success', 'User has been unbanned.');
		}

		return Redirect::back()->withErrors('User could not be banned.');
	}

	public function getDelete($id = null)
	{
		if(is_null($id)) return Redirect::back();

		$member = $this->getObject('user')->find($id);

		if ($member)
		{
			$member->delete();
			return Redirect::route('members')->with('success', 'User has been deleted.');
		}

		return Redirect::back()->withErrors('User could not be deleted.');
	}
}