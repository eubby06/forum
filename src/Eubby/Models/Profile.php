<?php namespace Eubby\Models;

use Eubby\Models\Base;

class Profile extends Base
{
	protected $table 			= 'profiles';

	protected $guarded 			= array('id');

	public function user()
	{
		return $this->belongsTo('Eubby\Models\User', 'user_id');
	}
}