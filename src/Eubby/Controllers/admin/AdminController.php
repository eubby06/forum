<?php namespace Eubby\Controllers\Admin;

use Controller, Config, View;
use Eubby\Models\User;
use Eubby\Models\Channel;
use Eubby\Models\Conversation;
use Eubby\Models\Post;
use Eubby\Models\Session;
use Eubby\Models\Group;
use Eubby\Libs\Acl\Acl;
use Eubby\Models\Settings;
use Eubby\Models\UserStats;
use Eubby\Models\ForumStats;

class AdminController extends Controller {

	protected $acl 				= null;

	protected $user 			= null;

	protected $channel 			= null;

	protected $conversation 	= null;

	protected $post 			= null;

	protected $session 			= null;

	protected $group 			= null;

	protected $settings 		= null;

	protected $user_stats 		= null;

	protected $forum_stats 		= null;

	protected $layout 			= null;

	public function __construct(
		Acl $acl,
		User $user, 
		Channel $channel, 
		Conversation $conversation, 
		Post $post, 
		Session $session,
		Group $group,
		Settings $settings,
		UserStats $user_stats,
		ForumStats $forum_stats)
	{
		$this->acl 			= ($acl) ? $acl : new Acl;
		$this->user 		= ($user) ? $user : new User;
		$this->channel 		= ($channel) ? $channel : new Channel;
		$this->conversation = ($conversation) ? $conversation : new Conversation;
		$this->post 		= ($post) ? $post : new Post;
		$this->session 		= ($session) ? $session : new Session;
		$this->group 		= ($group) ? $group : new Group;
		$this->settings 	= ($settings) ? $settings : new Settings;
		$this->user_stats 	= ($user_stats) ? $user_stats : new UserStats;
		$this->forum_stats 	= ($forum_stats) ? $forum_stats : new ForumStats;
		$this->theme 		= $this->settings->find(1)->theme;
		$this->layout 		= "theme::{$this->theme}.layouts.admin";
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