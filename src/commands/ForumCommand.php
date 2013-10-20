<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ForumCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'forum:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'This will autorun migrations and seeders.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$this->call('asset:publish',array('--bench'=>'eubby/forum'));
		$this->call('migrate', array('--bench'=>'eubby/forum'));
		$this->call('db:seed', array('--class'=>'ForumDatabaseSeeder'));
		$this->info('Successfully Completed Installation of Forum');
	}

}