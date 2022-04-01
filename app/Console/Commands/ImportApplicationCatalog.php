<?php

namespace App\Console\Commands;

use App\Imports\Catalogs\ApplicationImport;
use Illuminate\Console\Command;

class ImportApplicationCatalog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:app-catalog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import from an excel to database an application products catalog';

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
            (new ApplicationImport)->withOutput($this->output)->import(public_path('/excel/ApplicationLayout.xlsx'));
            $this->output->success('Import successful');
        } catch (\Throwable$th) {
            $this->output->error($th->getMessage());
        }
    }
}
