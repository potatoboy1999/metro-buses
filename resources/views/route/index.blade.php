@extends('template')

@section('title', 'Buses')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body bg-primary bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="m-0"><i class="fa-solid fa-map-location-dot"></i> Routes</h3>
                <a href="{{ route("routes.create") }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Add New Route
                </a>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="card bg-light mt-2">
            <div class="card-body">
                @if ($routes->isEmpty())
                    <p class="m-0">No Routes available.</p>
                @else
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <tr class="table-dark">
                                <th>Bus</th>
                                <th>Orientation</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Days</th>
                                <th style="max-width: 150px;width: 150px">Stops</th>
                                <th style="max-width: 120px;width: 120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($routes as $route)
                                <td class="align-content-center">
                                    <p class="m-0">{{$route->bus->full_name}}</p>
                                </td>
                                <td class="align-content-center">
                                    <p class="m-0">{{ $route->orientation == 1 ? 'South to North' : 'North to South' }}</p>
                                </td>
                                <td class="align-content-center">
                                    <p class="m-0">{{$route->start}}</p>
                                </td>
                                <td class="align-content-center">
                                    <p class="m-0">{{$route->end}}</p>
                                </td>
                                <td class="align-content-center">
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach ((explode(",", $route->avail_days)) as $day)
                                            <p class="m-0 d-inline p-2 fs-7 bg-light rounded">{{ $days[$day] }}</p>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="align-content-center">
                                    <button class="btn btn-outline-secondary">
                                        See all stops
                                    </button>
                                </td>
                                <td class="align-content-center">
                                    <a href="{{ route("routes.edit", ["route_id"=>$route->id]) }}" class="btn btn-outline-primary">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <button class="btn btn-outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endsection
