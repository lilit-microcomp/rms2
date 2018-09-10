<meta charset="utf-8">
<meta name="description" content="MICROCOMP">
<meta name="author" content="MICROCOMP">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'MICROCOMP') }}</title>

<link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

<link rel="stylesheet" type="text/css" media="all" href="{{asset('comments/css')}}/comments.css" />

<link rel="stylesheet" href="{{ URL::asset('css/bootstrap-theme.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('comments/js')}}/comment-reply.js" /></script>
<script type="text/javascript" src="{{asset('comments/js')}}/comment-scripts.js" /></script>
