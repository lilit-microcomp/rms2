
@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')

@section('content')
    welcome

@stop
