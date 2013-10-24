<?php namespace Eubby\Models;

use Eubby\Models\Base;

class Ban extends Base
{
	protected $table 			= 'bans';

	protected $primaryKey 		= 'user_id';

	protected static $unguarded = true;

	public $timestamps 		= false;

	public function user()
	{
		return $this->belongsTo('Eubby\Models\User', 'user_id');
	}

	public function moderator()
	{
		return $this->belongsTo('Eubby\Models\User', 'moderator_id');
	}
}