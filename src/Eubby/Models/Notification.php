<?php namespace Eubby\Models;

use Eubby\Models\Base;

class Notification extends Base
{
	protected $table 	= 'notifications';

	public $timestamps 		= false;

	protected $guarded 	= array('id');

	public function notifiable()
	{
		return $this->morphTo();
	}

	public function user()
	{
		return $this->belongsTo('Eubby\Models\User', 'user_id');
	}
}