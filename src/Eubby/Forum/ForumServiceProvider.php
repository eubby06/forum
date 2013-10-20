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
		include __DIR__.'/../../routes.php';

		$this->commands('forum.command');
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
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}