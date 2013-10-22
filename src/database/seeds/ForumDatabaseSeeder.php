<?php

class ForumDatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call('GroupSeeder');
		$this->call('ForumStatsSeeder');
	}

}