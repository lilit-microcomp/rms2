@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
    body {font-family: Arial, Helvetica, sans-serif;}

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 30%!important;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }



    .modal2 {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content2 {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 30%!important;
    }

    /* The Close Button */
    .close2 {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close2:hover,
    .close2:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }




    .show-comment-box {
        display: block;
    }
</style>

@section('content')
    <div class="container" style="height: 70px;">
        <br>

        PROJECT: <b>{{$projects[0]->project_url}}</b>
        <!--<a href="//{{$projects[0]->project_url}}" target="_blank">
            <img src="{{URL::asset('/img/proj_link.png')}}" alt="project url">
        </a>-->


<!-- start pop up success data -->
        <!-- Trigger/Open The Modal -->
        @if (isset($access_data[0]->data) && $access_data[0]->data != null)
        <img src="{{URL::asset('/img/proj_test_url.png')}}" alt="project url" id="myBtn">
        @else
        Add access data (+)
        @endif





        @if ($projects[0]->project_url == null)
            <i class="fa fa-plus-square-o" id="myBtn2"></i>

        @else
            <a href="//{{$projects[0]->project_url}}" target="_blank" class="fa fa-cogs"></a>
        @endif

        <!-- The Modal2 -->
        <div id="myModal2" class="modal2">

            <!-- Modal2 content -->
            <div class="modal-content2">
                <span class="close2">&times;</span>


                {!! Form::model($task, ['method' => 'POST','route' => ['tasks.setTestUrl', $task[0]->task_id]]) !!}

                <div class="form-group row">
                    <label for="project_url" class="col-md-4 col-form-label text-md-right">Project Url</label>

                    <div class="col-md-6">
                        {!! Form::textarea('project_url', null, array('size' => '30x5', 'class' => 'form-control', 'id' => 'project_url') ) !!}
                        @if ($errors->has('project_url'))
                            <span class="invalid-feedback">
                                    <strong>{{ $errors->first('project_url') }}</strong>
                                </span>
                        @endif
                        <br>
                        <button type="submit" class="btn btn-xs btn-primary" name="button1">Submit</button>
                    </div>
                </div>


                {!! Form::close() !!}
            </div>

        </div>



        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>




                {!! Form::model($task, ['method' => 'POST','route' => ['tasks.saveAccessData', $task[0]->task_id]]) !!}

                    <div class="form-group row">
                        <label for="data" class="col-md-4 col-form-label text-md-right">Access Data</label>

                        <div class="col-md-6">
                            {!! Form::textarea('data', $acc, isset($access_data[0]->data) && $access_data[0]->data != null ? array('size' => '30x5', 'class' => 'form-control', 'id' => 'data') : array('placeholder' => 'Data','size' => '30x5', 'class' => 'form-control', 'id' => 'data')) !!}
                            @if ($errors->has('data'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('data') }}</strong>
                                </span>
                            @endif
                            <br>
                            <button type="submit" class="btn btn-xs btn-primary" name="button">Submit</button>
                        </div>
                    </div>


                {!! Form::close() !!}


            </div>

        </div>


<!-- end pop up success data -->

        &nbsp;&nbsp;&nbsp;&nbsp;
        DEVELOPER: <b>{{$task[0]->firstname}}</b>
        @if (Auth::user()->role_id == 1)
        <span style="margin-left: 10px;"><b>CLIENT: {{$clients[0]->companyname}}</b></span>
        <i class="material-icons" style="font-size:16px; color:#007bff; margin-left: 10px; margin-right: 4px;">email</i><span style="color:#007bff;">{{$clients[0]->email}}</span>
        <i class="fa fa-phone" style="font-size:16px; color:#007bff; margin-left: 10px; margin-right: 4px;"></i>{{$clients[0]->phonenumber}}
        Notes: {{$tasks->id}}
        @endif
    </div>




<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <!--<div class="card-header">Show Task!<br>{!! $tasks->description !!}</div>-->


                @if ($message = Session::get('success'))
                  <div class="alert alert-success">
                    <p>{{ $message }}</p>
                  </div>
                @endif
                <div id="comment-common-box" class="card-body">
                    <!-- {{ Form::commentComponent('sss', null, array('name' => 'due_date', 'placeholder' => 'Due date', 'class' => 'form-control', 'disabled' => 'disabled' )) }} -->
                    <div id="add-new-comment">

                        <a class="btn btn-xs btn-success" href="{{ route('tasks.index') }}">Back</a>
                        <a class="btn btn-primary show-comment-box">Add Note</a>
                        <div class="comment-box d-none">
                            @include('comments.crud.create')
                        </div>

                    </div>

                </div>

            </div>
            @if (isset($comments) && (!empty($comments)))
            <div class="comments" style="margin-top: 20px; padding: 10px;">
                @include('comments.index', $comments)
            </div>
            @endif
        </div>
        <div class="col-md-4 card card-default" style="background-color: #f8f8f8">

            @if ($task[0]->status == 0)
                <span style="font-size: 14px;"><b>Status:</b>&nbsp;&nbsp;<i class="fa fa-circle" style="color: #28a745;"></i></span>
            @else
                <span style="font-size: 14px;"><b>Status:</b>&nbsp;&nbsp;<i class="fa fa-circle" style="color: #007bff;"></i></span>
            @endif
            <b style="margin-top: 15px;">Task Description:</b>
            <p style="margin-top: 15px;">{!! isset($task) && !empty($task[0])?  $task[0]->description : "" !!}</p>
            <hr>




                {!! Form::open(array('route' => 'fileUpload','enctype' => 'multipart/form-data')) !!}



                <div class=" cancel"> <!-- row -->
                    <div class="col-md-4">
                        {!! Form::file('image', array('class' => 'image')) !!}
                    </div><br>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </div>
                {!! Form::close() !!}



                @foreach ($task_files as $task_file)
                    <a href="/images/{!! $task_file !!}" download> <p style="color: #007bff">{!! $task_file !!}</p> </a>
                @endforeach

        </div>
    </div>
</div>


    @if (count($errors) > 0)
        <div class="alert alert-danger">

            <strong>Whoops!</strong> There were some problems with your input.<br><br>

            <ul>

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>
    @endif






    <script>
        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it





        // Get the modal2
        var modal2 = document.getElementById('myModal2');

        // Get the button that opens the modal2
        var btn2 = document.getElementById("myBtn2");

        // Get the <span> element that closes the modal2
        var span2 = document.getElementsByClassName("close2")[0];

        // When the user clicks the button, open the modal2
        btn2.onclick = function() {
            modal2.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal2
        span2.onclick = function() {
            modal2.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal2, close it
        window.onclick = function(event) {
            if (event.target == modal2) {
                modal2.style.display = "none";
            }

        }

    </script>
@endsection



