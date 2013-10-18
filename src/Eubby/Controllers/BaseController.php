<?php namespace Eubby\Controllers;

use Controller, Config, View;
use Eubby\Models\User;
use Eubby\Models\Channel;
use Eubby\Models\Conversation;
use Eubby\Models\Post;
use Eubby\Models\Session;

class BaseController extends Controller {

	protected $user 			= null;

	protected $channel 			= null;

	protected $conversation 	= null;

	protected $post 			= null;

	protected $session 			= null;

	protected $layout 			= null;

	public function __construct(
		User $user, 
		Channel $channel, 
		Conversation $conversation, 
		Post $post, 
		Session $session)
	{
		$this->user 		= ($user) ? $user : new User;
		$this->channel 		= ($channel) ? $channel : new Channel;
		$this->conversation = ($conversation) ? $conversation : new Conversation;
		$this->post 		= ($post) ? $post : new Post;
		$this->session 		= ($session) ? $session : new Session;
		$this->theme 		= Config::get('forum::theme.name');
		$this->layout 		= "theme::{$this->theme}.layouts.single_column";
	}

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
			$this->siteStatistics();
		}
	}

	public function siteStatistics()
	{
		$stats = array();

		$stats['online'] 			= $this->session->where('active','=',1)->get()->count();
		$stats['members']			= $this->user->all()->count();
		$stats['posts'] 			= $this->post->all()->count();
		$stats['conversations'] 	= $this->conversation->all()->count();	

		$this->layout->statistics = View::make("theme::{$this->theme}.__partials.statistics")
									->with('stats', $stats);
	}
}