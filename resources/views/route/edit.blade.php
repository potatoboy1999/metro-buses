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
                <h3 class="m-0"><i class="fa-solid fa-map-location-dot"></i> Update Route</h3>
            </div>
        </div>
    </div>
    <div class="mt-2">
        <form id="createRouteForm" action="{{ route('routes.store') }}" method="POST">
            @csrf
            <input type="hidden" name="route_id" value="{{ $route->id }}" />
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
                                                <option value="{{ $bus->id }}"
                                                    {{ $route->bus_id == $bus->id ? 'selected' : '' }}>{{ $bus->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="route_orientation" class="form-label">Orientation</label>
                                        <select class="form-select border-primary" id="route_orientation"
                                            name="route_orientation">
                                            <option value="0" {{ $route->orientation == 0 ? 'selected' : '' }}>North to
                                                South</option>
                                            <option value="1" {{ $route->orientation == 1 ? 'selected' : '' }}>South to
                                                North</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="route_start" class="form-label">Start Time</label>
                                        <select class="form-select border-primary" id="route_start" name="route_start">
                                            @for ($hour = 0; $hour < 24; $hour++)
                                                @for ($minute = 0; $minute < 60; $minute += 15)
                                                    @php
                                                        $val = sprintf('%02d:%02d', $hour, $minute);
                                                    @endphp
                                                    <option value="{{ $val }}"
                                                        {{ $route->start == $val . ':00' ? 'selected' : '' }}>
                                                        {{ $val }}
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
                                                    @php
                                                        $val = sprintf('%02d:%02d', $hour, $minute);
                                                    @endphp
                                                    <option value="{{ $val }}"
                                                        {{ $route->end == $val . ':00' ? 'selected' : '' }}>
                                                        {{ $val }}
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
                                            @php
                                                $checkedDays = explode(',', $route->avail_days);
                                            @endphp
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="0"
                                                    id="route_mon" name="route_days[]"
                                                    {{ in_array(0, $checkedDays) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="route_mon">Monday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="route_tue" name="route_days[]"
                                                    {{ in_array(1, $checkedDays) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="route_tue">Tuesday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="2"
                                                    id="route_wed" name="route_days[]"
                                                    {{ in_array(2, $checkedDays) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="route_wed">Wednesday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="3"
                                                    id="route_thr" name="route_days[]"
                                                    {{ in_array(3, $checkedDays) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="route_thr">Thursday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="4"
                                                    id="route_fri" name="route_days[]"
                                                    {{ in_array(4, $checkedDays) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="route_fri">Friday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="5"
                                                    id="route_sat" name="route_days[]"
                                                    {{ in_array(5, $checkedDays) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="route_sat">Saturday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="6"
                                                    id="route_sun" name="route_days[]"
                                                    {{ in_array(6, $checkedDays) ? 'checked' : '' }}>
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
                            @php
                                $selectedStations = $route->stations->pluck('id')->toArray();
                            @endphp
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
                                            <option id="stop-{{ $station->id }}" value="{{ $station->id }}"
                                                style="{{ in_array($station->id, $selectedStations) ? 'display:none' : '' }}">
                                                {{ $station->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="stops-list-container" class="bg-white rounded border border-1 border-primary mt-2">

                                @if ($route->stations->isEmpty())
                                    <p id="no-stops" class="p-3 m-0 text-secondary">No stops added yet</p>
                                @else
                                    @foreach ($route->stations as $index => $station)
                                        <div class="stop-item round m-2 px-2 py-2 rounded border border-light"
                                            position="{{ $index }}">
                                            <div class="d-flex flex-row">
                                                <div class="flex d-flex flex-row">
                                                    <div class="btn-stop-position btn btn-outline-primary btn-sm me-1"
                                                        data-swap="up">
                                                        <i class="fa-solid fa-arrow-up"></i>
                                                    </div>
                                                    <div class="btn-stop-position btn btn-outline-primary btn-sm me-1"
                                                        data-swap="down">
                                                        <i class="fa-solid fa-arrow-down"></i>
                                                    </div>
                                                    <div class="btn-stop-remove btn btn-outline-danger btn-sm me-1"
                                                        data-remove="{{ $index }}" data-id="{{ $station->id }}">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-auto align-content-center">
                                                    <p class="ms-2 my-0 d-inline">{{ $station->name }}</p>
                                                </div>
                                                <input type="hidden" name="route_stops[]"
                                                    value="{{ $station->id }}">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-light mt-2">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary">Update Route</button>
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
