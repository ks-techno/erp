<?php

namespace App\Exports;

use App\Models\Ledgers;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class LedgerDataExport  implements FromView
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('accounts.ledgers.excel', [
            'data' => $this->data
        ]);
    }
   
}
