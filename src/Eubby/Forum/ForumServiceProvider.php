<?php namespace Eubby\Forum;

use ForumCommand;
use Artisan;
use Illuminate\Support\ServiceProvider;

class ForumServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('eubby/forum');

		include __DIR__.'/../../start.php';
		include __DIR__.'/../../filters.php';
		include __DIR__.'/../../routes.php';

		$this->commands('forum.command');

		$this->loadAliases();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('forum.command', function()
		{
			return new ForumCommand();
		});

		//settings file
		$this->app->bind('config.path', function()
		{
			return $this->guessPackagePath() . '/config/';
		});

		//set acl
		$this->app->singleton('Acl', function()
		{
			return new \Eubby\Libs\Acl\Acl();
		});

		$this->app->singleton('Settings', function()
		{
			return \Eubby\Models\Settings::find(1);
		});

		$this->app->singleton('Notifier', function()
		{
			$notificationModel = new \Eubby\Models\Notification();

			return new \Eubby\Libs\Notification\Notifier($notificationModel);
		});
	}

	public function getAppConfig($file = 'app')
	{
		if(!isset($this->PkgAppConfig[$file]))
		{
			$path = $this->guessPackagePath();
			$ConfigFile = $path . '/config/'.$file.'.php';
			$this->PkgAppConfig[$file] = $this->app['files']->getRequire($ConfigFile);
		}
		
		return $this->PkgAppConfig[$file];
	}

	public function loadAliases()
	{
		$appConfig = $this->getAppConfig();
		
		$aliases = $appConfig['aliases'];

		foreach($aliases as $alias => $class)
		{
			class_alias($class, $alias);
		}
	}

	public function provides()
	{
		return array();
	}
}