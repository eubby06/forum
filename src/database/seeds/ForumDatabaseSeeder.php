<?php

class ForumDatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//$this->call('ChannelSeeder');
		$this->call('GroupSeeder');
	}

}