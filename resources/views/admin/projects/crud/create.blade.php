@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Create new project!</div>

                <div class="card-body">
                    {!! Form::open(['route' => 'projects.store', 'method' => 'POST', 'disabled' => false]) !!}
                        @include('admin.projects.crud.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
