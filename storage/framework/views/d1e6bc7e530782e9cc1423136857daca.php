<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light bg-white border-end" id="sidenavAccordion">

        <?php
            // 🌟 ALL MENU DATA LIVES HERE NOW
            $menuItems = [
                [
                    'type' => 'heading',
                    'title' => 'Core',
                ],
                [
                    'type' => 'link',
                    'title' => 'Dashboard',
                    'icon' => 'fas fa-tachometer-alt',
                    'url' => '/admin/dashboard',
                    'active' => request()->is('admin/dashboard'),
                ],
                [
                    'type' => 'heading',
                    'title' => 'Store Management',
                ],
                [
                    'type' => 'dropdown',
                    'title' => 'Catalog',
                    'icon' => 'fas fa-box',
                    'id' => 'collapseCatalog',
                    'active' => request()->routeIs('admin.products.*', 'admin.categories.*', 'admin.attributes.*'),
                    'children' => [
                        [
                            'title' => 'Products',
                            'url' => route('admin.products.index'),
                            'active' => request()->routeIs('admin.products.*'),
                        ],
                        [
                            'title' => 'Categories',
                            'url' => route('admin.categories.index'),
                            'active' => request()->routeIs('admin.categories.*'),
                        ],
                        [
                            'title' => 'Attributes',
                            'url' => route('admin.attributes.index'),
                            'active' => request()->routeIs('admin.attributes.*'),
                        ],
                    ],
                ],
                [
                    'type' => 'link',
                    'title' => 'Slider Management',
                    'icon' => 'fa-solid fa-image',
                    'url' => route('admin.sliders.index'),
                    'active' => request()->routeIs('admin.sliders.*'),
                ],
                [
                    'type' => 'heading',
                    'title' => 'Administration',
                ],
                [
                    'type' => 'link',
                    'title' => 'Manage Users',
                    'icon' => 'fa-solid fa-user-group',
                    'url' => route('admin.users'),
                    'active' => request()->routeIs('admin.users*'),
                ],
            ];
        ?>

        <div class="sb-sidenav-menu pt-2">
            <div class="nav py-0 gap-0 mt-0">
                <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($item['type'] === 'heading'): ?>
                        <?php if($index > 0): ?>
                            <hr class="dropdown-divider mx-3 mt-3 mb-2 opacity-25">
                        <?php endif; ?>
                        <div class="sb-sidenav-menu-heading text-muted text-uppercase fw-bold pt-1 pb-2"
                            style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            <?php echo e($item['title']); ?>

                        </div>
                    <?php elseif($item['type'] === 'link'): ?>
                        <a class="nav-link py-2 text-dark <?php echo e($item['active'] ? 'fw-bold bg-light border-end border-3 border-primary' : ''); ?>"
                            href="<?php echo e($item['url']); ?>">
                            <div class="sb-nav-link-icon <?php echo e($item['active'] ? 'text-primary' : 'text-secondary'); ?>"
                                style="width: 25px;">
                                <i class="<?php echo e($item['icon']); ?>"></i>
                            </div>
                            <?php echo e($item['title']); ?>

                        </a>
                    <?php elseif($item['type'] === 'dropdown'): ?>
                        <a class="nav-link py-2 text-dark <?php echo e($item['active'] ? 'fw-bold' : 'collapsed'); ?>"
                            href="#" data-bs-toggle="collapse" data-bs-target="#<?php echo e($item['id']); ?>"
                            aria-expanded="<?php echo e($item['active'] ? 'true' : 'false'); ?>"
                            aria-controls="<?php echo e($item['id']); ?>">
                            <div class="sb-nav-link-icon <?php echo e($item['active'] ? 'text-primary' : 'text-secondary'); ?>"
                                style="width: 25px;">
                                <i class="<?php echo e($item['icon']); ?>"></i>
                            </div>
                            <?php echo e($item['title']); ?>

                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse <?php echo e($item['active'] ? 'show' : ''); ?>" id="<?php echo e($item['id']); ?>"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav pb-2">
                                <?php $__currentLoopData = $item['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="nav-link <?php echo e($child['active'] ? 'text-primary fw-bold' : 'text-dark'); ?>"
                                        href="<?php echo e($child['url']); ?>">
                                        <?php echo e($child['title']); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </nav>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="sb-sidenav-footer bg-white border-top py-3">
            <div class="small text-muted mb-1">Logged in as:</div>
            <span class="fw-bold text-dark"><i class="fas fa-circle-user me-1 text-secondary"></i>
                <?php echo e(Auth::user()->full_name ?? 'Admin'); ?></span>
        </div>
    </nav>
</div>
<?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>