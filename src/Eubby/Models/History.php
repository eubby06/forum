<?php namespace Eubby\Models;

use Eubby\Models\Base;

class History extends Base
{
	protected $table = 'histories';

	public function historable()
	{
		return $this->morphTo();
	}
}