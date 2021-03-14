<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ShipReportsExport implements FromView
{
    public $reportData = [];
    
    
    public function __construct($reportData = []) {
        $this->reportData = $reportData;
    }

    /**
    * @return \Illuminate\Contracts\View\View
    */
    public function view(): View
    {
        return view('excels.ship-report', $this->reportData);
    }
}
