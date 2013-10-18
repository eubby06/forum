<?php namespace Eubby\Models;

use Eubby\Models\Base;

class Post extends Base
{
	protected $table 			= 'posts';

	protected $guarded 			= array('id');

	protected $validation_rules = array(
	'user_id' 				=> 'required|numeric', 
	'conversation_id' 		=> 'required|numeric', 
	'message' 				=> 'required');

	public static function boot()
	{
		parent::boot();

		static::created(function($post)
		{
			$post->conversation->update(array('last_post_id' => $post->id));
			$post->conversation->increment('posts_count');
			$post->conversation->channel->increment('posts_count');
		});
	}

	public function conversation()
	{
		return $this->belongsTo('Eubby\Models\Conversation', 'conversation_id');
	}

	public function user()
	{
		return $this->belongsTo('Eubby\Models\User', 'user_id');
	}
}