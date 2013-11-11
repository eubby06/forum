<?php namespace Eubby\Controllers\Admin;

use Controller, Config, View;
use Eubby\Libs\Provider\ProviderInterface;

class AdminController extends Controller {

	protected $provider 		= null;

	protected $theme 			= null;

	protected $layout 			= null;

	protected $objects 			= array();


	public function __construct(ProviderInterface $provider)
	{
		$this->provider 	= $provider;
		$this->theme 		= $this->provider->getSettings()->find(1)->theme;
		$this->layout 		= "theme::{$this->theme}.layouts.admin";
	}

	public function setObject($object)
	{
		$getObject = 'get' . ucfirst($object);

		$this->objects[$object] = $this->provider->$getObject();
	}

	public function getObject($object)
	{
		if (isset($this->objects[$object]))
		{
			$object = $this->objects[$object];
		}
		else
		{
			$getObject = 'get' . ucfirst($object);

			$object = $this->provider->$getObject();
		}
		
		return $object;
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

		$stats['online'] 			= $this->getObject('session')->where('active','=',1)->get()->count();
		$stats['members']			= $this->getObject('user')->all()->count();
		$stats['posts'] 			= $this->getObject('post')->all()->count();
		$stats['conversations'] 	= $this->getObject('conversation')->all()->count();	

		$this->layout->statistics = View::make("theme::{$this->theme}.__partials.statistics")
									->with('stats', $stats);
	}
}