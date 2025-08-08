@extends('template')

@section('title', 'Buses')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body bg-primary bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="m-0"><i class="fa-solid fa-map-location-dot"></i> New Route</h3>
            </div>
        </div>
    </div>
    <div class="mt-2">
        <form id="createRouteForm" action="{{ route('routes.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-light h-100">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="route_bus" class="form-label">Select a Bus</label>
                                        <select class="form-select border-primary" id="route_bus" name="route_bus">
                                            @foreach ($buses as $bus)
                                                <option value="{{ $bus->id }}">{{ $bus->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="route_orientation" class="form-label">Orientation</label>
                                        <select class="form-select border-primary" id="route_orientation"
                                            name="route_orientation">
                                            <option value="0">North to South</option>
                                            <option value="1">South to North</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="route_start" class="form-label">Start Time</label>
                                        <select class="form-select border-primary" id="route_start" name="route_start">
                                            @for ($hour = 0; $hour < 24; $hour++)
                                                @for ($minute = 0; $minute < 60; $minute += 15)
                                                    <option value="{{ sprintf('%02d:%02d', $hour, $minute) }}">
                                                        {{ sprintf('%02d:%02d', $hour, $minute) }}
                                                    </option>
                                                @endfor
                                            @endfor
                                        </select>

                                    </div>
                                    <div class="mb-3">
                                        <label for="route_end" class="form-label">End Time</label>
                                        <select class="form-select border-primary" id="route_end" name="route_end">
                                            @for ($hour = 0; $hour < 24; $hour++)
                                                @for ($minute = 0; $minute < 60; $minute += 15)
                                                    <option value="{{ sprintf('%02d:%02d', $hour, $minute) }}">
                                                        {{ sprintf('%02d:%02d', $hour, $minute) }}
                                                    </option>
                                                @endfor
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="route_orientation" class="form-label">Available Days</label>
                                        <div class="d-flex flex-column">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="0"
                                                    id="route_mon" name="route_days[]" checked>
                                                <label class="form-check-label" for="route_mon">Monday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="route_tue" name="route_days[]" checked>
                                                <label class="form-check-label" for="route_tue">Tuesday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="2"
                                                    id="route_wed" name="route_days[]" checked>
                                                <label class="form-check-label" for="route_wed">Wednesday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="3"
                                                    id="route_thr" name="route_days[]" checked>
                                                <label class="form-check-label" for="route_thr">Thursday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="4"
                                                    id="route_fri" name="route_days[]" checked>
                                                <label class="form-check-label" for="route_fri">Friday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="5"
                                                    id="route_sat" name="route_days[]" checked>
                                                <label class="form-check-label" for="route_sat">Saturday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="6"
                                                    id="route_sun" name="route_days[]" checked>
                                                <label class="form-check-label" for="route_sun">Sunday</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light h-100">
                        <div class="card-body">
                            <h3 class="">Route Stops</h3>
                            <div class="d-flex flex-row justify-content-between">
                                <div class="flex-auto">
                                    <button id="add-stop" class="btn btn-primary">Add <i
                                            class="fa-solid fa-plus"></i></button>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    {{-- <select class="form-select border-primary" id="route_stops" name="route_stops[]"> --}}
                                    <select class="form-select border-primary" id="route_stops">
                                        <option value="" selected disabled>Select a Stop</option>
                                        @foreach ($stations as $station)
                                            <option id="stop-{{ $station->id }}" value="{{ $station->id }}">{{ $station->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="stops-list-container" class="bg-white rounded border border-1 border-primary mt-2">
                                <p id="no-stops" class="p-3 m-0 text-secondary">No stops added yet</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-light mt-2">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary">Create Route</button>
                </div>
            </div>
        </form>
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
    <script src="{{ asset('js/route_create.js') }}"></script>
@endsection
