<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\Catalogs\ProductsImport;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import from an excel to database a products catalog';

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
            (new ProductsImport)->withOutput($this->output)->import(public_path('/excel/ProductsLayout.xlsx'));
            $this->output->success('Import successful');
        } catch (\Throwable$th) {
            $this->output->error($th->getMessage());
        }
    }
}
