<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\NotifyUserOfCompletedImport;
use App\Imports\Catalogs\ApplicationImport;

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
        ini_set('max_execution_time',0);
        $this->output->title('Starting Import');
        try {
            (new \App\Imports\Catalogs\ApplicationImport)->queue(public_path('/excel/ApplicationLayout.xlsx'))->chain([
                new NotifyUserOfCompletedImport(\App\Models\User::find(1), 'aplicacion'),
            ]);
            $this->output->success('Import successful');
        } catch (\Throwable$th) {
            $this->output->error($th->getMessage());
        }
    }
}
