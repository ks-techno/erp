<?php

namespace App\Exports;

use App\Models\Ledgers;
use Maatwebsite\Excel\Concerns\FromCollection;

class LedgerDataExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ledgers::all();
    }
}
