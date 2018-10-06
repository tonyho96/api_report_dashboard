@extends('layouts.appnew')

@section('content')
<div class="">
	<div class="m-login__head">
		<h3 class="m-login__title">
			Forgotten Password ?
		</h3>
		<div class="m-login__desc">
			Enter your email to reset your password:
		</div>
	</div>
	<form class="m-login__form m-form" action="{{ route('password.email') }}" method="POST">
	   {{ csrf_field() }}
		<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} m-form__group">
			<input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off" value="{{ old('email') }}" required>
			 @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
		</div>
		<div class="m-login__form-action">
			<button id="m_login_forget_password_submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary" type="submit">
				Send Password Reset Link
			</button>
			&nbsp;&nbsp;
			<button id="m_login_forget_password_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn"  onclick="window.history.back();">
				Cancel
			</button>
		</div>
	</form>
</div>
@stop