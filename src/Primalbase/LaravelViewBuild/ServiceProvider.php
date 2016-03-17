<?php namespace Primalbase\LaravelViewBuild;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	public function boot()
	{
		$this->package('primalbase/laravel-view-build');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('primalbase::command.view.make', function($app) {
			return new MakeView();
		});
		$this->app->bind('primalbase::command.layout.update', function($app) {
			return new UpdateLayout();
		});
		$this->commands(array(
			'primalbase::command.view.make',
			'primalbase::command.layout.update',

		));

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
