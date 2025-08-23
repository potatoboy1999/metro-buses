<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Route;
use App\Models\RouteStop;
use App\Models\Station;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    //
    public function index()
    {
        // Logic to retrieve and display routes
        $routes = Route::where('status', 1)->get();
        // $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return view('route.index',[
            "page" => "route",
            "routes" => $routes,
            "days" => $days
        ]);
    }

    public function create()
    {
        // Logic to retrieve and display routes
        $stations = Station::where('status', 1)->get();
        $buses = Bus::where('status', 1)->get();
        return view('route.create',[
            "page" => "route",
            "stations" => $stations,
            "buses" => $buses,
        ]);
    }

    public function edit(Request $request)
    {
        $route = Route::find($request->route_id);
        if(!$route){
            return redirect()->route('routes');
        }
        // Logic to retrieve and display routes
        $stations = Station::where('status', 1)->get();
        $buses = Bus::where('status', 1)->get();
        return view('route.edit',[
            "page" => "route",
            "route" => $route,
            "stations" => $stations,
            "buses" => $buses,
        ]);
    }

    public function update(Request $request){
        // Logic to store a new route
        $request->validate([
            'route_id' => 'required|integer|exists:routes,id',
            'route_bus' => 'required|string',
            'route_orientation' => 'required|integer',
            'route_start' => 'required|string|max:8',
            'route_end' => 'required|string|max:8',
            'route_days' => 'required|array',
            'route_stops' => 'required|array',
        ]);

        // validate bus exists
        $bus = Bus::find($request->route_bus);
        if (!$bus) {
            return redirect()->back()->withErrors(['route_bus' => 'The selected bus does not exist.']);
        }

        // validate at least one stop is selected
        if (!isset($request->route_stops) || empty($request->route_stops)) {
            return redirect()->back()->withErrors(['route_stops' => 'At least one stop is required.']);
        }

        // join days into a string
        $days = implode(',', $request->route_days);

        // find route
        $route = Route::find($request->route_id);
        if(!$route){
            return redirect()->back()->withErrors(['route_id' => 'The selected route does not exist.']);
        }

        // update route
        $route->bus_id = $request->route_bus;
        $route->orientation = $request->route_orientation;
        $route->avail_days = $days;
        $route->start = ($request->route_start).":00";
        $route->end = ($request->route_end).":00";
        $route->save();

        if(!$route->id){
            return redirect()->back()->withErrors(['route' => 'Failed to update route.']);
        }

        // delete current stops
        RouteStop::where('route_id', $route->id)->delete();

        // create stops
        // loop stops
        $order = 1;
        foreach ($request->route_stops as $route_stop){
            $stop = new RouteStop();
            $stop->route_id = $route->id;
            $stop->station_id = $route_stop;
            $stop->order = $order;
            $stop->status = 1;
            $stop->save();
            $order++;
        }
        return redirect()->route('routes')->with('success', 'Route created successfully.');
    }

    public function store(Request $request)
    {
        // Logic to store a new route
        $request->validate([
            'route_bus' => 'required|string',
            'route_orientation' => 'required|integer',
            'route_start' => 'required|string|max:8',
            'route_end' => 'required|string|max:8',
            'route_days' => 'required|array',
            'route_stops' => 'required|array',
        ]);

        // validate bus exists
        $bus = Bus::find($request->route_bus);
        if (!$bus) {
            return redirect()->back()->withErrors(['route_bus' => 'The selected bus does not exist.']);
        }

        // validate at least one stop is selected
        if (!isset($request->route_stops) || empty($request->route_stops)) {
            return redirect()->back()->withErrors(['route_stops' => 'At least one stop is required.']);
        }

        // join days into a string
        $days = implode(',', $request->route_days);

        // create new route
        $route = new Route();
        $route->bus_id = $request->route_bus;
        $route->orientation = $request->route_orientation;
        $route->avail_days = $days;
        $route->start = ($request->route_start).":00";
        $route->end = ($request->route_end).":00";
        $route->status = 1;
        $route->save();

        if (!$route->id) {
            return redirect()->back()->withErrors(['route' => 'Failed to create new route.']);
        }

        // create stops
        // loop route stops
        $order = 1;
        foreach ($request->route_stops as $route_stop){
            $stop = new RouteStop();
            $stop->route_id = $route->id;
            $stop->station_id = $route_stop;
            $stop->order = $order;
            $stop->status = 1;
            $stop->save();
            $order++;
        }
        return redirect()->route('routes')->with('success', 'Route created successfully.');
    }

    public function deactivate(Request $request)
    {
        $request->validate([
            'route_id' => 'required|integer|exists:routes,id',
        ]);

        // validate route exists
        $route = Route::find($request->bus_id);
        if(!$route){
            return redirect()->back()->withErrors(['route_id' => 'The selected route does not exist.']);
        }

        // deactivate route
        $route->status = 0;
        $route->save();

        return redirect()->route('routes')->with('success', 'Route deactivated successfully.');
    }
}
