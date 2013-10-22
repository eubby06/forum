<?php

use Eubby\Models\ForumStats;

class ForumStatsSeeder extends Seeder
{

	public function run()
	{

		DB::table('forum_stats')->delete();
		
		$stat = new ForumStats;
		$stat->count_members = 0;
		$stat->count_posts = 0;
		$stat->count_conversations = 0;
		$stat->count_channels = 0;
		$stat->save();
	}
}