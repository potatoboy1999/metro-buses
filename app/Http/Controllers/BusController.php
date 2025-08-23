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

    public function update(Request $request)
    {
        $data = $request->validate([
            'bus_id' => 'required|integer|exists:buses,id',
            'code_name' => 'required|string|max:10',
            'full_name' => 'required|string|max:150',
            'express' => 'required|string',
        ]);

        // validate bus exists
        $bus = Bus::find($data['bus_id']);
        if(!$bus){
            return redirect()->back()->withErrors(['bus_id' => 'The selected bus does not exist.']);
        }

        // update bus
        $bus->code_name = trim(strtoupper($data['code_name']));
        $bus->full_name = trim($data['full_name']);
        $bus->express = ($data['express'] === 'express' ? 1 : 0);
        $bus->save();

        return redirect()->route('buses')->with('success', 'Bus created successfully.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
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

    public function deactivate(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|integer|exists:buses,id',
        ]);

        // validate bus exists
        $bus = Bus::find($request->bus_id);
        if(!$bus){
            return redirect()->back()->withErrors(['bus_id' => 'The selected bus does not exist.']);
        }

        // deactivate bus
        $bus->status = 0;
        $bus->save();

        return redirect()->route('buses')->with('success', 'Bus deactivated successfully.');
    }
}
