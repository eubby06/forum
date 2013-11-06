<?php namespace Eubby\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Eubby\Models\Base;
use Hash;
use Auth;
use Mail;
use DB;

class User extends Base implements UserInterface, RemindableInterface {


	protected $table 			= 'users';

	protected $validation_rules = array(
										'username' 	=> 'required|min:4|max:16',
										'email' 	=> 'required|email|unique:users',
										'password' 	=> 'required|min:4|max:20|confirmed');

	protected $fillable 		= array(
		'username',
		'password',
		'email',
		'ip_address',
	);

	protected $softDelete 		= true;

	protected $hidden 			= array('password');


	public static function boot()
	{
		parent::boot();

		static::created(function($user)
		{
			//create user profile
			$profile = $user->profile()->create(
						array(
							'location' 	=> 'to be updated',
							'about' 	=> 'to be updated',
						));

			//assign user to group
			$group = $user->groups()->attach(2);

			//create stats for newly created user
			$stats = $user->stats()->create(
					array(
						'posts_count' 						=> 0,
						'conversations_started_count' 		=> 0,
						'conversations_participated_count' 	=> 0,
						'last_post_id' 						=> 0
						));
		});
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

	public function isSuspended()
	{
		return ($this->ban && !$this->ban->unbanned) ? true : false;
	}

	public function isDeleted()
	{
		return (is_null($this->deleted_at)) ? false : true;
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

	public function notifications()
	{
		return $this->hasMany('Eubby\Models\Notification', 'user_id');
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