<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Forgot Password - {{ config('app.name') }}</title>
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
                                        <h3 class="text-center font-weight-light my-4">Password Recovery</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">
                                            Enter your email address and we will send you a link to reset your password.
                                        </div>

                                       @if (session('status'))
    <div class="alert alert-success mx-0 d-flex justify-content-between align-items-center" role="alert">
        <div>
            <i class="fas fa-check-circle me-1"></i>
            {{ session('status') }}
        </div>
        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-success">Return to Login</a>
    </div>
@endif
                                        
                                        <<form method="POST" action="{{ route('password.email') }}">
                                            @csrf 

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

                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small text-decoration-none" href="{{ route('login') }}">Return to login</a>
                                                <button type="submit" class="btn btn-primary px-4 py-2">Reset Password</button>
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