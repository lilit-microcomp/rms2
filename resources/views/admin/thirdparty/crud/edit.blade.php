@extends( 'layouts.appadmin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Edit project!</div>

                    <div class="card-body">
                        {!! Form::model($access_data[0], ['method' => 'PATCH', 'route' => ['thirdparty.update', $access_data[0]->id], 'disabled' => true]) !!}
                        @include('admin.thirdparty.crud.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
