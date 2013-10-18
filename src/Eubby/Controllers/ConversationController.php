<?php namespace Eubby\Controllers;

use View, Input, Redirect, Auth;

class ConversationController extends BaseController
{
	public function getStart()
	{
		if (!Auth::check()) return Redirect::route('login');

		$channels = $this->channel->getKeyValuePair();

		$this->layout->content = View::make("theme::{$this->theme}.frontend.conversation.create")
									->with('channels', $channels);

		return $this->layout;
	}

	public function postStart()
	{
		if (!Auth::check()) return Redirect::route('login');

		$conversation_data = array(
			'user_id' 		=> Auth::user()->id,
			'title' 		=> Input::get('title'),
			'post' 			=> Input::get('post'),
			'channel_id'	=> Input::get('channel_id')
			);

		$post_data = array(
			'user_id' 			=> Auth::user()->id,
			'message' 			=> Input::get('post'),
			);

		//combine data for validation purposes
		$merged_data = array_merge($conversation_data, $post_data);

		//add extra rule to validate post data
		$rules = array('post' => 'required');

		//set extra validation rule
		$this->conversation->setValidationRules($rules);

		if ($this->conversation->isValid($merged_data))
		{
			//unset the temp post var that was used for validation only
			unset($conversation_data['post']);

			//this will auto create a slug based on title
			$conversation_data['slug'] = Input::get('title');

			//create the conversation model
			$conversation = $this->conversation->create($conversation_data);

			//create post model with conversation id
			$post_data['conversation_id'] = $conversation->id;
			$post = $this->post->create($post_data);

			//update conversation model to include first post id 
			$conversation->first_post_id = $post->id;
			$conversation->posts_count--;
			$conversation->update();

			//redirect to home
			return Redirect::route('home');
		}

		return Redirect::back()->withInput()->withErrors($this->conversation->validationErrors());
	}

	public function getList($channel_slug)
	{
		$channel = $this->channel->select('id')->where('slug','=',$channel_slug)->firstOrFail();

		$conversations = $this->conversation->where('channel_id','=',$channel->id)->get();

		$this->layout->content = View::make("theme::{$this->theme}.frontend.home.index")
									->with('conversations', $conversations);

		return $this->layout;
	}

	public function getView($slug = null)
	{
		if (is_null($slug)) return Redirect::back();

		$conversation = $this->conversation->where('slug','=',$slug)->orderBy('created_at')->firstOrFail();
		
		//check if conversation is private
		if ($conversation->isPrivate())
		{
			$user_id = (Auth::user()) ? Auth::user()->id : 0;

			//check if current user has subscribed to this
			if (!$conversation->hasPrivateSubscriberId($user_id))
			{
				return Redirect::route('home')->withErrors('Conversation is private.');
			}
		}

		//update read/unread posts
		if (Auth::check()) Auth::user()->logVisit($conversation);

		//increment views count
		$conversation->views_count 	= $conversation->views_count + 1;
		$conversation->timestamps 	= false;
		$conversation->update();

		//check if users permissions to this post
		$user_group_allowed_to_comment = Auth::user()->allowedToComment($conversation->channel->id);
		$user_group_allowed_to_view = Auth::user()->allowedToView($conversation->channel->id);
		
		if (!$user_group_allowed_to_view) return Redirect::route('home');

		$this->layout->content = View::make("theme::{$this->theme}.frontend.home.view")
									->with('conversation', $conversation)
									->with('user_allowed_to_comment', $user_group_allowed_to_comment);

		return $this->layout;
	}

	public function postReply()
	{
		if (!Auth::check()) return Redirect::route('login');

		$post_data = array(
			'user_id' 			=> Auth::user()->id,
			'conversation_id' 	=> Input::get('conversation_id'),
			'message' 			=> Input::get('message')
			);

		if ($this->post->isValid($post_data))
		{
			$post = $this->post->create($post_data);

			//this function has been moved to the model in boot method
			//$conversation 				= $this->conversation->find($post->conversation_id);
			//$conversation->posts_count 	= $conversation->posts_count + 1;
			//$conversation->last_post_id = $post->id;
			//$conversation->update();

			return Redirect::back()->with('success', 'Reply has been posted.');
		}

		return Redirect::back()->withErrors($this->post->validationErrors());
	}

	public function postAddSubscriber()
	{
		//get user based on posted var
		$user = $this->user->where('username','=',Input::get('subscriber'))->firstOrFail();

		//redirect if user is not found
		if (is_null($user)) return Redirect::back()->withErrors('User could not be found.');

		//check if use has already subscribed
		$subscription = $user->subscriptions()->where('conversation_id','=',Input::get('conversation_id'))->first();

		//redirect back if already subscribed
		if (!is_null($subscription)) return Redirect::back()->withErrors('User is already in the list.');

		//subscribe user to the conversation
		$user->subscriptions()->attach(Input::get('conversation_id'), array('type' => 'private'));

		//redirect with success
		return Redirect::back()->with('success', 'User has been added and subscribed.');
	}

	public function getFollow($slug = null)
	{
		if (!Auth::check()) return Redirect::route('login');
		
		//get logged in user
		$user = Auth::user(); 

		//get conversation based on slug
		$conversation = $this->conversation->where('slug','=',$slug)->orderBy('created_at')->firstOrFail();

		//check if use has already subscribed
		$subscription = $user->subscriptions()->where('conversation_id','=',$conversation->id)->first();

		//redirect back if already subscribed
		if (!is_null($subscription)) return Redirect::back();

		//subscribe user to the conversation
		$user->subscriptions()->attach($conversation, array('type' => 'follow'));

		//redirect with success
		return Redirect::back()->with('success', 'You are now following this conversation');
	}

	public function getUnfollow($slug = null)
	{
		//get logged in user
		$user = Auth::user();

		//get conversation based on slug
		$conversation = $this->conversation->where('slug','=',$slug)->orderBy('created_at')->firstOrFail();

		//check if use has already subscribed
		$subscription = $user->subscriptions()->where('conversation_id','=',$conversation->id)->first();

		//redirect back if already subscribed
		if (is_null($subscription)) return Redirect::back();

		//subscribe user to the conversation
		$user->subscriptions()->detach($conversation);

		//redirect with success
		return Redirect::back()->with('success', 'You have stopped following this conversation');
	}
}