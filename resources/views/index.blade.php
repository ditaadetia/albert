<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
    <link rel="shortcut icon" type="image/x-icon" href="img/logo_kota_pontianak.png">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/Login_v1/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/Login_v1/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/Login_v1/vendor/animate/animate.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/Login_v1/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/Login_v1/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/Login_v1/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/Login_v1/css/main.css') }}">
	<link rel="shortcut icon" type="image/x-icon" href="img/pupr.svg">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<!--===============================================================================================-->
<!-- <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}"> -->
{{-- <script type="text/javascript">
	function validasi() {
		if(document.formLogin.username.value == "")
	   {
		 alert( "MASUKKAN NAMA ANDA!" );
		 document.formLogin.username.focus() ;
		 return false;
	   }

	   if(document.formLogin.password.value == "")
	   {
		 alert( "MASUKKAN PASSWORD ANDA!" );
		 document.formLogin.password.focus() ;
		 return false;
	   }
	}
</script> --}}
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt style="margin-top:-120px !important;">
          			<img src="img/logo_kota_pontianak.png" alt="IMG">
				</div>
				<form style="margin-top:-110px !important;" class="form-horizontal" method="post" action="/" name="formLogin" onsubmit="return(validasi());">
					@csrf
					@if (session()->has('success'))
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							{{ session('success') }}
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
						</div>
					@endif

					@if (session()->has('loginError'))
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							{{ session('loginError') }}
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
						</div>
					@endif
            		<span class="login100-form-title">
						Form Login Admin
					</span>
					<div class="wrap-input100 validate-input">
						<input class="input100" type="email" id="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" autofocus required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input">
						<input class="input100" id="password" type="password" name="password" class="form-control" placeholder="Password" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-key" aria-hidden="true"></i>
						</span>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="submit" type="submit">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script>
    $("span.menu").click(function(){
      $(" ul.navig").slideToggle("slow" , function(){
      });
    });
    </script>
<!--===============================================================================================-->
	<script src="{{ asset('assets/Login_v1/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('assets/Login_v1/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('assets/Login_v1/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('assets/Login_v1/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('assets/Login_v1/vendor/tilt/tilt.jquery.min.js') }}"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('assets/Login_v1/js/main.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>