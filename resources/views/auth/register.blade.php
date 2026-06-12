<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Register -{{config('app.name')}}</title>
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
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header justify-content-center">
                                        <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputFullName" type="text" placeholder="Enter your full name" required />
                                                        <label for="inputFullName">Full name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputPhone" type="tel" placeholder="Enter phone number" />
                                                        <label for="inputPhone">Phone number (Optional)</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" required />
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPassword" type="password" placeholder="Create a password" required />
                                                        <label for="inputPassword">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirm password" required />
                                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary btn-block py-2">Create Account</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a class="text-decoration-none" href="{{ route('login') }}">Have an account? Go to login</a></div>
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