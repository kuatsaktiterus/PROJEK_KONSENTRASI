<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('layout/login/css/style.css') }}">

    <title>Login</title>
</head>
<body class="d-flex
             justify-content-center
             align-items-center
             vh-100">
    <div class="w-400 p-5 shadow rounded">
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="d-flex 
                        justify-content-center 
                        align-items-center 
                        flex-column">
                <img src="{{ asset('layout/login/image/school.svg') }}" alt="school" class="w-25">
                <h3 class="display-4 fs-1 text-center">
                    LOGIN</h3>
            </div>
            <div class="mb-3">
              <label  for="username"  class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="mb-3">
                <label  class="form-label" for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
          
    </div>
</body>
</html>