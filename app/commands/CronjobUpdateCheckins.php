<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Barber\Cronjobs\Checkins\Checkin;
use Carbon\Carbon as Carbon;

class CronjobUpdateCheckins extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cronjob:updateCheckins';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Registra las entradas de los barberos que no checaron.';

    /**
     * @var Checkin
     */
    private $checkin;

    /**
     * Create a new command instance.
     * @param Checkin $checkin
     */
	public function __construct(Checkin $checkin)
	{
		parent::__construct();

        $this->checkin = $checkin;
    }

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->checkin->update();
        $date = Carbon::now();
        $this->info('Entradas de checador registradas correctamente : ' . $date->toDateTimeString());
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}
