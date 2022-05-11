<?php

namespace App\Imports;

use App\Models\Catalogs\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class NotesImport implements ToCollection, WithProgressBar, WithChunkReading, WithBatchInserts, WithHeadingRow
{
    use Importable;
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if (!empty($row['nota']) || !is_null($row['nota'])) {
                $product = Product::where('sku', $row['sku'])->where('brand_id', 1)->first();
                if ($product) {
                    if (!is_null($product->notes)) {
                        if ($row['nota'] !== $product->notes) {
                            $product->notes = $product->notes . ' | ' . $row['nota'];
                        }
                    } else {
                        $product->notes = $row['nota'];
                    }
                    $product->save();
                }
            }
        }
    }

    /**
     * @return integer
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * @return integer
     */
    public function batchSize(): int
    {
        return 1000;
    }
}
