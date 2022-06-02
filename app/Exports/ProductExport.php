<?php

namespace App\Exports;

use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithProperties;

class ProductExport implements FromCollection, WithProperties
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

    public function properties(): array
    {
        return [
            'creator' => 'HJ Acco Autopartes S.A. de C.V.',
            'lastModifiedBy' => 'HJ Acco Autopartes S.A. de C.V.',
            'title' => 'Exportación de Productos',
            'description' => 'Exportación de todos los productos',
            'category' => 'Productos',
            'company' => 'HJ Autopartes',
        ];
    }
}
