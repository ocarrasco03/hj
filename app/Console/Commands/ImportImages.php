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
            $products = Product::all();
            $bar = $this->output->createProgressBar(count($products));
            $bar->start();
            foreach ($products as $product) {
                if (is_dir(public_path('/images/CONSECS/eagle'))) {
                    if (file_exists(public_path('/images/CONSECS/eagle/') . $product->sku . '.jpg')) {
                        $product->addMedia(public_path('/images/CONSECS/eagle/') . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                    if (file_exists(public_path('/images/CONSECS/eagle/') . strtoupper($product->sku) . '.JPG')) {
                        $product->addMedia(public_path('/images/CONSECS/eagle/') . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                }

                if (is_dir(public_path('/images/CONSECS/partech'))) {
                    if (file_exists(public_path('/images/CONSECS/partech/') . $product->sku . '.jpg')) {
                        $product->addMedia(public_path('/images/CONSECS/partech/') . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                    if (file_exists(public_path('/images/CONSECS/partech/') . strtoupper($product->sku) . '.JPG')) {
                        $product->addMedia(public_path('/images/CONSECS/partech/') . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                }

                if (is_dir(public_path('/images/CONSECS/rodatech'))) {
                    if (file_exists(public_path('/images/CONSECS/rodatech/') . $product->sku . '.jpg')) {
                        $product->addMedia(public_path('/images/CONSECS/rodatech/') . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                    if (file_exists(public_path('/images/CONSECS/rodatech/') . strtoupper($product->sku) . '.JPG')) {
                        $product->addMedia(public_path('/images/CONSECS/rodatech/') . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                }

                if (is_dir(public_path('/images/CONSECS/tg'))) {
                    if (file_exists(public_path('/images/CONSECS/tg/') . $product->sku . '.jpg')) {
                        $product->addMedia(public_path('/images/CONSECS/tg/') . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                    if (file_exists(public_path('/images/CONSECS/tg/') . strtoupper($product->sku) . '.JPG')) {
                        $product->addMedia(public_path('/images/CONSECS/tg/') . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                }

                if (is_dir(public_path('/images/CONSECS/trackone'))) {
                    if (file_exists(public_path('/images/CONSECS/trackone/') . $product->sku . '.jpg')) {
                        $product->addMedia(public_path('/images/CONSECS/trackone/') . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                    if (file_exists(public_path('/images/CONSECS/trackone/') . strtoupper($product->sku) . '.JPG')) {
                        $product->addMedia(public_path('/images/CONSECS/trackone/') . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                }

                $bar->advance();
            }
            $bar->finish();
            $this->output->success('Import successful');
        } catch (\Throwable$th) {
            $this->output->error($th->getMessage());
        }
    }
}
