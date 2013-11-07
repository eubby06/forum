<?php namespace Eubby\Controllers\Admin;

use View, Input, Redirect, Auth;

class GroupsController extends AdminController
{
	public function getIndex()
	{	
		$groups = $this->provider->getGroup()->all();

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
				'parent_group_id' => $this->provider->getGroup()->where('name', ucfirst($this->provider->getGroup()->extendable_group))->first()->id
			);

		if ($this->provider->getGroup()->isValid($group_data))
		{
			$this->provider->getGroup()->create($group_data);

			return Redirect::route('admin_groups')->with('success', 'Group has been created.');
		}

		return Redirect::back()->withErrors($this->provider->getGroup()->validationErrors());
	}

	public function getEdit($gid = null)
	{
		if (is_null($gid)) return Redirect::back();

		$group = $this->provider->getGroup()->find($gid);

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

		$group = $this->provider->getGroup()->find($gid);
		$group_data = array(
							'name' => Input::get('name'),
							'moderator' => (Input::get('can_moderate')) ? 1 : 0
							);
		if ($group)
		{
			if ($group->name != Input::get('name'))
			{
				if (!$this->provider->getGroup()->isValid($group_data))
				{
					return Redirect::back()->withErrors($this->provider->getGroup()->validationErrors());
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

		$group = $this->provider->getGroup()->find($gid);

		if ($group)
		{
			$group->delete();

			return Redirect::route('admin_groups')->with('success', 'Group has been deleted');
		}

		return Redirect::route('admin_groups')->withErrors('Group could not be found.');
	}
}