@extends( 'layouts.appadmin' )

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Create new access data!</div>

                    <div class="card-body">
                        {!! Form::open(['route' => 'thirdparty.store', 'method' => 'POST', 'disabled' => false]) !!}
                        @include('admin.thirdparty.crud.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
