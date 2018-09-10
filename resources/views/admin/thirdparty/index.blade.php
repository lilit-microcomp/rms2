@extends( Auth::user()->role_id == 1? 'layouts.appadmin' :  'layouts.app')


<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{!! URL::asset('js/admin/tasks/index.js') !!}"></script>

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3>Third party access data</h3>
        </div>
    </div>

    @if (Auth::user()->role_id == 1)
        <div class="row">
            <div class="col-lg-12">

                <div class="text-right">
                    <a class="btn btn-xs btn-success" href="{{ route('thirdparty.create')}}">Create new access data</a>
                </div>

            </div>
        </div>
    @endif

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-dashboard">
        <tr>
            <th>Website</th>
            <th>Username</th>
            <th>Password</th>
            <th>Description</th>
            @if (Auth::user()->role_id == 1)
                <th>Controls</th>
            @endif

        </tr>

    @foreach ($accesses as $access)
            <tr>

                <td>{{$access->website}}</td>
                <td>{{$access->username}}</td>
                <td>{{$access->password}}</td>
                <td>{{$access->description}}</td>


                @if (Auth::user()->role_id == 1)
                    <td>
                    {!! Form::open(['method' => 'GET', 'route' => ['thirdparty.edit', $access->id], 'style'=> 'display:inline']) !!}
                        {!! Form::submit('Edit',['class'=> 'btn btn-xs btn-primary']) !!}
                    {!! Form::close() !!}

                        <!--<a class="btn btn-xs btn-primary" href="">Show</a>-->
                        {!! Form::open(['method' => 'DELETE', 'route' => ['thirdparty.destroy', $access->id], 'style'=> 'display:inline']) !!}
                            {!! Form::submit('Delete',['class'=> 'btn btn-xs btn-danger']) !!}

                        {!! Form::close() !!}



                    </td>
                @endif
            </tr>
    @endforeach
    </table>



@endsection
