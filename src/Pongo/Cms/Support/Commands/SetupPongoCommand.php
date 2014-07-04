<?php namespace Pongo\Cms\Support\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

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