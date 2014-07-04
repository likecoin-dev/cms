<?php namespace Pongo\Cms\Support\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MoveThemesFolderCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'pongo:move_themes_folder';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Export the themes folder to project root';

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
		// In vendor as package
		if( ! WB() )
		{
			// Themes path
			$themes_to_copy = base_path('vendor/pongocms/site/src/themes');
			// Copy dir
			\File::copyDirectory($themes_to_copy, base_path('themes'));

			$this->info('Themes folder exported to root!');
		}
		else
		{
			$this->info('This command only run under vendor/package!');
		}

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