@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Edit Task!</div>

                <div class="card-body">
                    {!! Form::model($task[0], ['method' => 'PATCH', 'route' => ['tasks.update', $task[0]->task_taskid], 'disabled' => true]) !!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="firstname" class="col-md-4 col-form-label text-md-right">Choose client</label>

                                <div class="col-md-6">
                                    {{ Form::select('client_id', $clients, null, ['placeholder' => 'Please select ...', 'class' => 'form-control', 'disabled' => 'enable']) }}

                                    @if ($errors->has('companyname'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('companyname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Choose project</label>

                                <div class="col-md-6">
                                    {{ Form::select('project_id', $proj, null, ['placeholder' => 'Please select ...', 'class' => 'form-control', 'disabled' => 'enable']) }}
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
                                    {!! Form::text('due_date', null, $errors->has('developer_id') ? ['placeholder' => 'Due date', 'class' => 'form-control is-invalid', 'id' => 'datepicker-end']: ['placeholder' => 'Due date', 'class' => 'form-control', 'id' => 'datepicker-end']) !!}

                                    @if ($errors->has('due_date'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('due_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="duration" class="col-md-4 col-form-label text-md-right">Estimated hours</label>

                                <div class="col-md-6">
                                <!-- <input id="firstname" type="text" class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" name="firstname" value="{{ old('firstname') }}" required autofocus> -->
                                    {!! Form::text('duration', null, $attributes = $errors->has('duration') ? array('placeholder' => 'Estimated hours', 'class' => 'form-control is-invalid') : array('placeholder' => 'Estimated hours', 'class' => 'form-control')) !!}
                                    @if ($errors->has('duration'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('duration') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">

                                <label for="team_lead_id" class="col-md-4 col-form-label text-md-right">Choose team lead </label>

                                <div class="col-md-6">
                                    {{ Form::select('team_lead_id', $lead_user, null, ['placeholder' => 'Please select ...', 'class' => 'form-control']) }}

                                    @if ($errors->has('team_lead_id'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('team_lead_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="developer_id" class="col-md-4 col-form-label text-md-right">Choose developer</label>

                                <div class="col-md-6">
                                    {{ Form::select('developer_id', $dev_user, null, $errors->has('developer_id') ? ['placeholder' => 'Please select ...', 'class' => 'form-control is-invalid']: ['placeholder' => 'Please select ...', 'class' => 'form-control']) }}

                                    @if ($errors->has('developer_id'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('developer_id') }}</strong>
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
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-6">
                                <a class="btn btn-xs btn-success" href="{{ route('tasks.index') }}">Back</a>
                                <button type="submit" class="btn btn-xs btn-primary" name="button">Submit</button>
                            </div>
                        </div>

                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
