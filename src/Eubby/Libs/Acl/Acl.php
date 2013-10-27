<?php namespace Eubby\Libs\Acl;

use Auth, DB;
use Eubby\Models\Conversation;

class Acl implements AccessControlInterface
{

	protected $user = null;

	protected $auth = null;

	public function __construct()
	{
		$this->auth = Auth::getFacadeRoot();
	}

	public function getUser()
	{
		if (is_null($this->user))
		{
			$this->user = $this->auth->user();
		}
		return $this->user;
	}

	public function attempt($data, $remember)
	{
		return $this->auth->attempt($data, $remember);
	}

	public function logout()
	{
		return $this->auth->logout();
	}

	public function check()
	{
		return $this->auth->check();
	}

	public function isGuest()
	{
		return $this->auth->guest();
	}

	public function isUserActivated()
	{
		$user = $this->getUser();

		if (is_null($user))
		{
			return false;
		}

		return $user->activated == 1;
	}

	public function isAdmin()
	{
		return (in_array('Administrator', $this->listGroups()));
	}

	public function isMember()
	{
		return (in_array('Member', $this->listGroups()));
	}

	public function isModerator()
	{
		return (in_array('Moderator', $this->listGroups()));
	}

	public function listGroups()
	{
		return $this->getUser()->listGroups();
	}

	public function allowedToComment($channel_id)
	{
		$allowed = false;

		foreach ($this->listGroups() as $id => $name)
		{
			$permissions = DB::table('channel_permissions')
								->where('group_id', $id)
								->where('channel_id', $channel_id)
								->get();

			foreach ($permissions as $permission)
			{
				$allowed = ($permission->can_reply == 1) ? true : false;
			}

			if ($allowed == true) break;
		}

		return $allowed;
	}

	public function allowedToView($channel_id)
	{
		$allowed = false;

		foreach ($this->listGroups() as $id => $name)
		{
			$permissions = DB::table('channel_permissions')
								->where('group_id', $id)
								->where('channel_id', $channel_id)
								->get();

			foreach ($permissions as $permission)
			{
				$allowed = ($permission->can_view == 1) ? true : false;
			}

			if ($allowed == true) break;
		}

		return $allowed;
	}

	public function lastVisit(Conversation $conversation)
	{
		$user = $this->getUser();

		$log = DB::table('read_posts')->where('post_id','=',$conversation->first_post_id)
										->where('user_id','=',$user->id)
										->first();

		return (is_null($log)) ? null : $log->updated_at;
	}

	public function logVisit(Conversation $conversation)
	{
		$user = $this->getUser();

		$log = $user->readposts()->where('post_id','=',$conversation->first_post_id)->first();

		if (is_null($log))
		{
			$user->readposts()->attach($conversation->first_post_id, array('created_at' => date('Y-m-d H:i:s')));
			return false;
		}

		$log->pivot->update(array('updated_at' => date('Y-m-d H:i:s')));
	}

	public function getGravatar($passed_settings = array())
	{
		return $this->getUser()->getGravatar($passed_settings);
	}
}