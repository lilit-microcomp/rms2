<div class="row">
    <div class="col-md-12">
        <div class="form-group row">
            <label for="firstname" class="col-md-4 col-form-label text-md-right">First Name</label>

            <div class="col-md-6">
            <!-- <input id="firstname" type="text" class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" name="firstname" value="{{ old('firstname') }}" required autofocus> -->
                {!! Form::text('firstname', null, $attributes = $errors->has('firstname') ? array('placeholder' => 'Firstname', 'class' => 'form-control is-invalid') : array('placeholder' => 'Firstname', 'class' => 'form-control')) !!}
                @if ($errors->has('firstname'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('firstname') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <div class="form-group row">
            <label for="lastname" class="col-md-4 col-form-label text-md-right">Last Name</label>

            <div class="col-md-6">
            <!-- <input id="lastname" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ old('lastname') }}" required autofocus> -->
                {!! Form::text('lastname', null, $attributes = $errors->has('lastname') ? array('placeholder' => 'Lastname', 'class' => 'form-control is-invalid') : array('placeholder' => 'Lastname', 'class' => 'form-control')) !!}
                @if ($errors->has('lastname'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('lastname') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

            <div class="col-md-6">
            <!-- <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required> -->
                {!! Form::email('email', null, $attributes = $errors->has('email') ? array('placeholder' => 'Email', 'class' => 'form-control is-invalid') : array('placeholder' => 'Email', 'class' => 'form-control')) !!}
                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="role" class="col-md-4 col-form-label text-md-right">Administrative Rights</label>

            <div class="col-md-6">
            <!--<select id="role" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" value="{{ old('role') }}" required>
                    <option value="" selected disabled>Choose</option>
                    <option value="admin">Administrator</option>
                    <option value="prmanager">Project Manager</option>
                    <option value="developer">Developer</option>
                    <option value="team_lead">Team Lead</option>
                </select>-->

                {{ Form::select('role', $roles, null, $errors->has('role') ? array('placeholder' => 'Please select ...', 'class' => 'form-control is-invalid') : array('placeholder' => 'Please select ...', 'class' => 'form-control')) }}


                @if ($errors->has('role'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('role') }}</strong>
                    </span>
                @endif

            </div>
        </div>

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
