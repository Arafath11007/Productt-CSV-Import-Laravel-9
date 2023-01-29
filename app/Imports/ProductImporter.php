<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductImport;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ProductImporter implements OnEachRow, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        
        $group = Product::firstOrCreate([
            'name'  =>  $row['name'],
            'price'  =>  $row['price'],
            'sku'  =>  $row['sku'],
            'description'  =>  $row['description'],
        ]);
    }
}
