<html>
<head>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0"> 
  <meta charset="utf-8">
  <title> {{ isset($url) ? ucwords($url) : ""}} Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
  <link href="{{ asset('/userAuth.css') }}" rel="stylesheet">
</head>
<body>
@php
  $userrole = isset($url) ? $url : "";
@endphp
        <div class="main">
            <div class="container form-container">
			@isset($url)
			<form class="form" method="POST" action='{{ url("register/$url") }}' aria-label="{{ __('Login') }}">
			@else
			<form class="form" method="POST" action="{{ route('register') }}" aria-label="{{ __('Login') }}">
			@endisset
			@csrf
                    <h2 class="form_title title">Create Account</h2>
                    <input class="form__input" type="text" placeholder="Name" name="name" required>
					@error('name')
						<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
						</span>
					@enderror
					<input class="form__input" type="text" placeholder="Email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title ="Must contain '@' and '.' in the email" required>
					@error('email')
						<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
						</span>
					@enderror
					<input class="form__input" type="password" placeholder="Password" name="password" required> 
					@error('password')
						<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
						</span>
					@enderror
					<input class="form__input" type="password" placeholder="Confirm Password" name="password_confirmation" required> 
					<button class="form__button button submit" type="submit">SIGN UP</button>
                </form>
            </div>
            <div class="left-box-outer-container">
				<div class="left-box">
					<div class="left-box left-box">
						<div class="left__box__container" >
							<h2 class="left__box__title title">{{ __('Welcome Back!') }}  {{ isset($url) ? ucwords($url) : ""}} </h2>
							<p class="left__box__description description"> To keep connected with us please login with your personal info </p>
              <a class="left-box-btn-link" href="{{ 'http://localhost:8000/login/' . $userrole }}"><button class="signin__button button switch-btn">  SIGN IN </button></a>    
					    </div>
					</div>
				</div>
			</div>
		</div>
</body>

                
    
            
