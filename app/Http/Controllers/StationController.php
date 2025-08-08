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

    public function store()
    {
        $data = request()->validate([
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
}
