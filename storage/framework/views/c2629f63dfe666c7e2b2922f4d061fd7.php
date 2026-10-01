<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head><?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></head>
<body>
<a href="#main-content" class="skip-link">Pular para o conteúdo</a>
<div class="sidebar-overlay" data-sidebar-close hidden></div>
<aside class="sidebar" id="sidebar" aria-label="Menu principal">
    <a href="<?php echo e(route('assets.index')); ?>" class="brand"><span class="brand-mark"><?php echo $__env->make('partials.icon', ['name' => 'brand'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></span><span>MarketWatch<small>ANALYTICS</small></span></a>
    <div class="nav-label">WORKSPACE</div>
    <nav class="sidebar-nav" aria-label="Navegação principal">
        <a href="<?php echo e(route('assets.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('assets.*') ? 'active' : ''); ?>" <?php if(request()->routeIs('assets.*')): ?> aria-current="page" <?php endif; ?>><?php echo $__env->make('partials.icon', ['name' => 'grid'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <span>Visão do mercado</span></a>
        <a href="<?php echo e(route('alerts.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('alerts.index', 'alerts.edit') ? 'active' : ''); ?>" <?php if(request()->routeIs('alerts.index', 'alerts.edit')): ?> aria-current="page" <?php endif; ?>><?php echo $__env->make('partials.icon', ['name' => 'bell'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <span>Meus alertas</span></a>
        <a href="<?php echo e(route('alerts.create')); ?>" class="sidebar-link <?php echo e(request()->routeIs('alerts.create') ? 'active' : ''); ?>" <?php if(request()->routeIs('alerts.create')): ?> aria-current="page" <?php endif; ?>><?php echo $__env->make('partials.icon', ['name' => 'plus'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <span>Criar alerta</span></a>
    </nav>
    <div class="sidebar-note"><span class="small-icon"><?php echo $__env->make('partials.icon', ['name' => 'chart'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></span><strong>Seu radar de preços.</strong><p>Câmbio e cripto no mesmo lugar, com alertas do seu jeito.</p><a href="<?php echo e(route('alerts.create')); ?>">Configurar alerta <?php echo $__env->make('partials.icon', ['name' => 'arrow'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></a></div>
    <div class="sidebar-user"><span class="avatar"><?php echo e(mb_strtoupper(mb_substr(auth()->user()->name, 0, 1))); ?></span><div class="user-text"><strong><?php echo e(auth()->user()->name); ?></strong><span><?php echo e(auth()->user()->email); ?></span></div><form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button class="icon-button" type="submit" aria-label="Sair da conta" title="Sair"><?php echo $__env->make('partials.icon', ['name' => 'logout'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button></form></div>
</aside>
<div class="app-shell">
    <header class="topbar"><div class="topbar-left"><button class="icon-button mobile-menu" type="button" data-sidebar-toggle aria-controls="sidebar" aria-expanded="false" aria-label="Abrir menu"><?php echo $__env->make('partials.icon', ['name' => 'menu'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button><span class="breadcrumb-label">Workspace <span>/</span> <strong><?php echo $__env->yieldContent('eyebrow', 'Mercado'); ?></strong></span></div><div class="topbar-right"><time class="desktop-date" data-local-date></time><span class="base-currency">BRL <span>R$</span></span><button class="icon-button" data-theme-toggle type="button" aria-label="Alternar tema" title="Alternar tema"><?php echo $__env->make('partials.icon', ['name' => 'sun'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button></div></header>
    <main id="main-content" class="main-content" tabindex="-1">
        <?php echo $__env->make('partials.messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <footer class="app-footer"><span>MarketWatch Analytics</span><span>Câmbio & cripto · Valores em BRL</span></footer>
</div>
<div class="live-feedback" data-live-feedback role="status" aria-live="polite"></div>
<dialog id="delete-dialog" class="confirm-dialog" aria-labelledby="delete-title" aria-describedby="delete-description"><div class="dialog-icon"><?php echo $__env->make('partials.icon', ['name' => 'trash'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div><h2 id="delete-title">Excluir alerta?</h2><p id="delete-description">Este alerta será removido. Você poderá criar outro a qualquer momento.</p><div class="dialog-actions"><button type="button" class="btn btn-secondary" data-dialog-cancel>Cancelar</button><button type="button" class="btn btn-danger" data-dialog-confirm>Excluir alerta</button></div></dialog>
</body>
</html>
<?php /**PATH C:\Users\RES0147476\Documents\Moedas\monitor-cotacoes-laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>