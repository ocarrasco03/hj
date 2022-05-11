<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportNotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:notes';

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
        $this->output->title('Starting Import');
        try {
            (new \App\Imports\NotesImport)->withOutput($this->output)->import(public_path('/excel/NotesSYD.xlsx'));
            $this->output->success('Import successfull');
        } catch (\Throwable $th) {
            $this->output->error($th->getMessage());
        }
    }
}
