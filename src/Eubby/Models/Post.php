<?php namespace Eubby\Models;

use Eubby\Models\Base;
use Eubby\Models\ForumStats;
use Eubby\Models\UserStats;
use Eubby\Models\Post;
use Eubby\Models\History;

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
			//create history only for the second post or first post id is not zero or has been set
			if ($post->conversation->first_post_id != 0)
			{
				$history = new History();
				$history->user_id = $post->user_id;
				$history->message = 'replied to --title-start--'.$post->conversation->title.'--title-end--';
				$post->histories()->save($history);
			}

			//update conversation table
			$post->conversation->update(array('last_post_id' => $post->id));
			$post->conversation->increment('posts_count');
			$post->conversation->channel->increment('posts_count');

			//update forum statistics
			$fstat = ForumStats::find(1);
			$fstat->increment('count_posts');

			//update user statistics
			$ustat = UserStats::where('user_id',$post->user_id)->first();

			if (is_null($ustat))
			{
				$ustat = new UserStats();
				$ustat->user_id = $post->user_id;
				$ustat->posts_count = 1;
				$ustat->save();
			}
			else
			{
				$ustat->increment('posts_count');
			}
			
			//check if user has posted in this conversation
			$user_post = Post::where('user_id',$post->user_id)->where('conversation_id',$post->conversation_id)->get();

			//if no post, then add 1 to conversation participated count column
			if ($user_post->count() <= 1)
			{
				$ustat->increment('conversations_participated_count');
			}
		});
	}

	public function histories()
	{
		return $this->morphMany('Eubby\Models\History', 'historable');
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