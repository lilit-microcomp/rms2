@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    .btn {
        display: inline-block;
    }
    .popup {
        position: fixed;
        padding: 10px;
        max-width: 500px;
        border-radius: 10px;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        background: rgba(255,255,255,.9);
        visibility: hidden;
        opacity: 0;
        /* "delay" the visibility transition */
        -webkit-transition: opacity .5s, visibility 0s linear .5s;
        transition: opacity .5s, visibility 0s linear .5s;
        z-index: 1;
    }
    .popup:target {
        visibility: visible;
        opacity: 1;
        /* cancel visibility transition delay */
        -webkit-transition-delay: 0s;
        transition-delay: 0s;
    }


    .close-popup {
        background: rgba(0,0,0,.7);
        cursor: default;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0;
        visibility: hidden;
        /* "delay" the visibility transition */
        -webkit-transition: opacity .5s, visibility 0s linear .5s;
        transition: opacity .5s, visibility 0s linear .5s;
    }
    .popup:target + .close-popup{
        opacity: 1;
        visibility: visible;
        /* cancel visibility transition delay */
        -webkit-transition-delay: 0s;
        transition-delay: 0s;
    }
</style>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{!! URL::asset('js/admin/tasks/index.js') !!}"></script>

@section('content')

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
                            <a href="{{ route('tasks.show', $task->task_taskid) }}">
                                <span style="color: #CCCCCC">{!! $task->proj_desc_title !!}</span>
                            </a>
                            <span style="color: #CCCCCC"><a href="//{{$task->proj_url}}" target="_blank"> {!! $task->proj_url !!}</a></span>
                        @else
                            <a href="{{ route('tasks.show', $task->task_taskid) }}">
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

                        <a href="#popupUpload{{$task->task_id}}" class="btn">
                            <img src="{{URL::asset('img/downloadFile.png')}}" alt="profile Pic" height="40px" width="40px">
                        <!--<i class="fa fa-upload" style="font-size: 12px; color: #007bff; cursor: pointer;" title="file upload"></i>-->
                        </a>




                        <div id="popupUpload{{$task->task_id}}" class="popup">

                            {!! Form::open(array('route' => ['fileUploadTaskList', $task->task_id],'enctype' => 'multipart/form-data')) !!}
                            <div class=" cancel"> <!-- row -->
                                <div class="col-md-4">
                                    {!! Form::file('image', array('class' => 'image')) !!}
                                </div><br>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success">Upload</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <a href="#" class="close-popup" style="float: right; color: white; text-decoration: none; cursor:pointer;"><h3>x</h3></a>








                        <a href="#popupDownload{{$task->task_id}}" class="btn">
                            <img src="{{URL::asset('img/uploadFile.png')}}" alt="profile Pic" height="40px" width="40px">
                        </a>
                        <div id="popupDownload{{$task->task_id}}" class="popup">




                            <div class=" cancel"> <!-- row -->
                                <div class="col-md-12">
test
                                </div>
                            </div>




                        </div>
                        <a href="#" class="close-popup" style="float: right; color: white; text-decoration: none; cursor:pointer;"><h3>x</h3></a>








                        <img src="{{URL::asset('img/accessData.png')}}" alt="profile Pic" height="40px" width="40px">

                    </td>
                </tr>
            @endforeach
    </table>

    {!! $tasks ->links() !!}




@endsection
