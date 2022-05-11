<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportZipCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:zip-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import from an excel to database a zip codes catalog';

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
            (new \App\Imports\ZipCodesImport)->withOutput($this->output)->import(public_path('/excel/ZipCodeLayout.xlsx'));
            $this->output->success('Import successful');
        } catch (\Throwable$th) {
            $this->output->error($th->getMessage());
            throw $th;
        }
    }
}
