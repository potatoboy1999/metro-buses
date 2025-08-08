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
                        <div class="button-card card h-auto d-inline-block border-primary border-2">
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
                        <div class="button-card card h-auto d-inline-block border-primary border-2">
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
@endsection
