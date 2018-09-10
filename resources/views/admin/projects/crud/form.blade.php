<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{!! URL::asset('js/admin/projects/index.js') !!}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>

<div class="row">
    <div class="col-md-12">
        <div class="form-group row">
            <!--<label for="firstname" class="col-md-4 col-form-label text-md-right">Choose client</label>-->
            {{ Form::label('firstname', 'Client', ['class' => 'col-md-4 col-form-label text-md-right']) }}
            <div class="col-md-6">






                {{ Form::select('client_id', $clients, null, $errors->has('client_id') ? ['placeholder' => 'Please select ...', 'class' => 'form-control is-invalid']: ['placeholder' => 'Please select ...', 'class' => 'form-control']) }}
                @if ($errors->has('client_id'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('client_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">Project Name</label>

            <div class="col-md-6">
                {!! Form::text('name', null, $attributes = $errors->has('name') ? array('placeholder' => 'Project Name', 'class' => 'form-control is-invalid') : array('placeholder' => 'Project Name', 'class' => 'form-control')) !!}
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="due_date" class="col-md-4 col-form-label text-md-right">Due date</label>

            <div class="col-md-6">
                {!! Form::text('due_date', null, array('name' => 'due_date', 'placeholder' => 'Due date', 'class' => 'form-control', 'id' => 'datepicker-end')) !!}

                @if ($errors->has('due_date'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('due_date') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="descriptive_title" class="col-md-4 col-form-label text-md-right">Descriptive title</label>

            <div class="col-md-6">
                <!-- <input id="firstname" type="text" class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" name="firstname" value="{{ old('firstname') }}" required autofocus> -->
                {!! Form::text('descriptive_title', null, $attributes = $errors->has('descriptive_title') ? array('placeholder' => 'Descriptive title', 'class' => 'form-control is-invalid') : array('placeholder' => 'Descriptive title', 'class' => 'form-control')) !!}
                @if ($errors->has('descriptive_title'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('descriptive_title') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="project_url" class="col-md-4 col-form-label text-md-right">Project url</label>

            <div class="col-md-6">
                {!! Form::text('project_url', null, $attributes = $errors->has('project_url') ? array('placeholder' => 'Project url', 'class' => 'form-control is-invalid') : array('placeholder' => 'Project url', 'class' => 'form-control')) !!}
                @if ($errors->has('project_url'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('project_url') }}</strong>
                    </span>
                @endif
            </div>
        </div>



        <div class="form-group row">
            <label for="total_budget" class="col-md-4 col-form-label text-md-right">Total budget</label>

            <div class="col-md-6">
                {!! Form::text('total_budget', null, $attributes = $errors->has('total_budget') ? array('placeholder' => 'Total budget', 'class' => 'form-control is-invalid') : array('placeholder' => 'Total budget', 'class' => 'form-control')) !!}
                @if ($errors->has('total_budget'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('total_budget') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="user_id" class="col-md-4 col-form-label text-md-right">Project manager</label><!--  Assigned to -->

            <div class="col-md-6">
                {{ Form::select('user_id', $users, null, $errors->has('user_id') ? ['placeholder' => 'Please select ...', 'class' => 'form-control is-invalid'] : ['placeholder' => 'Please select ...', 'class' => 'form-control']) }}

            @if ($errors->has('user_id'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('user_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="send_email_notification" class="col-md-4 col-form-label text-md-right">Send e-mail notification?</label>

            <div class="col-md-6">
                <div class="form-check form-check-inline">
                    {!! Form::radio('send_email_notification', '1', true, array('class' => 'form-check-input', 'type' => 'radio', 'id' => 'inlineRadio2')) !!}
                    <label class="form-check-label" for="inlineRadio2">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    {!! Form::radio('send_email_notification', '0', array('class' => 'form-check-input', 'type' => 'radio', 'id' => 'inlineRadio')) !!}
                    <label class="form-check-label" for="inlineRadio1">No</label>
                </div>
                @if ($errors->has('send_email_notification'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('send_email_notification') }}</strong>
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

        <div class="form-group row">
            <label for="access_data" class="col-md-4 col-form-label text-md-right">Access Data</label>

            <div class="col-md-6">
                {!! Form::textarea('access_data', isset($access_data) && $access_data->count() ? $access_data[0]->data : "", null, $errors->has('access_data') ? ['placeholder' => 'Access Data','size' => '25x5', 'class' => 'form-control is-invalid', 'id' => 'access_data'] : ['placeholder' => 'Access Data','size' => '25x5', 'class' => 'form-control', 'id' => 'access_data'] ) !!}
                @if ($errors->has('access_data'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('access_data') }}</strong>
                    </span>
                @endif

            </div>
        </div>

    </div>


    <div class="form-group row mb-0">
        <div class="col-md-12 offset-md-6">
            <a class="btn btn-xs btn-success" href="{{ route('projects.index') }}">Back</a>
            <button type="submit" class="btn btn-xs btn-primary" name="button">Submit</button>

        </div>
    </div>

</div>
