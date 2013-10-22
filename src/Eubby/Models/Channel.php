<?php namespace Eubby\Models;

use Eubby\Models\Base;
use Eubby\Models\ForumStats;

class Channel extends Base
{
	protected $table 			= 'channels';

	public $timestamps 			= false;

	protected $softDelete 		= true;

	protected $guarded 			= array('id');

	protected $validation_rules = array(
		'name' 			=> 'required|unique:channels', 
		'slug' 			=> 'required|unique:channels',
		'description' 	=> 'required');

	public static function boot()
	{
		parent::boot();

		static::created(function($channel)
		{
			//update forum statistics
			$fstat = ForumStats::find(1);
			$fstat->increment('count_channels');
		});
	}

	public function getKeyValuePair()
	{
		$all = $this->select('id','name')->get();
		$data = array();

		foreach($all as $one)
		{
			$data[$one->id] = $one->name;
		}

		return $data;
	}

	public function permissions()
	{
		return $this->belongsToMany('Eubby\Models\Group', 'channel_permissions')
					->withPivot('can_view','can_reply','can_start','can_moderate');
	}
}