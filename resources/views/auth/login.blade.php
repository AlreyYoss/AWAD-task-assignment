<html>
<head>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0"> 
  <meta charset="utf-8">
  <title>{{ isset($url) ? ucwords($url) : ""}} Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
  <link href="{{ asset('/userAuth.css') }}" rel="stylesheet">
</head>
<body>
@php
  $userrole = isset($url) ? $url : "";
@endphp
        <div class="main">
            <div class="container form-container">
			<form class="form" method="POST" action='{{ url("login/$url") }}' aria-label="{{ __('Login') }}">
			@csrf
                    <h2 class="form_title title">Sign In to Website</h2>
					<input class="form__input" type="text" placeholder="Email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title ="Must contain '@' and '.' in the email" value="{{ old('email') }}" required autocomplete="email" autofocus>
					@error('email')
						<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
						</span>
					@enderror
					<input class="form__input" type="password" placeholder="Password" name="password" required autocomplete="current-password" required> 
					@error('password')
						<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
						</span>
					@enderror
                   <button class="form__button button submit" type="submit"> SIGN IN </button>
                </form>
            </div>
            <div class="left-box-outer-container">
				<div class="left-box">
					<div class="left-box left-box">
						<div class="left__box__container" >
							<h2 class="left__box__title title">{{ __('Hello!') }} </br> {{ isset($url) ? ucwords($url) : ""}} </h2>
							<p class="left__box__description description"> Enter your personal details and start journey with us </p>
              <a class="left-box-btn-link" href="{{ 'http://localhost:8000/register/' . $userrole }}"><button class="signin__button button switch-btn"> SIGN UP</button></a>
					    </div>
					</div>
				</div>
			</div>
		</div>
</body>

                
    
            
