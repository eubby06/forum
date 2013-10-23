<?php namespace Eubby\Models;

use Eubby\Models\Base;

class Group extends Base
{
	protected $table 			= 'groups';

	protected $guarded 			= array('id');

	protected $validation_rules = array('name' 	=> 'required|unique:groups');

	public $defaults 			= array(
									'guest' 		=> array(
															'can_view' 		=> true, 
															'can_reply' 	=> false, 
															'can_start' 	=> false, 
															'can_moderate' 	=> false),
									'member' 		=> array(
															'can_view' 		=> true, 
															'can_reply' 	=> true, 
															'can_start' 	=> true, 
															'can_moderate' 	=> false),
									'moderator' 	=> array(
															'can_view' 		=> true, 
															'can_reply' 	=> true, 
															'can_start' 	=> true, 
															'can_moderate' 	=> true),
									'administrator' => array(
															'can_view' 		=> true, 
															'can_reply' 	=> true, 
															'can_start' 	=> true, 
															'can_moderate' 	=> true),
									);

	public $extendable_group 	= 'member';

	public function isDefault()
	{
		return isset($this->defaults[strtolower($this->name)]);
	}

	public function users()
	{
		return $this->belongsTo('Eubby\Models\User', 'user_id');
	}

	public function permissions()
	{
		return $this->belongsToMany('Eubby\Models\Channel', 'channel_permissions')
					->withPivot('can_view','can_reply','can_start','can_moderate');
	}

	public function subGroups()
	{
		return $this->hasMany('Eubby\Models\Group', 'parent_group_id');
	}

	public function groupsForHtml()
	{
		$data = array();

		foreach($this->select('id','name','parent_group_id')->get() as $group)
		{
			$data[$group->id] = $group->name;
		}

		return $data;
	}
}