<?php

use Eubby\Models\Group;

class GroupSeeder extends Seeder
{


	public function run()
	{

		DB::table('groups')->delete();
		
		$group = new Group;
		$group->name = 'Guest';
		$group->parent_group_id = 0;
		$group->save();

		$group = new Group;
		$group->name = 'Member';
		$group->parent_group_id = 0;
		$group->save();

		$group = new Group;
		$group->name = 'Moderator';
		$group->parent_group_id = 0;
		$group->save();

		$group = new Group;
		$group->name = 'Administrator';
		$group->parent_group_id = 0;
		$group->save();
	}
}