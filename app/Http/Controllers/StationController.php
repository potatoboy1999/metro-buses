<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    //
    public function index()
    {
        $stations = Station::where('status', 1)->get();
        return view('station.index',[
            "page"=>"station",
            "stations"=>$stations
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'station_id' => 'required|integer|exists:stations,id',
            'name' => 'required|string|max:150',
            'full_address' => 'required|string|max:200',
            'district' => 'required|string|max:150',
            'lat' => 'required|decimal:-999.999999999,999.999999999',
            'lng' => 'required|decimal:-999.999999999,999.999999999',
        ]);

        //validate station exists
        $station = Station::find($data['station_id']);
        if(!$station){
            return redirect()->back()->withErrors(['station_id' => 'The selected station does not exist.']);
        }

        // update station
        $station->name = trim($data['name']);
        $station->full_address = trim($data['full_address']);
        $station->district = trim($data['district']);
        $station->lat = $data['lat'];
        $station->lng = $data['lng'];
        $station->save();

        return redirect()->route('stations')->with('success', 'Station created successfully.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'full_address' => 'required|string|max:200',
            'district' => 'required|string|max:150',
            'lat' => 'required|decimal:-999.999999999,999.999999999',
            'lng' => 'required|decimal:-999.999999999,999.999999999',
        ]);

        $newStation = new Station();
        $newStation->name = trim($data['name']);
        $newStation->full_address = trim($data['full_address']);
        $newStation->district = trim($data['district']);
        $newStation->lat = $data['lat'];
        $newStation->lng = $data['lng'];
        $newStation->status = 1;
        $newStation->save();

        return redirect()->route('stations')->with('success', 'Station created successfully.');
    }

    public function deactivate(Request $request)
    {
        // validate request and send back errors if any
        $request->validate([
            'station_id' => 'required|integer|exists:stations,id',
        ]);

        // validate station exists
        $station = Station::find($request->station_id);
        if(!$station){
            return redirect()->back()->withErrors(['station_id' => 'The selected station does not exist.']);
        }

        // deactivate station
        $station->status = 0;
        $station->save();

        return redirect()->route('stations')->with('success', 'Station deactivated successfully.');
    }
}
