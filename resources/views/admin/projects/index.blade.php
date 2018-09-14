@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3>Projects list</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="text-left">
                <a class="btn btn-xs btn-primary" href="{!! route('projects.index', 0) !!}">All</a>
                <a class="btn btn-xs btn-primary" href="{!! route('projects.index', 1) !!}">Open</a>
                <a class="btn btn-xs btn-primary" href="{!! route('projects.index', 2) !!}">Closed</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="text-right">
                <a class="btn btn-xs btn-success" href="{{ route('projects.create')}}">Create new project</a>
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
        <th>Client</th>
        <th>Due date</th>
        <th>Status</th>
        <th>Project description</th>
        <th>Manager</th>
        <th>Controls</th>
      </tr>

      @foreach ($projects as $project)
        <tr>
          <td>
              @if ($project->proj_projstatus == 1)
                  <span style="color: #CCCCCC">{{ $project->companyname }}</span><br>
              @else
                  {{ $project->companyname }}<br>
              @endif

              @if ($project->proj_projstatus == 1)
                  <span style="color: #CCCCCC">{{ $project->email }}</span><br>
              @else
                  {{ $project->email }}<br>
              @endif
              @if ($project->proj_projstatus == 1)
                  <span style="color: #CCCCCC">{{ $project->phonenumber }}</span><br>
              @else
                  {{ $project->phonenumber }}<br>
              @endif
          </td>
          <th>
              @if ($project->proj_projstatus == 1)
                  <span style="color: #CCCCCC">{{ $project->due_date }}</span>
              @else
                  {{ $project->due_date }}
              @endif
          </th>
          <th>
              @if ($project->proj_projstatus == 1)
                  @if ($project->status == 0)
                      <span style="color: #CCCCCC">Open</span>
                  @elseif ($project->status == 1)
                        <span style="color: #CCCCCC">Closed</span>
                  @endif
              @else
                  @if ($project->status == 0)
                        <span>Open</span>
                  @elseif ($project->status == 1)
                        <span>Closed</span>
                  @endif
              @endif
          </th>
          <th>
              @if ($project->proj_projstatus == 1)
                  <span style="color: #CCCCCC">{{ $project->descriptive_title }}</span><br>
              @else
                  {{ $project->descriptive_title }}<br>
              @endif
              @if ($project->proj_projstatus == 1)
                  <span style="color: #CCCCCC"><a href="//{{ $project->project_url }}" target="_blank">{{ $project->project_url }}</a></span>
              @else
                  <a href="//{{ $project->project_url }}" target="_blank">{{ $project->project_url }}</a>
              @endif
          </th>
          <th>
              @if ($project->proj_projstatus == 1)
                  <span style="color: #CCCCCC">{{ $project->firstname }}</span>
              @else
                  {{ $project->firstname }}
              @endif
          </th>
          <td>
              <a href="/projects/{{$project->proj_projid}}/finish-proj">
                  @if ($project->proj_projstatus == 0)
                      <i class="fa fa-times-circle" style="color: #007bff; margin-left: 20px;"></i>
                  @else
                      <i class="fa fa-check-circle" style="color: #007bff; margin-left: 20px;"></i>

                  @endif
              </a>

              <!--{!! Form::open(['method' => 'GET', 'route' => ['projects.edit', $project->project_id], 'style'=> 'display:inline']) !!}
              {!! Form::submit('Edit',['class'=> 'btn btn-xs btn-primary']) !!}
              {!! Form::close() !!}-->

              @if ($project->proj_projstatus == 0)
                  <a class="btn btn-xs btn-primary" href="{{ route('projects.edit', $project->project_id) }}"><i class="fa fa-edit"></i></a>
              @endif



            {!! Form::open(['method' => 'DELETE', 'route' => ['projects.destroy', $project->id], 'style'=> 'display:inline']) !!}
                <!--{!! Form::submit('Delete',['class'=> 'btn btn-xs btn-danger']) !!}-->
                <input type="submit" value="&#xf1f8" class="fa fa-trash" style="color: red; font-size: 18px; margin-bottom: 0;">
            {!! Form::close() !!}
          </td>
        </tr>
      @endforeach
    </table>

    {!! $projects->links() !!}


@endsection
