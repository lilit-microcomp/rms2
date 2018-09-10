<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{!! URL::asset('js/comments/crud/index.js') !!}"></script>
<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
<div class="row">
    <div class="col-md-12">
        <div class="form-group row">
        	<!-- <label for="create_comment" class="col-md-4 col-form-label text-md-right">Add new Comment</label> -->

        	<div class="col-md-10">
                {{ Form::hidden('comment_parent_id') }}
        		{!! Form::textarea('create_comment', null, array('placeholder' => 'Type your comment ...','size' => '50x5', 'class' => 'form-control comment-collapse-box')) !!}
        		@if ($errors->has('create_comment'))
        			<span class="invalid-feedback">
        				<strong>{{ $errors->first('create_comment') }}</strong>
        			</span>
        		@endif
        	</div>
        </div>

    </div>
</div>
