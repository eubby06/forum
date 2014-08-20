<?php

use Eubby\Models\Settings;

class ForumSettingsSeeder extends Seeder
{

	public function run()
	{

		DB::table('settings')->delete();
		
		$settings = new Settings;
		$settings->title = 'Your Company Name';
		$settings->theme = 'default';
		$settings->save();
	}
}
