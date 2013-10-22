<?php namespace Eubby\Models;

use Eubby\Models\Base;
use Eubby\Models\User;
use Eubby\Models\ForumStats;
use Eubby\Models\UserStats;

class Conversation extends Base
{
	protected $table 			= 'conversations';

	protected $guarded 			= array('id');

	protected $validation_rules = array(
		'user_id' 		=> 'required|numeric', 
		'title' 		=> 'required|unique:conversations', 
		'channel_id' 	=> 'required|numeric');

	public static function boot()
	{
		parent::boot();

		static::created(function($conversation)
		{
			//create history
			$history = new History();
			$history->user_id = $conversation->user_id;
			$history->message = 'started a conversation --title-start--'.$conversation->title. '--title-end-- under --name-start--'.$conversation->channel->name.'--name-end--';
			$conversation->histories()->save($history);

			//update convesation table
			$conversation->channel->increment('conversations_count');

			//update forum statistics
			$fstat = ForumStats::find(1);
			$fstat->increment('count_conversations');

			//update user statistics
			$ustat = UserStats::where('user_id',$conversation->user_id)->first();
			$ustat->increment('posts_count');
			$ustat->increment('conversations_started_count');
		});
	}

	public function histories()
	{
		return $this->morphMany('Eubby\Models\History', 'historable');
	}

	protected function setSlugAttribute($slug)
	{
		//Lower case everything
	    $string = strtolower($slug);
	    //Make alphanumeric (removes all other characters)
	    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
	    //Clean up multiple dashes or whitespaces
	    $string = preg_replace("/[\s-]+/", " ", $string);
	    //Convert whitespaces and underscore to dash
	    $string = preg_replace("/[\s_]/", "-", $string);

	    $this->attributes['slug'] = $string;
	}

	public function channel()
	{
		return $this->belongsTo('Eubby\Models\Channel', 'channel_id');
	}

	public function posts()
	{
		return $this->hasMany('Eubby\Models\Post', 'conversation_id');
	}

	public function subscribers()
	{
		return $this->belongsToMany('Eubby\Models\User', 'conversations_subscribers')->withPivot('type');
	}

	public function lastPoster()
	{
		if($this->last_post_id < 1)
		{
			return User::find($this->user_id);
		}
		
		$post = Post::find($this->last_post_id);
		$user = User::find($post->user_id);

		return $user;
	}

	public function lastPost()
	{
		if($this->last_post_id < 1)
		{
			return Post::find($this->first_post_id);
		}
		
		return Post::find($this->last_post_id);
	}

	public function isPrivate()
	{
		return ($this->getPrivateSubscribers()->isEmpty()) ? false : true;
	}

	public function getPrivateSubscribers()
	{
		return $this->subscribers()->where('type','=','private')->get();
	}

	public function hasPrivateSubscriberId($id)
	{
		$ids = array();

		//make a list of all private subscribers to be searched from
		foreach ($this->getPrivateSubscribers() as $user)
		{
			$ids[] = $user->id;
		}

		//return false if id is 0
		if ($id == 0) return false;

		//return true if user is in the list
		if (in_array($id, $ids)) return true;

		//check if user is the owner of this conversation
		if ($this->user_id == $id) return true;

		return false;
	}

	public function getFollowers()
	{
		return $this->subscribers()->where('type','=','follow')->get();
	}

	public function hasFollowerId($id)
	{
		$ids = array();

		//make a list of all followers to be searched from
		foreach ($this->getFollowers() as $user)
		{
			$ids[] = $user->id;
		}

		//return false if id is 0
		if ($id == 0) return false;

		//return true if user is in the list
		if (in_array($id, $ids)) return true;

		//check if user is the owner of this conversation
		if ($this->user_id == $id) return true;

		return false;
	}

	public function unreadPostsCount($date)
	{
		if (is_null($date)) return $this->posts->count();

		$dateTime = date('Y-m-d H:i:s', strtotime($date));
		return $this->posts()->where('updated_at','>',$dateTime)->get()->count();
	}
}