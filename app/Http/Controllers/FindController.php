<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FindController extends Controller
{
    public function index(Request $request)
    {
        $result = null;
        $searched = false;

        if ($request->isMethod('post')) {
            $searched = true;
            // Mock data response based on inputs
            $result = [
                'name' => 'W. A. Samarathunga',
                'size' => '2 Acres 1 Rood 14 Perches',
                'current_stage' => 'Title Certificate Issued',
                'file_number' => 'LSO/K/104/22',
                'gazette_number' => 'No. 2234/12',
                'gazetted_date' => '2023-11-15'
            ];

            // if you want some random logic or check:
            if (empty($request->map_no) && empty($request->block_no) && empty($request->sheet_no) && empty($request->lot_no)) {
                $result = null; // simulate not found if everything is empty
            }
        }

        return view('find', compact('searched', 'result'));
    }
}
