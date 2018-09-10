@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="pull-left">
                <h3>Superviser</h3>
                <a class="btn btn-xs btn-primary" href="{{ route('supervisers.index') }}">Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <strong>Name: </strong>
            {{ $superviser->name }}
        </div>
    </div>

@endsection
