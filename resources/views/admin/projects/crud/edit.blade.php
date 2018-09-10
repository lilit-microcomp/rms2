@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Edit project!</div>

                <div class="card-body">
                    {!! Form::model($project[0], ['method' => 'PATCH', 'route' => ['projects.update', $project[0]->id], 'disabled' => true]) !!}
                        @include('admin.projects.crud.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
