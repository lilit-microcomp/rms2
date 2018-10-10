@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3>Clients list</h3>
        </div>
    </div>




    <table class="table table-dashboard">
        <tr>
            <th>No_</th>
            <th>Id</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Company Name</th>
            <th>Email</th>
        </tr>

        @foreach ($clients as $client)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $client->id }}</td>
                <th>{{ $client->firstname }}</th>
                <th>{{ $client->lastname }}</th>
                <th>{{ $client->companyname }}</th>
                <th>{{ $client->email }}</th>
            </tr>
        @endforeach
    </table>

    {!! $clients->links() !!}

@endsection
