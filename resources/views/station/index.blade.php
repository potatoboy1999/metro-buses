@extends('template')

@section('title', 'Stations')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="modal fade" id="newStationModal" tabindex="-1" aria-labelledby="newStationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newStationModalLabel">New Station</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newStationForm" action="{{ route('stations.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label for="stationName" class="form-label">Station Name</label>
                            <input name="name" type="text" class="form-control" id="stationName" maxlength="150"
                                placeholder="Enter Station name" required>
                        </div>
                        <div class="mb-3">
                            <label for="stationAddress" class="form-label">Address</label>
                            <input name="full_address" type="text" class="form-control" id="stationAddress"
                                maxlength="200" placeholder="Enter Station address" required>
                        </div>
                        <div class="mb-3">
                            <label for="stationDistrict" class="form-label">District</label>
                            <input name="district" type="text" class="form-control" id="stationDistrict" maxlength="150"
                                placeholder="Enter Station district" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="stationLat" class="form-label">Latitude</label>
                                    <input name="lat" type="number" step=0.000000001 class="form-control" id="stationLat"
                                        maxlength="150" placeholder="Enter Station latitude" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="stationLng" class="form-label">Longitude</label>
                                    <input name="lng" type="number" step=0.000000001 class="form-control" id="stationLng"
                                        maxlength="150" placeholder="Enter Station longitude" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="newStationForm">Save Station</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editStationModal" tabindex="-1" aria-labelledby="editStationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editStationModalLabel">Edit Station</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editStationForm" action="{{ route('stations.update') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label for="editStationName" class="form-label">Station Name</label>
                            <input name="name" type="text" class="form-control" id="editStationName" maxlength="150"
                                placeholder="Enter Station name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStationAddress" class="form-label">Address</label>
                            <input name="full_address" type="text" class="form-control" id="editStationAddress"
                                maxlength="200" placeholder="Enter Station address" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStationDistrict" class="form-label">District</label>
                            <input name="district" type="text" class="form-control" id="editStationDistrict" maxlength="150"
                                placeholder="Enter Station district" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="editStationLat" class="form-label">Latitude</label>
                                    <input name="lat" type="number" step=0.000000001 class="form-control" id="editStationLat"
                                        maxlength="150" placeholder="Enter Station latitude" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="editStationLng" class="form-label">Longitude</label>
                                    <input name="lng" type="number" step=0.000000001 class="form-control" id="editStationLng"
                                        maxlength="150" placeholder="Enter Station longitude" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="editStationForm">Save Station</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body bg-primary bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="m-0"><i class="fa-solid fa-house-user"></i> Stations</h3>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newStationModal">
                    <i class="fa-solid fa-plus"></i> Add New Station
                </button>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="card bg-light mt-2">
            <div class="card-body">
                @if ($stations->isEmpty())
                    <p class="m-0">No stations available.</p>
                @else
                    @foreach ($stations as $station)
                        <div class="button-card m-1 card h-auto d-inline-block border-primary border-2">
                            <div class="card-body">
                                <p class="m-0 fw-bold fs-4">{{ $station->name }}</p>
                                <p class="m-0 fs-7">{{ $station->full_address }}</p>
                                <p class="m-0 fs-7">{{ $station->district }}</p>
                            </div>
                        </div>
                    @endforeach
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
