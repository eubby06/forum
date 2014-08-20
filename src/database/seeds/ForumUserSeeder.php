<?php

use Eubby\Models\User;
use Eubby\Models\Profile;
use Eubby\Models\UserStats;

class ForumUserSeeder extends Seeder
{

	public function run()
	{

		DB::table('users')->delete();
		
		$user = new User;
		$user->email = 'eubby06@yahoo.com';
		$user->username = 'eubby';
		$user->password = 'admin';
		$user->active = 1;
		$user->ip_address = '127.0.0.1';
		$user->created_at = date('Y-m-d H:i:s');
		$user->updated_at = date('Y-m-d H:i:s');
		$user->deleted_at = null;
		$user->save();

		$user->groups()->attach(4);

		DB::table('profiles')->delete();

		$profile = new Profile;

		$profile->user_id = $user->id;
		$profile->location = 'Philippines';
		$profile->about = 'I am a web developer';
		$profile->save();

		DB::table('user_stats')->delete();

		$stat = new UserStats;

		$stat->user_id = $user->id;
		$stat->joined = $user->created_at;
		$stat->save();

	}
}
