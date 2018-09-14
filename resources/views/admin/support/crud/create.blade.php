@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Create new support!</div>

                <div class="card-body">
                    {!! Form::open(['route' => 'support.store', 'method' => 'POST', 'disabled' => false]) !!}
                        <!--@include('admin.support.crud.form')-->








                        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

                        <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
                        <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
                        <script type="text/javascript" src="{!! URL::asset('js/admin/support/crud/index.js') !!}"></script>

                        <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="firstname" class="col-md-4 col-form-label text-md-right">Choose client</label>

                                    <div class="col-md-6">
                                        {{ Form::select('client_id', $clients, null, $errors->has('client_id') ? ['placeholder' => 'Please select ...', 'class' => 'form-control is-invalid'] : ['placeholder' => 'Please select ...', 'class' => 'form-control']) }}
                                        @if ($errors->has('client_id'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('client_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="firstname" class="col-md-4 col-form-label text-md-right">Project URL</label>

                                    <div class="col-md-6">
                                        {{ Form::text('project_url', null, $errors->has('project_url') ? ['placeholder' => 'Project URL', 'class' => 'form-control is-invalid'] : ['placeholder' => 'Project URL', 'class' => 'form-control']) }}
                                        @if ($errors->has('project_url'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('project_url') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="due_date" class="col-md-4 col-form-label text-md-right">Cycle Date</label>

                                    <div class="col-md-6">
                                        {!! Form::text('due_date', null, $errors->has('due_date') ? array('name' => 'due_date', 'placeholder' => 'Cycle Date', 'class' => 'form-control is-invalid', 'id' => 'datepicker-end') : array('name' => 'due_date', 'placeholder' => 'Cycle Date', 'class' => 'form-control', 'id' => 'datepicker-end')) !!}

                                        @if ($errors->has('due_date'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('due_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="team_lead_id" class="col-md-4 col-form-label text-md-right">Choose team lead</label>

                                    <div class="col-md-6">
                                        {{ Form::select('team_lead_id', $lead_user, null, $errors->has('team_lead_id') ? ['placeholder' => 'Please select ...', 'class' => 'form-control is-invalid'] : ['placeholder' => 'Please select ...', 'class' => 'form-control']) }}

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
                                    <label for="pm_id" class="col-md-4 col-form-label text-md-right">Choose PM</label>

                                    <div class="col-md-6">
                                        {{ Form::select('pm_id', $pm_user, null, $errors->has('pm_id') ? ['placeholder' => 'Please select ...', 'class' => 'form-control is-invalid']: ['placeholder' => 'Please select ...', 'class' => 'form-control']) }}

                                        @if ($errors->has('pm_id'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('pm_id') }}</strong>
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
                                        {!! Form::textarea('description', null, $errors->has('description') ? array('placeholder' => 'Description','size' => '30x5', 'class' => 'form-control is-invalid', 'id' => 'description') : array('placeholder' => 'Description','size' => '30x5', 'class' => 'form-control is-invalid', 'id' => 'description')) !!}
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
                                        {!! Form::textarea('access_data', null, $errors->has('access_data') ? array('placeholder' => 'Access Data','size' => '30x5', 'class' => 'form-control is-invalid', 'id' => 'access_data') : array('placeholder' => 'Access Data','size' => '30x5', 'class' => 'form-control', 'id' => 'access_data')) !!}

                                    @if ($errors->has('access_data'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('access_data') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-6">
                                <a class="btn btn-xs btn-success" href="{{ route('support.index') }}">Back</a>
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
