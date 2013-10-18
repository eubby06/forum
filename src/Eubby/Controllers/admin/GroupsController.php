<?php namespace Eubby\Controllers\Admin;

use View, Input, Redirect, Auth;

class GroupsController extends AdminController
{
	public function getIndex()
	{	
		$groups = $this->group->all();

		$this->layout->content = View::make("theme::{$this->theme}.backend.groups.index")
									->with('groups', $groups);
		return $this->layout;
	}

	public function getCreate()
	{
		$this->layout->content = View::make("theme::{$this->theme}.backend.groups.create");
		return $this->layout;
	}

	public function postCreate()
	{
		$group_data = array(
				'name' => Input::get('name'),
				'moderator' => (Input::get('can_moderate')) ? 1 : 0,
				'parent_group_id' => $this->group->where('name', ucfirst($this->group->extendable_group))->first()->id
			);

		if ($this->group->isValid($group_data))
		{
			$this->group->create($group_data);

			return Redirect::route('admin_groups')->with('success', 'Group has been created.');
		}

		return Redirect::back()->withErrors($this->group->validationErrors());
	}

	public function getEdit($gid = null)
	{
		if (is_null($gid)) return Redirect::back();

		$group = $this->group->find($gid);

		if ($group)
		{
			$this->layout->content = View::make("theme::{$this->theme}.backend.groups.edit")
									->with('group', $group);
			return $this->layout;
		}

		return Redirect::route('admin_groups')->withErrors('Group could not be found.');
	}

	public function postEdit($gid = null)
	{
		if (is_null($gid)) return Redirect::back();

		$group = $this->group->find($gid);
		$group_data = array(
							'name' => Input::get('name'),
							'moderator' => (Input::get('can_moderate')) ? 1 : 0
							);
		if ($group)
		{
			if ($group->name != Input::get('name'))
			{
				if (!$this->group->isValid($group_data))
				{
					return Redirect::back()->withErrors($this->group->validationErrors());
				}
			}

			$group->update($group_data);

			return Redirect::route('admin_groups')->with('success', 'Group has been updated.');
		}

		return Redirect::back()->withErrors('Group could not be found.');
	}

	public function getDelete($gid = null)
	{
		if (is_null($gid)) return Redirect::back();

		$group = $this->group->find($gid);

		if ($group)
		{
			$group->delete();

			return Redirect::route('admin_groups')->with('success', 'Group has been deleted');
		}

		return Redirect::route('admin_groups')->withErrors('Group could not be found.');
	}
}