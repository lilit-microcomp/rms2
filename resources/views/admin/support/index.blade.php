@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{!! URL::asset('js/admin/support/index.js') !!}"></script>

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3>Support list</h3>
        </div>
    </div>
    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4)
    <div class="row">
        <div class="col-lg-12">
            <div class="form-inline text-left">
                <div class="form-group col-md-6">
                    <label for="user_id" class="bold col-md-4 col-form-label text-md-right">Choose developer: </label>
                    <select onchange="location = this.value;">
                        <option></option>
                        @foreach($users as $user)
                            <option value="{!! route('support.index', $user->id) !!}"> {{$user->firstname}} </option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="text-right">
                <a class="btn btn-xs btn-success" href="{{ route('support.create')}}">Create new support</a>
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
        <th>No_</th>
        <th>Project</th>
        <th>due date</th>
        <!--<th>Support url</th>-->
        <th>Manager</th>
        <th>Team lead</th>
        <th>Developer(s)</th>
        <th>Controls</th>
      </tr>

      @foreach ($support as $supp)
        <tr>
          <td>
              @if ($supp->supp_suppstatus == 1)
                  <span style="color: #CCCCCC">{{ ++$i }}</span>
              @else
                  {{ ++$i }}
              @endif
          </td>
          <td>
              @if ($supp->supp_suppstatus == 1)
                  <span style="color: #CCCCCC">{!! $supp->description !!}</span>
              @else
                  {!! $supp->description !!}
              @endif
          </td>
          <th>
              @if ($supp->supp_suppstatus == 1)
                  <span style="color: #CCCCCC">{{ $supp->due_date }}</span>
              @else
                  {{ $supp->due_date }}
              @endif
          </th>
        <!--<th>project_url</th>-->
          <th>

              @foreach ($users as $key => $value)
                  @if ($value->id == $supp->pm_id)
                      @if ($supp->supp_suppstatus == 1)
                          <span style="color: #CCCCCC">{{ $value->firstname }}</span>
                      @else
                          {{ $value->firstname }}
                      @endif
                  @endif
              @endforeach
          </th>
          <th>
              @foreach ($users as $key => $value)
                  @if ($value->id == $supp->team_lead_id)
                      @if ($supp->supp_suppstatus == 1)
                          <span style="color: #CCCCCC">{{ $value->firstname }}</span>
                      @else
                          {{ $value->firstname }}
                      @endif
                  @endif
              @endforeach
          </th>
          <th>
              @foreach ($users as $key => $value)
                  @if ($value->id == $supp->developer_id)
                      @if ($supp->supp_suppstatus == 1)
                          <span style="color: #CCCCCC">{{ $value->firstname }}</span>
                      @else
                          {{ $value->firstname }}
                      @endif
                  @endif
              @endforeach
          </th>

          <td>
              <a href="/supports/{{$supp->support_supportid}}/finish-supp">
                  @if ($supp->supp_suppstatus == 0)
                      <i class="fa fa-times-circle" style="color: #007bff; margin-left: 20px;"></i>
                  @else
                      <i class="fa fa-check-circle" style="color: #007bff; margin-left: 20px;"></i>

                  @endif
              </a>

            <!-- <a class="btn btn-xs btn-info" href="{{ route('support.show', $supp->id) }}">Show</a> -->

                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4)
                  @if ($supp->supp_suppstatus == 0)
                    <a class="btn btn-xs btn-primary" href="{{ route('support.edit', $supp->support_id) }}"><i class="fa fa-edit"></i></a>
                  @endif
                @endif

                    <a class="btn btn-xs btn-primary" href="{{ route('support.show', $supp->support_id) }}"><i class="fa fa-eye"></i></a>

            @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4)
                {!! Form::open(['method' => 'DELETE', 'route' => ['support.destroy', $supp->support_id], 'style'=> 'display:inline']) !!}
                    <!--{!! Form::submit('Delete',['class'=> 'btn btn-xs btn-danger']) !!}-->
                  <input type="submit" value="&#xf1f8" class="fa fa-trash" style="color: red; font-size: 18px; margin-bottom: 0;">
                {!! Form::close() !!}
            @endif
          </td>
        </tr>
      @endforeach
    </table>

    {!! $support->links() !!}


@endsection
