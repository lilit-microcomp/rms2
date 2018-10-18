@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
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
    .popup-close {
        position: absolute;
        padding: 10px;
        max-width: 500px;
        border-radius: 10px;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        background: rgba(255,255,255,.9);
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






    /*open and close task's details*/
    .taskNotesDetails {
        width: 100%;
        padding: 50px 0;
        text-align: center;
        background-color: lightblue;

    }

/*

    //Style the buttons
    .taskNotesBtn {
        border: none;
        outline: none;
        padding: 10px 16px;
        background-color: #f1f1f1;
        cursor: pointer;
        font-size: 18px;
    }

    //Style the active class, and buttons on mouse-over
    .active, .taskNotesBtn:hover {
        background-color: #666;
        color: white;
    }
    */


    /* open popup of access data */
    .clicker {
        /*width:100px;
        height:100px;
        background-color:blue;*/
        outline:none;
        cursor:pointer;
    }

    .hiddendiv{
        display:none;
        /*height:200px;
        background-color:green;*/
    }

    .clicker:checked + .hiddendiv{
        display:block;
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
    .sub{
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
    }

    /* start tasks filter */
    #tasksInput {
        background-image: url('/img/searchicon.png');
        background-position: 10px 10px;
        background-repeat: no-repeat;
        width: 100%;
        font-size: 16px;
        padding: 12px 20px 12px 40px;
        border: 1px solid #ddd;
        margin-bottom: 12px;
    }
    #tasksTable {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
        font-size: 18px;
    }
    #tasksTable th, #tasksTable td {
        text-align: left;
        padding: 12px;
    }
    #tasksTable tr {
        border-bottom: 1px solid #ddd;
    }
    #tasksTable tr.tasksHeader, #tasksTable tr:hover {
        background-color: #f1f1f1;
    }
    /* end tasks filter */




    /* start supports filter */
    #supportsInput {
        background-image: url('/img/searchicon.png');
        background-position: 10px 10px;
        background-repeat: no-repeat;
        width: 100%;
        font-size: 16px;
        padding: 12px 20px 12px 40px;
        border: 1px solid #ddd;
        margin-bottom: 12px;
    }
    #supportsTable {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
        font-size: 18px;
    }
    #supportsTable th, #supportsTable td {
        text-align: left;
        padding: 12px;
    }
    #supportsTable tr {
        border-bottom: 1px solid #ddd;
    }
    #supportsTable tr.supportsHeader, #supportsTable tr:hover {
        background-color: #f1f1f1;
    }
    /* start supports filter */
</style>

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="float: left;">
        NOW NOTES: <b>Tasks</b>
        <div id="tasksNote" style="min-height: 360px;">
        @foreach ($task_comments as $task_comment)
        <div style="background-color: #efefef; margin-top: 20px; padding:10px;">
            <div style="float: left; color: #007bff;">{{$task_comment->project_url}} <i class="fa fa-angle-down"></i></div>
            <div style="float: right;">
                {{$task_comment->comment_created_at}}
                {{$task_comment->comment_id}}
                <a href="/home/{{$task_comment->comment_id}}/finish-note">

                    @if ($task_comment->comment_status == 0)
                        <i class="fa fa-times-circle" style="color: #007bff; margin-left: 20px;"></i>
                    @else
                        <i class="fa fa-check-circle" style="color: #007bff; margin-left: 20px;"></i>

                    @endif
                </a>
            </div>

            <!--<button class="taskNotesBtn">1</button>-->
        </div>
            <!-- class="taskNotesDetails" -->
        <div class="taskNotesDetails" style="background-color: #efefef; padding: 10px; text-align: left;">
            {!! $task_comment->text !!}
        </div>



        @endforeach
        </div>

        <div style="margin-bottom: 20px; margin-top: 20px;">
            <b style="font-size: 18px; margin-right: 30px;">OPEN TASKS</b>
            <input type="text" id="tasksInput" onkeyup="tasksSearchFunction()" placeholder="Search for project name.." title="Type in a projec name">

        </div>
        <table id="tasksTable" style="width: 100%;">
            <tr class="tasksHeader">
                <td><b>Project</b></td>
                <td><b>Due Date</b></td>
                <td><b>Developer</b></td>
                <td><b>Controls</b></td>
            </tr>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->project_name }}<br></td>
                    <td>{{ $task->task_due_date }}</td>
                    <td>{{ $task->firstname }}</td>
                    <td>
                        <table>
                            <tr>
                                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4)

                                    <td>
                                        <a href="{{ route('tasks.edit', $task->id) }}">
                                            <i class="fa fa-edit" style="font-size: 12px; color: #007bff; float: left; margin-left: 2px;"></i>
                                        </a>
                                    </td>
                                @endif

                                <td>
                                    <a href="#popup{{$task->id}}" class="btn" style="float: left; margin-left: -30px; margin-right: -10px;">
                                        <i class="fa fa-upload" style="font-size: 12px; color: #007bff; cursor: pointer;" title="file upload"></i>
                                    </a>
                                    <div id="popup{{$task->id}}" class="popup">
                                        {!! Form::open(array('route' => ['fileUploadTaskDash', $task->id],'enctype' => 'multipart/form-data')) !!}



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
                                </td>
                                <td>
                                    <a href="#popupUpload{{$task->task_taskid}}" class="btn" style="float: left; margin-left: -30px;">
                                        <i class="fa fa-download" style="font-size: 12px; color: #007bff; cursor: pointer;" title="show access data"></i>
                                        <!--<i class="fa fa-upload" style="font-size: 12px; color: #007bff; cursor: pointer;" title="file upload"></i>-->
                                    </a>
                                    <div id="popupUpload{{$task->task_id}}" class="popup">
                                        <?php
                                        //echo $tasks[1]->files;
                                        $task_files = (explode(",", $task->files));
                                        unset($task_files[0]);
                                        ?>
                                        @foreach ($task_files as $task_file)
                                            <a href="/images/{!! $task_file !!}" download> <p style="color: #007bff">{!! $task_file !!}</p> </a>
                                        @endforeach
                                    </div>
                                    <a href="#" class="close-popup" style="float: right; color: white; text-decoration: none; cursor:pointer;"><h3>x</h3></a>
                                </td>
                                <td>
                                    <a href="#popupAccess{{$task->task_taskid}}" class="btn" style="float: left; margin-left: -40px;">
                                        <i class="fa fa-key" style="font-size: 12px; color: #007bff; cursor: pointer;" title="show access data"></i>
                                    </a>
                                    <div id="popupAccess{{$task->task_id}}" class="popup">
                                        {!! $task->access_data !!}
                                    </div>
                                    <a href="#" class="close-popup" style="float: right; color: white; text-decoration: none; cursor:pointer;"><h3>x</h3></a>
                                </td>
                                <td>
                                    <a href="/home/{{$task->task_taskid}}/finished" style="float: left; margin-left: -30px;">
                                        @if ($task->task_status == 0)
                                            <i class="fa fa-close" style="font-size: 12px; color: #007bff; float: left; margin-left: 2px;"></i>
                                        @else
                                            <i class="fa fa-check" style="font-size: 12px; color: #007bff; float: left; margin-left: 2px;"></i>
                                        @endif
                                    </a>
                                </td>
                            </tr>
                        </table>












                    </td>
                </tr>





            @endforeach
        </table>
    </div>



    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="float: left;">
        NOW NOTES: <b>Support</b>
        <div id="supportNote" style="min-height: 360px;">
            @foreach ($support_comments as $support_comment)
                <div style="background-color: #efefef; margin-top: 20px; padding:10px;"><div style="float: left; color: #007bff;">{{$task_comment->project_url}} <i class="fa fa-angle-down"></i></div>
                    <div style="float: right;">
                        {{$support_comment->comment_created_at}}
                        {{$support_comment->id}}
                        <!--<a href="/home/{{$support_comment->id}}/finish-note">-->
                        <a href='/home/{{$support_comment->comments_id}}/finish-supp-note'>
                            @if ($support_comment->comment_status == 0)
                                <i class="fa fa-times-circle" style="color: #007bff; margin-left: 20px;"></i>
                            @else
                                <i class="fa fa-check-circle" style="color: #007bff; margin-left: 20px;"></i>

                            @endif
                        </a>
                        <!--</a>-->
                    </div>

                    <!--<button class="taskNotesBtn">1</button>-->
                </div>
                <!-- class="taskNotesDetails" -->
                <div class="supportNotesDetails" style="background-color: #efefef; padding: 10px; text-align: left;">
                    {!! $support_comment->text !!}
                </div>



            @endforeach
        </div>
        <!--<div style="background-color: #efefef; height: 75px; margin-top: 20px;"></div>
        <div style="background-color: #efefef; height: 75px; margin-top: 20px;"></div>
        <div style="background-color: #efefef; height: 75px; margin-top: 20px;"></div>
        <div style="background-color: #efefef; height: 75px; margin-top: 20px;"></div>-->


        <div style="margin-bottom: 20px; margin-top: 20px;">
            <b style="font-size: 18px; margin-right: 30px;">SUPPORT</b>
            <input type="text" id="supportsInput" onkeyup="supportsSearchFunction()" placeholder="Search for project url.." title="Type in a project url">
        </div>

        <table id="supportsTable" style="width: 100%;">
            <tr class="supportsHeader">
                <td><b>URL</b></td>
                <td><b>Developer</b></td>
                <td><b>To Do</b></td>
                <td><b>Controls</b></td>
            </tr>
            @foreach ($supports as $support)
                <tr>
                    <td>{{ $support->project_url }}<br></td>
                    <td>{{ $support->support_due_date }}</td>
                    <td>
                        <i class="fa fa-wrench" style="font-size: 12px; color: #cb1616"></i>
                        <i class="far fa-hdd" style="font-size: 12px; color: #cb1616"></i>
                    </td>
                    <td>
                        {{$done_notes}}
                        @if ($done_notes == 'false')
                            <i class="fa fa-exclamation" style="font-size: 12px; color: #cb1616; float: left; margin-left: 2px;"></i>
                        @endif
                        {{$support->support_id}}
                        @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4)
                            <a href="{{ route('support.edit', $support->support_id) }}" style="float: left; margin-left: 2px;">
                                <i class="fa fa-edit" style="font-size: 12px; color: #007bff"></i>
                            </a>
                        @endif






                        <a href="#popupS{{$support->support_id}}" class="btn" style="float: left; margin-left: -10px; margin-right: -10px; margin-top: -6px;">
                            <i class="fa fa-upload" style="font-size: 12px; color: #007bff; cursor: pointer;" title="file upload"></i>
                        </a>
                        <div id="popupS{{$support->support_id}}" class="popup">

                            {!! Form::open(array('route' => ['fileUploadSuppDash', $support->support_id],'enctype' => 'multipart/form-data')) !!}



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











                        <!--<i class="fa fa-upload" style="font-size: 12px; color: #007bff; float: left;"></i>-->
                        <a href="support/{{ $support->support_id }}" title="show support" style="float: left; margin-left: 2px;"> <i class="fa fa-download" style="font-size: 12px; color: #007bff"></i> </a>




                        <div class="clicker" tabindex="1" style="float: left; margin-left: 2px;"><i class="fa fa-key" style="font-size: 12px; color: #007bff" title="show access data"></i></div>
                        <div class="hiddendiv"><div class="sub">{!! $support->access_data !!}</div></div>



                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<!--
<div id="myModal" class="modal">
    @foreach ($task_comments as $task_comment)
    <div class="modal-content">
        <span class="close">&times;</span>

        <p>{!! $task->access_data !!}</p>

    </div>
    @endforeach
</div>
-->








<script>

    /* start tasks filter */
    function tasksSearchFunction() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("tasksInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("tasksTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    /* end tasks filter */



    /* start supports filter */
    function supportsSearchFunction() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("supportsInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("supportsTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    /* end supports filter */

/*
    // Add active class to the current button (highlight it)
    var header = document.getElementById("tasksNote");
    var btns = header.getElementsByClassName("taskNotesBtn");
    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("taskNotesDetails")[0];
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";


            var x = document.getElementsByClassName("active")[0];
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        });
    }

    //open and close task's details
    //function myFunction() {

    //}
*/

/*
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
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    */
</script>



@endsection

