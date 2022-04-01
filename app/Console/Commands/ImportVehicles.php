<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\Catalogs\VehiclesImport;
use App\Jobs\NotifyUserOfCompletedImport;

class ImportVehicles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:vehicles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import from an excel to database a vehicles catalog';

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
     * @return int
     */
    public function handle()
    {
        ini_set('max_execution_time',0);
        $this->output->title('Starting Import');
        try {
            (new \App\Imports\Catalogs\VehiclesImport)->queue(public_path('/excel/VehiclesLayout.xlsx'))->chain([
                new NotifyUserOfCompletedImport(\App\Models\User::find(1), 'vehiculos'),
            ]);
            $this->output->success('Import successful');
        } catch (\Throwable$th) {
            $this->output->error($th->getMessage());
        }
    }
}
