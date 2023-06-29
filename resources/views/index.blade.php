<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Log In Form</title>

    <!-- Bootstrap CDN -->


    <!-- bootstrap css 1 js1 -->
    <link href="{{ asset('./assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href={{ asset('./assets/css/login_form.css') }} type="text/css">

    <link rel="stylesheet" href="{{ asset('./assets/css/toastr.min.css') }}">

    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    {{-- <link href="{{ asset('./assets/css/all.min.css') }}" rel="stylesheet" type="text/css"> --}}

</head>

<body>

    <x-error name="error"></x-error>
    <div class="loginSection">
        <div class="fullLoginForm shadow">

            <div class="welcomeSection">
                <h5>Welcome Back!</h5>
                <p>Login to continue</p>
            </div>
            <div class="logoSection mt-4">
                <h5>Hein Zarni</h5>
            </div>
            <form action="/login" id="loginForm" class="loginForm my-3
        " method="post">
                @csrf
                <div class="inputGroup">
                    <input type="text" id="loginUserName" name="Username" autocomplete="off"
                        value="{{ old('Username') }}" required>
                    <label for="name"><i class="fa-solid fa-user text-dark"></i> Username</label>
                    <div class="invalid-userName">
                        <p class="text-danger mb-0 ms-3"><i class="fa-solid fa-triangle-exclamation text-danger"></i>
                            Please enter your name</p>
                    </div>
                    <x-formerror name="Username"></x-formerror>
                </div>
                <div class="inputGroup">
                    <input type="password" id="loginPassword" name="password" autocomplete="off" required>
                    <label for="name"><i class="fa-solid fa-lock text-dark"></i> Password</label>
                    <div class="invalid-password">
                        <p class="text-danger mb-0 ms-3"><i class="fa-solid fa-triangle-exclamation text-danger"></i>
                            Please enter your password</p>
                    </div>
                    <x-formerror name="password" class="numberError"></x-formerror>
                </div>
                <div class="form-check checkBoxPosition my-1 ms-4">
                    <input class="form-check-input" id="rememberChk" name="remember" type="checkbox" value="1"
                        id="flexCheckDefault">
                    <label class="form-check-label text-muted rememberChk" for="rememberChk">
                        Remember me
                    </label>
                </div>
                <div class="loginSubmitBtn my-2">
                    <button type="button" id="loginSubmit">Login</button>
                </div>
            </form>
            
            <div class="versionSection text-muted">
                <div class="row">
                    <div class="col-8">
                        <h6>HEIN ZARNI <span id="UpdateYear"></span></h6>
                    </div>
                    <div class="col-4 text-end">
                        <h6>v 0.0.1</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap CDN -->
    <!-- jquery js1  -->
    <script src="{{ asset('./assets/js/jquery.min.js') }}" type="text/javascript"></script>

    <!-- bootstrap css1 js1  -->
    <script src="{{ asset('./assets/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>

    {{-- custom js  --}}
    <script src="{{ asset('./assets/js/login_form.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>

    <script>
        toastr.options.timeOut = 5000;
        toastr.options.closeButton = true;
        toastr.options.positionClass = "toast-top-right";
        toastr.options.showMethod = "fadeIn";
        toastr.options.progressBar = true;
        toastr.options.hideMethod = "fadeOut";

        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif (Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @elseif (Session::has('warning'))
            toastr.warning('{{ Session::get('warning') }}');
        @elseif (Session::has('danger'))
        toastr.error('{{ Session::get('danger') }}');
        @endif
    </script>

</body>

</html>
