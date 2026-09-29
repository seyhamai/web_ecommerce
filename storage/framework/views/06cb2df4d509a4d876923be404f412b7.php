<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin - <?php echo e(config('app.name')); ?></title>
    <link href="<?php echo e(asset('admin_assets/css/styles.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        .sb-sidenav .nav-link {
            font-size: 0.95rem;
        }

        .sb-sidenav-menu-nested .nav-link {
            padding-top: 0.35rem !important;
            padding-bottom: 0.35rem !important;
        }
    </style>
</head>

<body class="sb-nav-fixed bg-light">
    <nav class="sb-topnav navbar navbar-expand navbar-light bg-white border-bottom">
        <a class="navbar-brand ps-2 text-dark fw-bold" href="#">Sstore Admin</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-dark" id="sidebarToggle"
            href="#!"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-dark" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav"> 

        <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div id="layoutSidenav_content" class="pt-0">
            <main>
                <?php echo $__env->yieldContent('content'); ?>
            </main>

            <footer class="py-3 bg-white border-top mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; <?php echo e(config('app.name')); ?> <?php echo e(date('Y')); ?></div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <?php if (isset($component)) { $__componentOriginal675889645ce329fb063a537b92ca4c1e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal675889645ce329fb063a537b92ca4c1e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.confirm_modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('confirm_modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal675889645ce329fb063a537b92ca4c1e)): ?>
<?php $attributes = $__attributesOriginal675889645ce329fb063a537b92ca4c1e; ?>
<?php unset($__attributesOriginal675889645ce329fb063a537b92ca4c1e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal675889645ce329fb063a537b92ca4c1e)): ?>
<?php $component = $__componentOriginal675889645ce329fb063a537b92ca4c1e; ?>
<?php unset($__componentOriginal675889645ce329fb063a537b92ca4c1e); ?>
<?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="<?php echo e(asset('js/messages/confirm_modal.js')); ?>"></script>
    <script src="<?php echo e(asset('admin_assets/js/scripts.js')); ?>"></script>
    <script src="<?php echo e(asset('js/general.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/layouts/admin.blade.php ENDPATH**/ ?>