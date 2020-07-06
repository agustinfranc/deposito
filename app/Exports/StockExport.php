<?php

namespace App\Exports;

use App\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'Codigo',
            'Detalle',
            'Rubro',
            'Cantidad',
        ];
    }

    public function collection()
    {
        return Stock::get(['code','detail','rubro','quantity']);
        //return Stock::all();
    }
}