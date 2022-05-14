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
                // if (is_dir('/Users/oscar/Documents/HJ/Images/copy/partech/' . $product->sku)) {
                //     if (file_exists('/Users/oscar/Documents/HJ/Images/copy/partech/' . $product->sku . '/0.jpg')) {
                //         $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/partech/' . $product->sku . '/0.jpg')
                //             ->withResponsiveImages()
                //             ->toMediaCollection('products');
                //     }
                //     if (file_exists('/Users/oscar/Documents/HJ/Images/copy/partech/' . $product->sku . '/4.jpg')) {
                //         $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/partech/' . $product->sku . '/4.jpg')
                //             ->withResponsiveImages()
                //             ->toMediaCollection('products');
                //     }
                //     if (file_exists('/Users/oscar/Documents/HJ/Images/copy/partech/' . $product->sku . '/11.jpg')) {
                //         $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/partech/' . $product->sku . '/11.jpg')
                //             ->withResponsiveImages()
                //             ->toMediaCollection('products');
                //     }
                //     if (file_exists('/Users/oscar/Documents/HJ/Images/copy/partech/' . $product->sku . '/20.jpg')) {
                //         $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/partech/' . $product->sku . '/20.jpg')
                //             ->withResponsiveImages()
                //             ->toMediaCollection('products');
                //     }
                //     if (file_exists('/Users/oscar/Documents/HJ/Images/copy/shark/' . $product->sku . '/' . $product->sku . '.jpg')) {
                //         $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/shark/' . $product->sku . '/' . $product->sku . '.jpg')
                //             ->withResponsiveImages()
                //             ->toMediaCollection('products');
                //     }
                //     for ($i = 0; $i < 9; $i++) {
                //         if (file_exists('/Users/oscar/Documents/HJ/Images/copy/shark/' . $product->sku . '/' . $product->sku . '('.$i.').jpg')) {
                //             $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/shark/' . $product->sku . '/' . $product->sku . '('.$i.').jpg')
                //                 ->withResponsiveImages()
                //                 ->toMediaCollection('products');
                //         }
                //     }
                // }

                // if (is_dir('/Users/oscar/Documents/HJ/Images/copy/LINEA_AZUL_IMG')) {
                //     if (file_exists('/Users/oscar/Documents/HJ/Images/copy/LINEA_AZUL_IMG/' . $product->sku . '.jpg')) {
                //         $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/LINEA_AZUL_IMG/' . $product->sku . '.jpg')
                //             ->withResponsiveImages()
                //             ->toMediaCollection('products');
                //     }
                // }

                // if (is_dir('/Users/oscar/Documents/HJ/Images/copy/LINEA_VERDE_IMG')) {
                //     if (file_exists('/Users/oscar/Documents/HJ/Images/copy/LINEA_AZUL_IMG/' . $product->sku . '.jpg')) {
                //         $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/LINEA_AZUL_IMG/' . $product->sku . '.jpg')
                //             ->withResponsiveImages()
                //             ->toMediaCollection('products');
                //     }
                // }

                // if (is_dir('/Users/oscar/Documents/HJ/Images/copy/CUBRE POLVOS/MA')) {
                //     if (file_exists('/Users/oscar/Documents/HJ/Images/copy/CUBRE POLVOS/MA/' . $product->sku . '.jpg')) {
                //         $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/CUBRE POLVOS/MA/' . $product->sku . '.jpg')
                //             ->withResponsiveImages()
                //             ->toMediaCollection('products');
                //     }
                // }

                // if (is_dir('/Users/oscar/Documents/HJ/Images/copy/DIRECCION Y SUSPENSION/MA')) {
                //     if (file_exists('/Users/oscar/Documents/HJ/Images/copy/DIRECCION Y SUSPENSION/MA/' . $product->sku . '.jpg')) {
                //         $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/DIRECCION Y SUSPENSION/MA/' . $product->sku . '.jpg')
                //             ->withResponsiveImages()
                //             ->toMediaCollection('products');
                //     }
                // }

                // if (is_dir('/Users/oscar/Documents/HJ/Images/copy/JUNTAS HOMOCINETICAS/MA_medidas')) {
                //     if (file_exists('/Users/oscar/Documents/HJ/Images/copy/JUNTAS HOMOCINETICAS/MA_medidas/' . $product->sku . '.jpg')) {
                //         $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/JUNTAS HOMOCINETICAS/MA_medidas/' . $product->sku . '.jpg')
                //             ->withResponsiveImages()
                //             ->toMediaCollection('products');
                //     }
                // }

                // if (is_dir('/Users/oscar/Documents/HJ/Images/copy/SOPORTES/MA')) {
                //     if (file_exists('/Users/oscar/Documents/HJ/Images/copy/SOPORTES/MA/' . $product->sku . '.jpg')) {
                //         $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/SOPORTES/MA/' . $product->sku . '.jpg')
                //             ->withResponsiveImages()
                //             ->toMediaCollection('products');
                //     }
                // }

                if (is_dir('/Users/oscar/Documents/HJ/Images/copy/CONSECS/eagle')) {
                    if (file_exists('/Users/oscar/Documents/HJ/Images/copy/CONSECS/eagle/' . $product->sku . '.jpg')) {
                        $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/CONSECS/eagle/' . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                    if (file_exists('/Users/oscar/Documents/HJ/Images/copy/CONSECS/eagle/' . strtoupper($product->sku) . '.JPG')) {
                        $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/CONSECS/eagle/' . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                }

                if (is_dir('/Users/oscar/Documents/HJ/Images/copy/CONSECS/partech')) {
                    if (file_exists('/Users/oscar/Documents/HJ/Images/copy/CONSECS/partech/' . $product->sku . '.jpg')) {
                        $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/CONSECS/partech/' . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                    if (file_exists('/Users/oscar/Documents/HJ/Images/copy/CONSECS/partech/' . strtoupper($product->sku) . '.JPG')) {
                        $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/CONSECS/partech/' . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                }

                if (is_dir('/Users/oscar/Documents/HJ/Images/copy/CONSECS/rodatech')) {
                    if (file_exists('/Users/oscar/Documents/HJ/Images/copy/CONSECS/rodatech/' . $product->sku . '.jpg')) {
                        $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/CONSECS/rodatech/' . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                    if (file_exists('/Users/oscar/Documents/HJ/Images/copy/CONSECS/rodatech/' . strtoupper($product->sku) . '.JPG')) {
                        $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/CONSECS/rodatech/' . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                }

                if (is_dir('/Users/oscar/Documents/HJ/Images/copy/CONSECS/tg')) {
                    if (file_exists('/Users/oscar/Documents/HJ/Images/copy/CONSECS/tg/' . $product->sku . '.jpg')) {
                        $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/CONSECS/tg/' . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                    if (file_exists('/Users/oscar/Documents/HJ/Images/copy/CONSECS/tg/' . strtoupper($product->sku) . '.JPG')) {
                        $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/CONSECS/tg/' . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                }

                if (is_dir('/Users/oscar/Documents/HJ/Images/copy/CONSECS/trackone')) {
                    if (file_exists('/Users/oscar/Documents/HJ/Images/copy/CONSECS/trackone/' . $product->sku . '.jpg')) {
                        $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/CONSECS/trackone/' . $product->sku . '.jpg')
                            ->withResponsiveImages()
                            ->toMediaCollection('products');
                    }
                    if (file_exists('/Users/oscar/Documents/HJ/Images/copy/CONSECS/trackone/' . strtoupper($product->sku) . '.JPG')) {
                        $product->addMedia('/Users/oscar/Documents/HJ/Images/copy/CONSECS/trackone/' . $product->sku . '.jpg')
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
