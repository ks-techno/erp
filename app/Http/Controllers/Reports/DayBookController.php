<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DayBookController extends Controller
{

    private static function Constants()
    {
        $name = 'daybook';
        return [
            'title' => 'Day book',
        ];
    }
    public function index(Request $request)
    {
        $data['title'] = self::Constants()['title'];

        return view('reports.daybook', compact('data'));
    }
}
