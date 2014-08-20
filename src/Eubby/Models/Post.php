<?php namespace Eubby\Models;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Eubby\Models\Base;
use Eubby\Models\ForumStats;
use Eubby\Models\UserStats;
use Eubby\Models\Post;
use Eubby\Models\History;
use App, Acl;


class Post extends Base
{
	use SoftDeletingTrait;

	protected $table 			= 'posts';

	protected $dates = ['deleted_at'];

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
			//send notification
			$post->conversation->notify();

			//notify user that are mentioned in this post
			//this also notify users who opted to receive notification automatically
			$post->notify();

			//follow conversation if user has opted in
			$post->conversation->autoFollow();

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

		static::deleted(function($post)
		{
			if ($post->id == $post->conversation->last_post_id)
			{
				$post->conversation->active = 0;
				$post->conversation->save();
			}
		});
	}

	public function notify()
	{
		//get notifier obj
		$this->notifier = App::make('Notifier');

		//look up for users mentioned in this post
		preg_match_all('/@[a-zA-Z0-9_.-]+/', $this->message, $users);

		$users = array_shift($users);

		//make sure there are users at least one
		if (count($users) > 0)
		{

			//loop through each user
			foreach ($users as $user)
			{
				//remove the @ sign
				$user = str_replace('@','',$user);

				//check if user exists
				$user = $this->user->where('username','=',$user)->first();

				//if yes then try to notify
				if ($user)
				{
					$this->notifier->setMessage('has mentioned you in the her/his latest post.');
					$this->notifier->setType('3'); // notify when mentioned in the post
					$this->notifier->setUser($user);
					$this->notifier->setSender(Acl::getUser());
					$this->notifier->setNotifiableObj($this->conversation);
					$this->notifier->attemptNotify();
				}
				
			}
		}

		return true;
	}

	public function histories()
	{
		return $this->morphMany('Eubby\Models\History', 'historable');
	}

	public function notifications()
	{
		return $this->morphMany('Eubby\Models\Notification', 'notifiable');
	}
	
	public function conversation()
	{
		return $this->belongsTo('Eubby\Models\Conversation', 'conversation_id');
	}

	public function user()
	{
		return $this->belongsTo('Eubby\Models\User', 'user_id');
	}

	public function getProcessedMessage()
	{
		$message = $this->message;

		if (!empty($message));
		{
			//get quote post id
			preg_match("/\[quote=.*?\]/", $message, $quote);

			if (!empty($quote))
			{
				//get id and find the post by id
				$username = str_replace(array('[quote=',']'),'',$quote[0]);

				$message = str_replace(
								array($quote[0],'[/quote]'), 
								array('[blockquote][strong]' . $username . '[/strong] ','[/blockquote]'), 
								$message);
	
				return $message;
			}

			return $message;
		}

		return false;
	}

}
