@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Add New Notebook

                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary float-right btn-sm">
                            Go Back
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('notebook.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="">Notebook Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @endif" name="title"
                                    required placeholder="Enter the name of the Notebook">

                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button class="btn btn-primary float-right" type="submit">Submit Notebook</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
