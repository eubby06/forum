<?php namespace Eubby\Controllers;

use Controller, 
	Config, 
	View;

use Eubby\Libs\Provider\ProviderInterface;

abstract class BaseController extends Controller {

	protected $layout 			= null;

	protected $theme 			= null;
	
	protected $provider 		= null;


	public function __construct(ProviderInterface $provider)
	{
		$this->provider 	= $provider;
		$this->theme 		= $this->provider->getSettings()->find(1)->theme;
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

		$stats['online'] 			= $this->provider->getSession()->where('active','=',1)->get()->count();
		$stats['members']			= $this->provider->getUser()->all()->count();
		$stats['posts'] 			= $this->provider->getPost()->all()->count();
		$stats['conversations'] 	= $this->provider->getConversation()->all()->count();	

		$this->layout->statistics = View::make("theme::{$this->theme}.__partials.statistics")
									->with('stats', $stats);
	}
}