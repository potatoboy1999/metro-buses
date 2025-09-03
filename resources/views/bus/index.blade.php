@extends('template')

@section('title', 'Buses')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="modal fade" id="newBusModal" tabindex="-1" aria-labelledby="newBusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newBusModalLabel">New Bus</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newBusForm" action="{{ route('buses.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label for="busCodeName" class="form-label">Bus Code Name</label>
                            <input name="code_name" type="text" class="form-control" id="busCodeName" maxlength="10"
                                placeholder="Enter bus code name" required>
                        </div>
                        <div class="mb-3">
                            <label for="busFullName" class="form-label">Full Name</label>
                            <input name="full_name" type="text" class="form-control" id="busFullName" maxlength="150"
                                placeholder="Enter bus full name" required>
                        </div>
                        <div class="mb-3">
                            <label for="busType" class="form-label">Bus Type</label>
                            <select name="express" class="form-select" id="busType">
                                <option value="regular">Regular</option>
                                <option value="express">Express</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="newBusForm">Save Bus</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editBusModal" tabindex="-1" aria-labelledby="editBusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editBusModalLabel">Edit Bus: <span id="editBusName"></span></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="loading text-center my-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <form id="editBusForm" action="{{ route('buses.update') }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="bus_id" id="editBusId" value="">
                        <div class="mb-3">
                            <label for="editBusCodeName" class="form-label">Bus Code Name</label>
                            <input name="code_name" type="text" class="form-control" id="editBusCodeName" maxlength="10"
                                placeholder="Enter bus code name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editBusFullName" class="form-label">Full Name</label>
                            <input name="full_name" type="text" class="form-control" id="editBusFullName" maxlength="150"
                                placeholder="Enter bus full name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editBusType" class="form-label">Bus Type</label>
                            <select name="express" class="form-select" id="editBusType">
                                <option value="regular">Regular</option>
                                <option value="express">Express</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="editBusForm">Save Bus</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body bg-primary bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="m-0"><i class="fa-solid fa-bus"></i> Buses</h3>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newBusModal">
                    <i class="fa-solid fa-plus"></i> Add New Bus
                </button>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <h3 class="text-light">Regulars</h3>
        <div class="card bg-light mt-2">
            <div class="card-body">
                @if ($buses['regulars']->isEmpty())
                    <p class="m-0">No Regular Buses available.</p>
                @else
                    @foreach ($buses['regulars'] as $bus)
                        <div class="button-bus button-card m-1 card h-auto d-inline-block border-primary border-2" bus="{{ $bus->id }}">
                            <div class="card-body">
                                <i class="fa-solid fa-bus"></i> {{ $bus->code_name }}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="mt-4">
        <h3 class="text-light">Express</h3>
        <div class="card bg-light mt-2">
            <div class="card-body">
                @if ($buses['express']->isEmpty())
                    <p class="m-0">No Express Buses available.</p>
                @else
                    @foreach ($buses['express'] as $bus)
                        <div class="button-bus button-card m-1 card h-auto d-inline-block border-primary border-2" bus="{{ $bus->id }}">
                            <div class="card-body">
                                <i class="fa-solid fa-bus"></i> {{ $bus->code_name }}
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
    <script src="{{ asset('js/bus_index.js') }}"></script>
@endsection
