<?php

namespace App\Exports;

use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{
    use Exportable;
    /**
    * It's required to define the fileName within
    * the export class when making use of Responsable.
    */
    private $fileName = 'products.xlsx';

    /**
    * Optional Writer Type
    */
    private $writerType = Excel::XLSX;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
}
