<?php namespace Eubby\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Eubby\Models\Base;
use Hash;
use Auth;
use Mail;
use DB;

class User extends Base implements UserInterface, RemindableInterface {


	protected $table = 'users';

	protected $validation_rules = array(
		'username' => 'required|min:4|max:16',
		'email' 	=> 'required|email|unique:users',
		'password' 	=> 'required|min:4|max:20|confirmed');

	protected $fillable = array(
		'username',
		'password',
		'email',
		'ip_address',
	);

	protected $hidden = array('password');

	 /////////////////////////////////////////////////////
	// ------------ USER PERMISSIONS ----------- START //
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

		 
	// ------------ USER PERMISSIONS ----------- START //
	/////////////////////////////////////////////////////


	 ////////////////////////////////////////////////
	// ------------ USER GROUPS ----------- START //
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
		$groups = array();

		foreach ($this->groups as $group)
		{
			$groups[$group->id] = $group->name;
		}

		return $groups;
	}
	 
	// ------------ USER GROUPS ----------- END //
   //////////////////////////////////////////////

	public function lastVisit(Conversation $conversation)
	{

		$log = DB::table('read_posts')->where('post_id','=',$conversation->first_post_id)
										->where('user_id','=',$this->id)
										->first();

		return (is_null($log)) ? null : $log->updated_at;
	}

	public function logVisit(Conversation $conversation)
	{
		$log = $this->readposts()->where('post_id','=',$conversation->first_post_id)->first();

		if (is_null($log))
		{
			$this->readposts()->attach($conversation->first_post_id, array('created_at' => date('Y-m-d H:i:s')));
			return false;
		}

		$log->pivot->update(array('updated_at' => date('Y-m-d H:i:s')));
	}

	public function isOnline()
	{
		return $this->session()->where('active',1)->first() ? true : false;
	}

	public function lastActive()
	{
		return (is_null($this->session)) ? 'never' : $this->session->updated_at->diffForHumans();
	}

	///////////////////////////////////////////////////
	// ------------ RELATIONSHIPS ----------- START //

	public function profile()
	{
		return $this->hasOne('Eubby\Models\Profile', 'user_id');
	}

	public function subscriptions()
	{
		return $this->belongsToMany('Eubby\Models\Conversation', 'conversations_subscribers');
	}

	public function session()
	{
		return $this->hasOne('Eubby\Models\Session', 'user_id');
	}

	public function posts()
	{
		return $this->hasMany('Eubby\Models\Post', 'user_id');
	}

	public function readposts()
	{
		return $this->belongstoMany('Eubby\Models\Post', 'read_posts')->withPivot('created_at','updated_at');
	}

	public function groups()
	{
		return $this->belongsToMany('Eubby\Models\Group', 'user_groups');
	}

	public function stats()
	{
		return $this->hasOne('Eubby\Models\UserStats', 'user_id');
	}

	public function histories()
	{
		return $this->hasMany('Eubby\Models\History', 'user_id');
	}

	public function ban()
	{
		return $this->hasOne('Eubby\Models\Ban', 'user_id');
	}

	public function bans()
	{
		return $this->hasMany('Eubby\Models\Ban', 'moderator_id');
	}
	 // ------------ RELATIONSHIPS ----------- END //
	////////////////////////////////////////////////


	public function hasSubscription($conversation_id)
	{
		$has = $this->subscriptions()->where('conversation_id','=',$conversation_id)->first();

		return (is_null($has)) ? false : true;
	}

	public function getGravatar($passed_settings = array()) {

		$settings = array(
			's' => 80,
			'd' => 'mm',
			'r' => 'g',
			'img' => false,
			'atts' => array()
			);

		$settings = array_replace($settings, $passed_settings);
		
	    $url = 'http://www.gravatar.com/avatar/';
	    $url .= md5( strtolower( trim( $this->email ) ) );
	    $url .= "?s={$settings['s']}&d={$settings['d']}&r={$settings['r']}";
	    if ($settings['img']) {
	        $url = '<img class="avatar_thumb" src="' . $url . '"';
	        foreach ( $settings['atts'] as $key => $val )
	            $url .= ' ' . $key . '="' . $val . '"';
	        $url .= ' />';
	    }
	    return $url;
	}

	protected function setPasswordAttribute($password)
	{
		$this->attributes['password'] = Hash::make($password);
	}

	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	public function getAuthPassword()
	{
		return $this->password;
	}

	public function getReminderEmail()
	{
		return $this->email;
	}

}