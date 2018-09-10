@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3>Users list</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
          <div class="text-right">
            <a class="btn btn-xs btn-success" href="{{ route('users.create')}}">Create new user</a>
          </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <p>{{ $message }}</p>
      </div>
    @endif

    <table class="table table-dashboard">
      <tr>
        <th>No_</th>
        <th>Id</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Role</th>
        <th width="300px"></th>
      </tr>

      @foreach ($users as $user)
        <tr>
          <td>{{ ++$i }}</td>
          <td>{{ $user->id }}</td>
          <th>{{ $user->firstname }}</th>
          <th>{{ $user->lastname }}</th>
          <th>{{ $user->email }}</th>
          <th>{{ $user->role_name }}</th>
          <td>
            <!-- <a class="btn btn-xs btn-info" href="{{ route('users.show', $user->id) }}">Show</a> -->
            <a class="btn btn-xs btn-primary" href="{{ route('users.edit', $user->id) }}">Edit</a>
            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style'=> 'display:inline']) !!}
                {!! Form::submit('Delete',['class'=> 'btn btn-xs btn-danger']) !!}
            {!! Form::close() !!}
          </td>
        </tr>
      @endforeach
    </table>

    {!! $users->links() !!}

@endsection
