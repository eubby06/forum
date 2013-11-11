<?php namespace Eubby\Controllers\Admin;

use View, Input, Redirect, Auth, DB;

class ChannelsController extends AdminController
{
	public function getIndex()
	{
		$channels = $this->getObject('channel')->withTrashed()->get();
		$this->layout->content = View::make("theme::{$this->theme}.backend.channels.index")
										->with('channels', $channels);
		return $this->layout;
	}

	public function getDelete($cid = null)
	{
		if (is_null($cid)) return Redirect::back();

		$channel = $this->getObject('channel')->find($cid);
		$channel->delete();

		return Redirect::back()->with('success', 'Channel has been removed.');
	}

	public function getRestore($cid = null)
	{
		if (is_null($cid)) return Redirect::back();

		$channel = $this->getObject('channel')->withTrashed('id','=',$cid)->first();
		$channel->restore();

		return Redirect::back()->with('success', 'Channel has been restored.');
	}

	public function getEdit($cid = null)
	{
		if (is_null($cid)) return Redirect::back();

		$channel = $this->getObject('channel')->find($cid);
		$permissions = $channel->permissions;

		$permissions_data = array();

		foreach ($permissions as $permission)
		{
			$permissions_data[strtolower($permission->name)]['can_view'] = $permission->pivot->can_view ? 1 : 0;
			$permissions_data[strtolower($permission->name)]['can_reply'] = $permission->pivot->can_reply ? 1 : 0;
			$permissions_data[strtolower($permission->name)]['can_start'] = $permission->pivot->can_start ? 1 : 0;
			$permissions_data[strtolower($permission->name)]['can_moderate'] = $permission->pivot->can_moderate ? 1 : 0;
		}

		$this->layout->content = View::make("theme::{$this->theme}.backend.channels.edit")
										->with('channel', $channel)
										->with('permissions', $permissions_data)
										->with('groups', $this->getObject('group')->defaults);

		return $this->layout;
	}

	public function postEdit($cid = null)
	{
		if (is_null($cid)) return Redirect::back();

		$channel = $this->getObject('channel')->find($cid);

		$channel_data = array(
			'name' 					=> Input::get('name'),
			'slug' 					=> Input::get('slug'),
			'description' 			=> Input::get('description'),
			'subscribe_new_user'  	=> (Input::get('subscription')) ? 1 : 0
			);

		$permissions = array();

		foreach (Input::get('permission') as $permission)
		{
			list($group, $action) = explode('_', $permission);

			$group_obj = $this->getObject('group')->where('name',ucfirst($group))->first();

			$permissions[$group_obj->id][] = $action;
		}

		//update channel model
		$channel->update($channel_data);

		//set up some array vars
		$permissions_data = array();
		$updated_groups = array();

		//this will only update group with at leat one value
		foreach ($permissions as $id => $actions)
		{
			//add group id to updated groups array var
			$updated_groups[] = $id;

			foreach ($actions as $action)
			{
				$permissions_data['can_'.$action] 	= 1;
			}

			$row = $channel->permissions()->where('group_id', $id)->first();

			$data = array( 
						'can_view' => (isset($permissions_data['can_view'])) ? 1 : 0,
						'can_reply' => (isset($permissions_data['can_reply'])) ? 1 : 0,
						'can_start' => (isset($permissions_data['can_start'])) ? 1 : 0,
						'can_moderate' => (isset($permissions_data['can_moderate'])) ? 1 : 0
						);

			(is_null($row)) ? $channel->permissions()->attach($id, $data) : $row->pivot->update($data);

			$permissions_data = array();
		}

		//get all groups to compare against the updated groups
		$groups_all = array();
		$group_ids = $this->getObject('group')->select('id')->get();

		//create an array of group ids
		foreach ($group_ids as $group)
		{
			$groups_all[] = $group->id;
		}

		//get the unupdated groups by returning the diff
		$un_updated_groups = array_diff($groups_all, $updated_groups);

		//loop through unupdated groups and update each
		foreach ($un_updated_groups as $group)
		{

			$channel->permissions()->where('group_id', $group)->update(array( 

			'can_view' => 0,
			'can_reply' => 0,
			'can_start' => 0,
			'can_moderate' => 0

			));
		}

		//its success
		return Redirect::route('admin_channels')->with('success', 'Channel has been updated.');

	}

	public function getCreate()
	{
		$this->layout->content = View::make("theme::{$this->theme}.backend.channels.create")
									->with('groups', $this->getObject('group')->defaults);
		return $this->layout;
	}

	public function postCreate()
	{
		$channel_data = array(
			'name' 					=> Input::get('name'),
			'slug' 					=> Input::get('slug'),
			'description' 			=> Input::get('description'),
			'subscribe_new_user'  	=> (Input::get('subscription')) ? 1 : 0
			);

		$permissions = array();

		foreach (Input::get('permission') as $permission)
		{
			list($group, $action) = explode('_', $permission);

			$group_obj = $this->getObject('group')->where('name','=',ucfirst($group))->first();

			$permissions[$group_obj->id][] = $action;
		}

		if ($this->getObject('channel')->isValid($channel_data))
		{
			$channel = $this->getObject('channel')->create($channel_data);
			$permissions_data = array();

			$added_groups = array();
			foreach ($permissions as $id => $actions)
			{
				//add group id to updated groups array var
				$added_groups[] = $id;

				$permissions_data['group_id'] 			= $id;
				$permissions_data['channel_id'] 		= $channel->id;

				foreach ($actions as $action)
				{
					$permissions_data['can_'.$action] 	= 1;
				}

				//create channel permissions
				DB::table('channel_permissions')->insert($permissions_data);
				//$loop++;
			}

			//get all groups to compare against the updated groups
			$groups_all = array();
			$group_ids = $this->getObject('group')->select('id')->get();

			//create an array of group ids
			foreach ($group_ids as $group)
			{
				$groups_all[] = $group->id;
			}

			//get the unupdated groups by returning the diff
			$un_added_groups = array_diff($groups_all, $added_groups);

			//loop through unupdated groups and update each
			foreach ($un_added_groups as $group)
			{
				$row = DB::table('channel_permissions')
						->insert(array(
								'group_id' => $group,
								'channel_id' => $channel->id,
								'can_view' => 0,
								'can_reply' => 0,
								'can_start' => 0,
								'can_moderate' => 0
								));	
			}

			return Redirect::route('admin_channels')->with('success', 'Channel has been created.');
		}

		return Redirect::back()->withErrors($this->getObject('channel')->validationErrors());
	}
}