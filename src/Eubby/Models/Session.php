<?php namespace Eubby\Models;

use Eubby\Models\Base;

class Session extends Base
{
	protected $table 			= 'sessions';

	protected $primarKey 		= 'user_id';

	protected static $unguarded =  true;

	public function user()
	{
		return $this->belongsTo('Eubby\Models\User', 'user_id');
	}

	public function add($data = array())
	{
		if (isset($data['user_id']))
		{
			if ($session = $this->where('user_id', $data['user_id'])->first())
			{
				//since we dont have an id column, set user_id as primary key for timestamps update
				$session->primaryKey = 'user_id';
				$session->update($data);
			}
			else
			{
				$this->create($data);
			}
		}

		return;
	}

	public function deactivate($user_id = null)
	{
		if (is_null($user_id)) return false;

		$session = $this->where('user_id','=',$user_id)->first();

		if ($session)
		{
			//since we dont have an id column, set user_id as primary key for timestamps update
			$session->primaryKey = 'user_id';
			$session->active = 0;
			$session->update();
			return true;
		}
	}
}