<?php namespace Eubby\Controllers;

use Controller, Config, View;
use Eubby\Models\User;
use Eubby\Models\Channel;
use Eubby\Models\Conversation;
use Eubby\Models\Post;
use Eubby\Models\Session;
use Eubby\Models\Group;
use Eubby\Models\Ban;
use Eubby\Models\Settings;
use Eubby\Libs\Acl\Acl;
use Mail;

class BaseController extends Controller {

	protected $acl 				= null;

	protected $user 			= null;

	protected $channel 			= null;

	protected $conversation 	= null;

	protected $post 			= null;

	protected $session 			= null;

	protected $mailer			= null;

	protected $group 			= null;

	protected $settings 		= null;

	protected $ban 				= null;

	protected $layout 			= null;

	public function __construct(
		Acl $acl,
		User $user, 
		Channel $channel, 
		Conversation $conversation, 
		Post $post, 
		Session $session,
		Group $group,
		Ban $ban,
		Settings $settings)
	{
		$this->acl 			= ($acl) ? $acl : new Acl;
		$this->user 		= ($user) ? $user : new User;
		$this->channel 		= ($channel) ? $channel : new Channel;
		$this->conversation = ($conversation) ? $conversation : new Conversation;
		$this->post 		= ($post) ? $post : new Post;
		$this->session 		= ($session) ? $session : new Session;
		$this->group 		= ($group) ? $group : new Group;
		$this->ban 			= ($ban) ? $ban : new Ban;
		$this->settings 	= ($settings) ? $settings : new Settings;
		$this->mailer 		= Mail::getFacadeRoot();
		$this->theme 		= $this->settings->find(1)->theme;
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