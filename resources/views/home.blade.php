@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 mb-4 d-flex align-items-center justify-content-between">
                <h4 class="m-0 text-muted font-weight-bold">
                    {{ auth()->user()->notebook_name }}
                </h4>

                <a href="{{  route('notebook.create') }}" class="btn btn-outline-primary">
                    <i class="ti-pencil-alt"></i> Create New Notebook
                </a>
            </div>
        </div>
    </div>

    <notebooks></notebooks>
@endsection
