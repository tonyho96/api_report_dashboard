@extends('layouts.appnew')

@section('content')

<div class="m-login__signin">
	<div class="m-login__head">
		<h3 class="m-login__title">
			Sign In To Admin
		</h3>
	</div>
	<form class="m-login__form m-form" action="{{ route('login') }}" method="POST">
		{{ csrf_field() }}
		<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} m-form__group">
		<input id="email" type="email" class="form-control m-input" name="email" value="{{ old('email') }}" required autofocus>
			@if ($errors->has('email'))
			<span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			</span>
			@endif
		</div>
		<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} m-form__group">
			<input id="password" type="password" class="form-control" name="password" required>
			@if ($errors->has('password'))
			<span class="help-block">
				<strong>{{ $errors->first('password') }}</strong>
			</span>
			@endif
		</div>
		<div class="row m-login__form-sub">
			<div class="col m--align-left m-login__form-left">
				<label class="m-checkbox  m-checkbox--light">
					<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
					<span></span>
				</label>
			</div>
			<div class="col m--align-right m-login__form-right">
				<a href="{{ route('password.request') }}" id="m_login_forget_password" class="m-link">
					Forget Password ?
				</a>
			</div>
		</div>
		<div class="m-login__form-action">
			<input type="submit" id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary" value="Sign In"/>
		</div>
	</form>
</div>
<div class="m-login__account">
	<span class="m-login__account-msg">
		Don't have an account yet ?
	</span>
	&nbsp;&nbsp;
	<a href="{{ route('register') }}" id="m_login_signup" class="m-link m-link--light m-login__account-link">
		Sign Up
	</a>
</div>
@stop