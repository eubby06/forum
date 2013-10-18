<?php

use Eubby\Models\Channel;

class ChannelSeeder extends Seeder
{


	public function run()
	{

		DB::table('channels')->delete();
		
		$channel = new Channel;
		$channel->name = 'General Discussion';
		$channel->slug = 'general-discussion';
		$channel->save();

		$channel = new Channel;
		$channel->name = 'Correct The Teacher';
		$channel->slug = 'correct-the-teacher';
		$channel->save();

		$channel = new Channel;
		$channel->name = 'Site Improvements';
		$channel->slug = 'site-improvements';
		$channel->save();
		
		$channel = new Channel;
		$channel->name = 'Request';
		$channel->slug = 'users-requests';
		$channel->save();
	}
}