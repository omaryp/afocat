<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Afocat - Login</title>

  <!-- Custom fonts for this template-->
  <link href=" {{ asset('css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet" type="text/css">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">AFOCAT - TRANS REGIÓN PIURA</h1>
                  </div>
                  <form class="user" method="POST" action="{{ route('login') }}">
                    {!! csrf_field() !!}
                    <div class="form-group {{ $errors->has('username') ? 'border-danger':'' }}">
                      <input type="text" class="form-control form-control-user" id="username" name="username" aria-describedby="emailHelp" placeholder="Ingrese Usuario ...">
                      {!! $errors->first('username','<span class="help-block">:message</span>')!!}
                    </div>
                    <div class="form-group {{ $errors->has('password') ? 'border-danger':'' }}">
                      <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Ingrese Contraseña ...">
                      {!! $errors->first('password','<span class="help-block">:message</span>')!!}
                    </div>
                    <input type="submit" value="Ingresar" class="btn btn-primary btn-user btn-block">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script
			  src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
              crossorigin="anonymous"></script>
              
  <!--<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>-->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
  

  <!-- Core plugin JavaScript-->
  <!--<script src="vendor/jquery-easing/jquery.easing.min.js"></script>-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>
</html>