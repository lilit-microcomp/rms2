<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{!! URL::asset('js/admin/projects/index.js') !!}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>

<div class="row">
    <div class="col-md-12">


        <div class="form-group row">
            <label for="website" class="col-md-4 col-form-label text-md-right">Website </label>

            <div class="col-md-6">
                {!! Form::text('website', null, $errors->has('website') ? ['placeholder' => 'Website', 'class' => 'form-control is-invalid'] : ['placeholder' => 'Website', 'class' => 'form-control']) !!}

            @if ($errors->has('website'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('website') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="username" class="col-md-4 col-form-label text-md-right">Username </label>

            <div class="col-md-6">
                {!! Form::text('username', null, $errors->has('username') ? ['placeholder' => 'Username', 'class' => 'form-control is-invalid'] : ['placeholder' => 'Username', 'class' => 'form-control']) !!}

            @if ($errors->has('username'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="username" class="col-md-4 col-form-label text-md-right">Password </label>

            <div class="col-md-6">
                {!! Form::text('password', null, $errors->has('password') ? ['placeholder' => 'Password', 'class' => 'form-control is-invalid'] : ['placeholder' => 'Password', 'class' => 'form-control']) !!}

            @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

            <div class="col-md-6">
                {!! Form::textarea('description', null, array('placeholder' => 'Description','size' => '30x5', 'class' => 'form-control', 'id' => 'description')) !!}
                @if ($errors->has('description'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>
        </div>











    </div>


    <div class="form-group row mb-0">
        <div class="col-md-12 offset-md-6">
            <a class="btn btn-xs btn-success" href="{{ route('thirdparty.index') }}">Back</a>
            <button type="submit" class="btn btn-xs btn-primary" name="button">Submit</button>

        </div>
    </div>

</div>
