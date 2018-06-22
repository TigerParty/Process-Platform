<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ mix('/css/cms.css') }}">

</head>

<body class="login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="box-shadow mt-5">
                    <div class="text-white bg-second p-3 d-flex justify-content-center">
                        <div class="logo">
                            <div class="logo-box bg-white m-auto">
                                <img src="{{ asset('/images/Zambia_Logo.svg')}}">
                            </div>
                            <h3 class="text-white font-weight-light-bold mt-2">Administrator Login</h3>
                        </div>
                    </div>
                    <div class="login-form bg-white p-4">
                        <form action="{{ route('admin.login') }}" method="POST">
                            {{ csrf_field() }}

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            <div class="input-group input-group-lg box-shadow">
                              <i class="input-group-addon bg-light-primary border-0 fa  fa-user text-second font-size-1-5" id="account-addon"></i>
                              <input type="text" name="email" class="form-control bg-light-primary border-0 remove-focus-border pl-0" placeholder="ACCOUNT" aria-label="account" aria-describedby="account-addon1">
                            </div>
                            <br>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                            <div class="input-group input-group-lg box-shadow">
                              <i class="input-group-addon bg-light-primary border-0 fa fa-unlock-alt text-second font-size-1-5" id="password-addon"></i>
                              <input type="password" name="password" class="form-control bg-light-primary border-0 remove-focus-border pl-0" placeholder="PASSWORD" aria-label="password" aria-describedby="password-addon1">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary text-white text-uppercase w-100 btn-lg font-weight-normal rounded-0 remove-focus-border cursor-pointer">login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>