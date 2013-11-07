<?php namespace Eubby\Libs\Provider;

interface ProviderInterface
{
	public function __call($class, $arguments);

	public function resolveModel($class);
}