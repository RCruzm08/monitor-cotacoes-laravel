<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head><?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></head>
<body>
<main class="container py-5">
    <div class="text-center mb-4"><span class="brand fs-4">MarketWatch Analytics</span><p class="text-body-secondary mt-2">Acompanhe cotações e configure seus alertas.</p></div>
    <div class="row justify-content-center"><div class="col-12 col-md-7 col-lg-5">
        <?php echo $__env->make('partials.messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
    </div></div>
</main>
</body>
</html>
<?php /**PATH C:\Users\RES0147476\Documents\Moedas\monitor-cotacoes-laravel\resources\views/layouts/guest.blade.php ENDPATH**/ ?>