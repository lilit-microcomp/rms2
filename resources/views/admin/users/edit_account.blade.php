@extends( (Auth::user()->role_id == 1) ? 'layouts.appadmin' : 'layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Edit account!</div>

                    <div class="card-body">
                        {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update_account', $user->id]]) !!}


                        <div class="row">
                            <div class="col-md-12">
                                <!--<div class="form-group row">
                                    <label for="old_password" class="col-md-4 col-form-label text-md-right">Old Password</label>

                                    <div class="col-md-6">
                                        {!! Form::text('old_password', null, $attributes = $errors->has('old_password') ? array('placeholder' => 'Old Password', 'class' => 'form-control is-invalid') : array('placeholder' => 'Old Password', 'class' => 'form-control')) !!}
                                        @if ($errors->has('old_password'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('old_password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>-->


                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                    <!-- <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required> -->
                                        {!! Form::password('password', $attributes = $errors->has('password') ? array('placeholder' => 'Password', 'class' => 'form-control is-invalid') : array('placeholder' => 'Password', 'class' => 'form-control', 'required')) !!}
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                    <div class="col-md-6">
                                        <!-- <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required> -->
                                        {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password-confirm', 'placeholder' => 'Confirm Password', 'required']) !!}
                                    </div>
                                </div>

                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-12 offset-md-6">
                                    <a class="btn btn-xs btn-success" href="{{ route('users.index') }}">Back</a>
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