<?php namespace Pongo\Cms\Support\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Pongo\Cms\Models\User;
use Pongo\Cms\Models\UserDetail;

class SetupPongoCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'pongo:setup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setup PongoCMS after Composer installation';

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
		// Calling migration for pongocms package
		
		$this->call('migrate', array(
			'--package' => 'pongocms/cms'
		));

		// Change Auth model
		
		$this->call('pongo:change_auth_model');

		// Move themes folder
		
		$this->call('pongo:move_themes_folder');

		// Setup system roles

		$roles = \Config::get('cms::system.roles');

		foreach ($roles as $name => $level) {

			$role = array(
						'name' => $name,
						'level' => $level
					);

			\DB::table('roles')->insert($role);

		}

		// Setup admin user

		$admin_account = \Config::get('cms::settings.admin_account');

		$admin_settings = 	array(
								'role_id' 	=> 1,
								'lang' 		=> \Config::get('cms::settings.language'),
								'editor'	=> 0,
								'is_active' => 1
							);

		$admin_user = array_merge($admin_account, $admin_settings);		
		$admin_user['password'] = \Hash::make($admin_user['password']);
		
		$admin = User::create($admin_user);
		UserDetail::create(array('user_id' => $admin->id));

		$this->info('PongoCMS has been successfully set up!');

		return;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			// array('model', InputArgument::REQUIRED, 'Model to use'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
		// 	array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}