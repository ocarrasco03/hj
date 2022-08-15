<?php

namespace App\Console\Commands;

use App\Imports\UsersImport;
use Illuminate\Console\Command;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
            // (new \App\Imports\Catalogs\ProductsImport)->queue(public_path('/excel/ProductsLayout.xlsx'))->chain([
            //     new NotifyUserOfCompletedImport(\App\Models\User::find(1), 'productos'),
            // ]);
            (new UsersImport)->withOutput($this->output)->import(public_path('/excel/UsersLayout.xls'));
            $this->output->success('Import successful');
        } catch (\Throwable$th) {
            $this->output->error($th->getMessage());
            throw $th;
        }
    }
}
