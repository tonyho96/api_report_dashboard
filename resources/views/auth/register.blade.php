@extends('layouts.appnew')

@section('content')
<div class="">
	<div class="m-login__head">
		<h3 class="m-login__title">
			Sign Up
		</h3>
		<div class="m-login__desc">
			Enter your details to create your account:
		</div>
	</div>
	<form class="m-login__form m-form" action="{{ route('register') }}" method="POST">
		{{ csrf_field() }}
		<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} m-form__group">
			<input class="form-control m-input" type="text" placeholder="name" id="name" name="name" value="{{ old('name') }}" required autofocus>
			@if ($errors->has('name'))
			<span class="help-block">
				<strong>{{ $errors->first('name') }}</strong>
			</span>
			@endif
		</div>
		<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} m-form__group">
			<input class="form-control m-input" type="text" placeholder="email" id="email" name="email" autocomplete="off" value="{{ old('email') }}" required>
			@if ($errors->has('email'))
			<span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			</span>
			@endif
		</div>
		<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} m-form__group">
			<input class="form-control m-input" type="password" placeholder="Password" name="password" required>
			@if ($errors->has('password'))
			<span class="help-block">
				<strong>{{ $errors->first('password') }}</strong>
			</span>
			@endif
		</div>
		<div class="form-group m-form__group">
			<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" id="password-confirm" name="password_confirmation" required>
		</div>
		<!-- <div class="row form-group m-form__group m-login__form-sub">
			<div class="col m--align-left">
				<label class="m-checkbox m-checkbox--light">
					<input type="checkbox" name="agree">
					I Agree the
					<a href="#" class="m-link m-link--focus">
						terms and conditions
					</a>
					.
					<span></span>
				</label>
				<span class="m-form__help"></span>
			</div>
		</div> -->
		<div class="m-login__form-action">
			<button id="m_login_signup_submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary" type="submit">
				Sign Up
			</button>
			&nbsp;&nbsp;
			<button id="m_login_signup_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn" onclick="window.history.back();">
				Cancel
			</button>
		</div>
	</form>
</div>
@stop