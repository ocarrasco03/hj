<?php

namespace App\Console\Commands;

use App\Imports\Catalogs\VehiclesImport;
use Illuminate\Console\Command;

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
        $this->output->title('Starting Import');
        try {
            (new VehiclesImport)->withOutput($this->output)->import(public_path('/excel/VehiclesLayout.xlsx'));
            $this->output->success('Import successful');
        } catch (\Throwable$th) {
            $this->output->error($th->getMessage());
        }
    }
}
