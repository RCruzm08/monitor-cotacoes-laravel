<?php $__currentLoopData = ['success' => 'success', 'error' => 'danger', 'warning' => 'warning']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(session($key)): ?>
        <div class="alert alert-<?php echo e($style); ?>" role="alert"><?php echo e(session($key)); ?></div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if($errors->any()): ?>
    <div class="alert alert-danger" role="alert">
        <strong>Confira os dados informados.</strong>
        <ul class="mb-0 mt-2">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\RES0147476\Documents\Moedas\monitor-cotacoes-laravel\resources\views/partials/messages.blade.php ENDPATH**/ ?>