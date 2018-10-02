@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{!! URL::asset('js/admin/tasks/index.js') !!}"></script>

@section('content')
barev
    <div class="row">
        <div class="col-lg-12">
            <h3>Tasks list</h3>
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
                                <option value="{!! route('tasks.index', $user->id) !!}"> {{$user->firstname}} </option>
                            @endforeach
                        </select>

                </div>
            </div>

            <div class="text-right">
                <a class="btn btn-xs btn-success" href="{{ route('tasks.create')}}">Create new task</a>
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
            @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                <th>Company name</th>
            @endif
            <th>Project</th>
            <th>Due date</th>
            <th>Manager</th>
            <th>Team lead</th>
            <th>Developer(s)</th>
            <th>Controls</th>
        </tr>

            @foreach ($tasks as $task)
                <tr>
                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                        <td>
                            @if ($task->task_taskstatus == 1)
                                <span style="color: #CCCCCC">{{ $task->companyname }}</span>
                            @else
                                {{ $task->companyname }}
                            @endif
                        </td>
                    @endif
                    <td>
                        @if ($task->task_taskstatus == 1)
                            <a href="{{ route('tasks.edit', $task->task_taskid) }}">
                                <span style="color: #CCCCCC">{!! $task->proj_desc_title !!}</span>
                            </a>
                            <span style="color: #CCCCCC"><a href="//{{$task->proj_url}}" target="_blank"> {!! $task->proj_url !!}</a></span>
                        @else
                            <a href="{{ route('tasks.edit', $task->task_taskid) }}">
                                {!! $task->proj_desc_title !!}<br>
                            </a>
                            <a href="//{{$task->proj_url}}" target="_blank">{!! $task->proj_url !!}</a>
                      @endif
                    </td>
                    <th>
                        @if ($task->task_taskstatus == 1)
                            <span style="color: #CCCCCC">{{ $task->due_date }}</span>
                        @else
                            {{ $task->due_date }}
                        @endif
                    </th>
                    <th>
                        @foreach ($users_projects as $user_project)
                            @if ($user_project->project_id == $task->project_id)
                                @if ($task->task_taskstatus == 1)
                                    <span style="color: #CCCCCC">{{ $user_project->firstname }}</span>
                                @else
                                    {{ $user_project->firstname }}
                                @endif
                            @endif
                        @endforeach
                    </th>
                    <th>
                        @foreach ($users as $key => $value)
                            @if ($value->id == $task->team_lead_id)
                                @if ($task->task_taskstatus == 1)
                                    <span style="color: #CCCCCC">{{ $value->firstname }}</span>
                                @else
                                    {{ $value->firstname }}
                                @endif
                            @endif
                        @endforeach
                    </th>
                    <th>

                        @foreach ($users as $key => $value)
                            @if ($value->id == $task->developer_id)
                                @if ($task->task_taskstatus == 1)
                                    <span style="color: #CCCCCC">{{ $value->firstname }}</span>
                                @else
                                    {{ $value->firstname }}
                                @endif
                            @endif
                        @endforeach
                    </th>
                    <td>
                        <a href="/tasks/{{$task->task_taskid}}/finish-task">
                            @if ($task->task_taskstatus == 0)
                                <i class="fa fa-times-circle" style="color: #007bff; margin-left: 20px;"></i>
                            @else
                                <i class="fa fa-check-circle" style="color: #007bff; margin-left: 20px;"></i>
                            @endif
                        </a>


                        @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4 && $task->status == 'Closed')
                            @if ($task->task_taskstatus == 0)
                                <a class="btn btn-xs btn-primary" href="{{ route('tasks.edit', $task->task_taskid) }}"><i class="fa fa-edit"></i></a>
                            @endif
                        @endif
                        <a class="btn btn-xs btn-primary" href="{{ route('tasks.show', $task->task_taskid) }}"><i class="fa fa-eye"></i></a>


                        @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4)
                            {!! Form::open(['method' => 'DELETE', 'route' => ['tasks.destroy', $task->task_id], 'style'=> 'display:inline']) !!}

                            <!--{!! Form::submit('Delete',['class'=> 'btn btn-xs btn-danger']) !!}-->
                                <input type="submit" value="&#xf1f8" class="fa fa-trash" style="color: red; font-size: 18px; margin-bottom: 0;">
                            {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
            @endforeach
    </table>

    {!! $tasks ->links() !!}




@endsection
