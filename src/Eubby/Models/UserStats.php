<?php namespace Eubby\Models;

use Eubby\Models\Base;

class UserStats extends Base 
{

	protected $table 		= 'user_stats';

	public $timestamps 		= false;
	
	protected $guarded = array();

	public function user()
	{
		return $this->belongsTo('Eubby\Models\User', 'user_id');
	}
}
