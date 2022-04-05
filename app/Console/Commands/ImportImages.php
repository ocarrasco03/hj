<?php

namespace App\Console\Commands;

use App\Models\Catalogs\Product;
use Illuminate\Console\Command;

class ImportImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:images';

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
        ini_set('memory_limit', '2048M');
        $this->output->title('Starting Import');
        try {
            foreach (Product::all() as $product) {
                if (is_dir('/Users/oscar/Documents/HJ/Images/copy/rodatech/' . $product->sku)) {
                    if (file_exists('/Users/oscar/Documents/HJ/Images/copy/rodatech/' . $product->sku . '/0.jpg')) {
                        $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/rodatech/' . $product->sku . '/0.jpg')
                            ->toMediaCollection('products');
                    }
                    if (file_exists('/Users/oscar/Documents/HJ/Images/copy/rodatech/' . $product->sku . '/4.jpg')) {
                        $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/rodatech/' . $product->sku . '/4.jpg')
                            ->toMediaCollection('products');
                    }
                    if (file_exists('/Users/oscar/Documents/HJ/Images/copy/rodatech/' . $product->sku . '/11.jpg')) {
                        $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/rodatech/' . $product->sku . '/11.jpg')
                            ->toMediaCollection('products');
                    }
                    if (file_exists('/Users/oscar/Documents/HJ/Images/copy/rodatech/' . $product->sku . '/20.jpg')) {
                        $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/rodatech/' . $product->sku . '/20.jpg')
                            ->toMediaCollection('products');
                    }
                }
                // $mediaItems = $product->getMedia('products');
                // foreach ($mediaItems as $media) {
                //     $media->delete();
                // }
            }
            $this->output->success('Import successful');
        } catch (\Throwable$th) {
            $this->output->error($th->getMessage());
        }
    }
}
