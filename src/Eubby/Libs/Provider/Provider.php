<?php namespace Eubby\Libs\Provider;

use App;

class Provider implements ProviderInterface
{

	public function __call($class, $arguments)
	{
		$className = str_replace('get','',$class);

		return $this->resolveModel($className);
	}

	public function resolveModel($class)
	{
		$modelClass = '\\Eubby\Models\\' . $class;
		$libClass = '\\Eubby\Libs\\' . $class . '\\'. $class;

		//model class look up
		if (class_exists($modelClass))
		{
			return new $modelClass();
		}	
		//lib class look up
		else if (class_exists($libClass))
		{
			return new $libClass();
		}
		//container class look up
		else if (App::make($class))
		{
			return App::make($class)->getFacadeRoot();
		}
		else
		{
			return null;
		}
	}
}