<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Expense;

class ExpenseController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $expenses = Expense::latest()->get();

        return view(
            'expenses.index',
            compact('expenses')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'nama' =>
                'required',

            'nominal' =>
                'required|numeric',

            'tanggal' =>
                'required|date',

            'bukti' =>
                'nullable|image',

        ]);

        /*
        |--------------------------------------------------------------------------
        | DEFAULT PATH
        |--------------------------------------------------------------------------
        */

        $path = null;

        /*
        |--------------------------------------------------------------------------
        | UPLOAD BUKTI
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('bukti')) {

            $file =
                $request->file('bukti');

            $filename =
                time()
                . '_'
                . $file->getClientOriginalName();

            $file->move(

                public_path(
                    'uploads/expenses'
                ),

                $filename

            );

            $path =
                'uploads/expenses/'
                . $filename;
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        */

        Expense::create([

            'nama' =>
                $request->nama,

            'keterangan' =>
                $request->keterangan,

            'nominal' =>
                $request->nominal,

            'tanggal' =>
                $request->tanggal,

            'bukti' =>
                $path,

            'created_by' =>
                auth()->id(),

        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT + FLASH
        |--------------------------------------------------------------------------
        */

        return redirect('/expenses')->with([

            'success' =>
                'Pengeluaran berhasil ditambahkan'

        ]);
    }
}