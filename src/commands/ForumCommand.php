<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Eubby\Models\User;
use Eubby\Models\Profile;
use Eubby\Models\UserStats;

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
		$username = '';
		$password = '';

		if ($this->confirm('This will create an admin user account. Do you wish to continue? [yes|no]'))
		{
			do {
				$username = $this->ask('Please type in a default admin username?');
			} while ($username == '');

			do {
				$password = $this->secret('Please type in a default admin password?');
			} while ($password == '');

			$this->info('Installing... Please wait...');

			$this->call('asset:publish',array('--bench'=>'eubby/forum'));
			$this->call('migrate', array('--bench'=>'eubby/forum'));
			$this->call('db:seed', array('--class'=>'ForumDatabaseSeeder'));

			$this->seedUser($username, $password);

			$this->info('Successfully Completed Installation!');
		}
		else
		{
			$this->error('Ooops! Installation could not proceed without creating an admin account.');
		}
		
	}

    public function seedUser($username, $password)
    {
    	DB::table('users')->delete();
		
		$user = new User;
		$user->email = 'eubby06@yahoo.com';
		$user->username = $username;
		$user->password = $password;
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