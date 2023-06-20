<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LmsController extends Controller
{

    private static function Constants()
    {
        $name = 'Lead Management System';
        return [
            'title' => 'Lead Management System',
        ];
    }
    public function index(Request $request)
    {
        $data['title'] = self::Constants()['title'];

        return view('marketing.lms.list', compact('data'));
    }

    public function create(Request $request)
    {
        $data['title'] = self::Constants()['title'];

        return view('marketing.lms.create', compact('data'));
    }

}
