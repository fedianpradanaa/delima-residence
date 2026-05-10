<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Imports\ImportPaymentImport;

use Maatwebsite\Excel\Facades\Excel;

class ImportPaymentController extends Controller
{
    public function index()
    {
        return view('import.index');
    }

    public function store(Request $request)
    {
        $request->validate([

            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(
            new ImportPaymentImport,
            $request->file('file')
        );

        return back()->with([
            'success' => 'Import berhasil'
        ]);
    }
}