@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">




@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                <!--<div class="card-header">Show Task!<br>{!! $supports->description !!}</div>-->


                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <div id="comment-common-box" class="card-body">
                    <!-- {{ Form::commentComponent('sss', null, array('name' => 'due_date', 'placeholder' => 'Due date', 'class' => 'form-control', 'disabled' => 'disabled' )) }} -->
                        <div id="add-new-comment">

                            <a class="btn btn-xs btn-success" href="{{ route('support.index') }}">Back</a>
                            <a class="btn btn-primary show-comment-box">Add Note</a>
                            <div class="comment-box d-none">
                                @include('comments.crud.create_supp')
                            </div>
                        </div>

                    </div>

                </div>
                @if (isset($comments) && (!empty($comments)))
                    <div class="comments" style="border: 1px solid black; margin-top: 20px; padding: 10px;">
                        @include('comments.index', $comments)
                    </div>
                @endif
            </div>
            <div class="col-md-4 card card-default" style="background-color: #f8f8f8">

                @if ($support[0]->status == 0)
                    <span style="font-size: 14px;"><b>Status:</b>&nbsp;&nbsp;<i class="fa fa-circle" style="color: #28a745;"></i></span>
                @else
                    <span style="font-size: 14px;"><b>Status:</b>&nbsp;&nbsp;<i class="fa fa-circle" style="color: #007bff;"></i></span>
                @endif
                <b style="margin-top: 15px;">Task Description:</b>
                <p style="margin-top: 15px;">{!! isset($support) && !empty($support[0])?  $support[0]->description : ""!!}</p>
                <hr>
            </div>
        </div>
    </div>


@endsection

