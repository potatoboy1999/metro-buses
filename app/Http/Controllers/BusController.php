<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    //
    public function index()
    {
        $regulars = Bus::where('status', 1)
        ->where('express', 0)
        ->get();

        $express = Bus::where('status', 1)
        ->where('express', 1)
        ->get();

        return view('bus.index', [
            "page"=>"bus",
            "buses"=>[
                "regulars"=>$regulars,
                "express"=>$express
            ]
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'code_name' => 'required|string|max:10',
            'full_name' => 'required|string|max:150',
            'express' => 'required|string',
        ]);

        $newBus = new Bus();
        $newBus->code_name = trim(strtoupper($data['code_name']));
        $newBus->full_name = trim($data['full_name']);
        $newBus->express = ($data['express'] === 'express' ? 1 : 0);
        $newBus->status = 1;
        $newBus->save();

        return redirect()->route('buses')->with('success', 'Bus created successfully.');
    }
}
