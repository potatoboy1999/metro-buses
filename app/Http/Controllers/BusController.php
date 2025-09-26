<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    //
    public function index()
    {
        $regulars = Bus::where('express', 0)
        ->orderby('code_name','asc')
        ->get();

        $express = Bus::where('express', 1)
        ->orderby('code_name','asc')
        ->get();

        return view('bus.index', [
            "page"=>"bus",
            "buses"=>[
                "regulars"=>$regulars,
                "express"=>$express
            ]
        ]);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|integer|exists:buses,id',
        ]);

        // validate bus exists
        $bus = Bus::find($request->bus_id);
        if(!$bus){
            return response()->json(['error' => 'The selected bus does not exist.'], 404);
        }

        return response()->json(['bus' => $bus], 200);
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

        return redirect()->route('buses')->with('success', 'Bus updated successfully.');
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

        // delete bus
        $bus->delete();

        return redirect()->route('buses')->with('success', 'Bus deleted successfully.');
    }
}
