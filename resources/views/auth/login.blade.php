<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Login {{ config('app.name') }}</title>
        <!-- Bootstrap 5 CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            body {
                background-color: #251c19 !important; /* Luxury Espresso Bakery Background */
            }
            .btn-primary {
                background-color: #c59b27 !important; /* Warm Accent Gold */
                border-color: #c59b27 !important;
            }
            .btn-primary:hover {
                background-color: #aa821d !important;
                border-color: #aa821d !important;
            }
            .form-floating > .form-control:placeholder-shown ~ label {
                opacity: 0.65;
            }
            a {
                color: #c59b27;
            }
            a:hover {
                color: #aa821d;
            }
        </style>
    </head>
    <body>
        <div id="layoutAuthentication" class="d-flex flex-column min-vh-100">
            <div id="layoutAuthentication_content" class="flex-grow-1">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Login</h3>
                                    </div>
                                    <div class="card-body">
                                        
                                        <!-- Laravel Functional Form Wrapper -->
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf <!-- Crucial security token for Laravel POST requests -->

                                            <!-- Email Address Field -->
                                            <div class="form-floating mb-3">
                                                <input class="form-control @error('email') is-invalid @enderror" 
                                                       id="inputEmail" 
                                                       type="email" 
                                                       name="email" 
                                                       value="{{ old('email') }}" 
                                                       placeholder="name@example.com" 
                                                       required 
                                                       autofocus />
                                                <label for="inputEmail">Email address</label>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <!-- Password Field -->
                                            <div class="form-floating mb-3">
                                                <input class="form-control @error('password') is-invalid @enderror" 
                                                       id="inputPassword" 
                                                       type="password" 
                                                       name="password" 
                                                       placeholder="Password" 
                                                       required />
                                                <label for="inputPassword">Password</label>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <!-- Remember Password Cookie checkbox -->
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" name="remember" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div>

                                            <!-- Form Action Controls -->
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small text-decoration-none" href="{{ route('password.request') }}">Forgot Password?</a>
                                                <button type="submit" class="btn btn-primary px-4 py-2">Login</button>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small">
                                            <a class="text-decoration-none" href="{{ route('register') }}">Need an account? Sign up!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto border-top">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small text-muted">
                            <div>Copyright &copy; Sweet Delights Cake Store 2026</div>
                            <div>
                                <a class="text-decoration-none text-muted" href="#">Privacy Policy</a>
                                &middot;
                                <a class="text-decoration-none text-muted" href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    </body>
</html>