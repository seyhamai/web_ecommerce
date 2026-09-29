<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <i class="fas fa-check-circle me-2 fs-5 align-middle"></i> 
        <span class="align-middle"><?php echo e(session('success')); ?></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <i class="fas fa-exclamation-circle me-2 fs-5 align-middle"></i> 
        <span class="align-middle"><?php echo e(session('error')); ?></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/components/_alerts.blade.php ENDPATH**/ ?>