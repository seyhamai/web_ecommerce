<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Create New Password -<?php echo e(config('app.name')); ?></title>
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
                                        <h3 class="text-center font-weight-light my-4">Create New Password</h3>
                                    </div>
                                    <div class="card-body">
                                        
                                        <form method="POST" action="<?php echo e(route('password.update')); ?>">
                                            <?php echo csrf_field(); ?> 

                                            <input type="hidden" name="token" value="<?php echo e($token); ?>">

                                            <div class="form-floating mb-3">
                                                <input class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                       id="inputEmail" 
                                                       type="email" 
                                                       name="email" 
                                                       value="<?php echo e(old('email', $email)); ?>"
                                                       placeholder="name@example.com" 
                                                       required 
                                                       autofocus />
                                                <label for="inputEmail">Email address</label>
                                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                       id="inputPassword" 
                                                       type="password" 
                                                       name="password" 
                                                       placeholder="New Password" 
                                                       required />
                                                <label for="inputPassword">New Password</label>
                                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" 
                                                       id="inputPasswordConfirm" 
                                                       type="password" 
                                                       name="password_confirmation" 
                                                       placeholder="Confirm Password" 
                                                       required />
                                                <label for="inputPasswordConfirm">Confirm Password</label>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary px-4 py-2">Save Password</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    </body>
</html><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>