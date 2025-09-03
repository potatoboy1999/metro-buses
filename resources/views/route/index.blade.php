@extends('template')

@section('title', 'Routes')

@section('content')

@php
    function formatTime($time) {
        return date('h:i A', strtotime($time));
    }
@endphp

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

    <div class="modal fade" id="allStopsModal" tabindex="-1" aria-labelledby="allStopsModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="allStopsModal">All Stops</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="loading text-center my-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="stops-list">
                        <div class="station-item d-flex gap-2 align-items-center border rounded p-2 mb-2">
                            <span class="badge bg-secondary">1</span>
                            <p class="m-0">Station Name</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteRouteModal" tabindex="-1" aria-labelledby="deleteRouteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteRouteModal">Delete Route</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="m-0">Are you sure you want to delete this route?</p>
                    <p class="m-0 text-danger"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Cancel</button>
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn" route="">Yes, Delete</button>
                </div>
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
                            <tr class="route-row route-{{$route->id}}">
                                <td class="align-content-center">
                                    <p class="m-0">{{$route->bus->full_name}}</p>
                                </td>
                                <td class="align-content-center">
                                    <p class="m-0">
                                        @if($route->orientation == 1)
                                            <i class="fa-solid fa-arrow-up arrow-sn"></i> South to North
                                        @else
                                            <i class="fa-solid fa-arrow-down arrow-ns"></i> North to South
                                        @endif
                                    </p>
                                </td>
                                <td class="align-content-center">
                                    <p class="m-0">{{formatTime($route->start)}}</p>
                                </td>
                                <td class="align-content-center">
                                    <p class="m-0">{{formatTime($route->end)}}</p>
                                </td>
                                <td class="align-content-center">
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach ($days as $k => $day)
                                            @php
                                                $style = "text-secondary";
                                                if (str_contains($route->avail_days, $k)) {
                                                    $style = "bg-success text-white";
                                                }
                                            @endphp
                                            <p class="m-0 d-inline p-2 fs-7 border {{ $style }} rounded">{{ $day }}</p>
                                        @endforeach

                                    </div>
                                </td>
                                <td class="align-content-center">
                                    <button class="btn-all-stops btn btn-outline-secondary" route="{{ $route->id }}" >
                                        See all stops
                                    </button>
                                </td>
                                <td class="align-content-center">
                                    <a href="{{ route("routes.edit", ["route_id"=>$route->id]) }}" class="btn btn-outline-primary">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <button class="btn btn-outline-danger btn-delete-route" route="{{ $route->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
    @csrf

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
    <script src="{{ asset('js/route_index.js') }}"></script>
@endsection
