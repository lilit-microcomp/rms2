
    @extends( (Auth::user()->role_id == 1) ? 'dashboard.admin' : 'dashboard.admin')


{{$tasks}}
