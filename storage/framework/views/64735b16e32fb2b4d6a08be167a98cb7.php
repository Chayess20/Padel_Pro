<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'PADEL ACE — Book Courts & Join Tournaments'); ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/styles.css')); ?>?v=<?php echo e(time()); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <header class="header">
        <a href="<?php echo e(url('/')); ?>" class="logo">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Y-PADEL Logo" class="main-logo">
        </a>
        <nav class="nav">
            <a href="<?php echo e(url('/')); ?>" class="<?php echo e(Request::is('/') ? 'active' : ''); ?>">Home</a>
            <a href="<?php echo e(route('tournaments.index')); ?>" class="<?php echo e(Request::is('tournaments') ? 'active' : ''); ?>">DPT</a>
            <a href="<?php echo e(route('rankings.index')); ?>" class="<?php echo e(Request::is('rankings') ? 'active' : ''); ?>">Rankings</a>
            <a href="<?php echo e(route('tournaments.weekly')); ?>" class="<?php echo e(Request::is('weekly-tournaments') ? 'active' : ''); ?>">Weekly Tournament</a>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(url('/profile')); ?>">Profile</a>
                <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" style="background:none; border:none; color:white; cursor:pointer; font-family:var(--font-heading); font-weight:600; text-transform:uppercase;">Log Out</button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>">Log In</a>
                <a href="<?php echo e(route('register')); ?>" class="btn-nav">sign up</a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </nav>
        <button class="menu-toggle" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-col branding">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Y-PADEL Logo" class="footer-logo">
                <p class="footer-text">
                    The premier padel circuit in Dusseldorf. Join the community, 
                    track your ranking, and dominate the court.
                </p>
                <p class="copyright">© <?php echo e(date('Y')); ?> PADEL ACE. All rights reserved.</p>
            </div>

            <div class="footer-col">
                <h4 class="col-title">Explore</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo e(route('register')); ?>">Get Started</a></li>
                    <li><a href="<?php echo e(route('tournaments.index')); ?>">DPT</a></li>
                    <li><a href="<?php echo e(route('rankings.index')); ?>">Rankings</a></li>
                    <li><a href="<?php echo e(route('tournaments.weekly')); ?>">Weekly Tournament</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="col-title">Support</h4>
                <ul class="footer-links">
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>

            <div class="footer-col social">
                <h4 class="col-title">Connect</h4>
                <p>Follow us on Social Media</p>
                <div class="social-icons">
                    </div>
            </div>
        </div>
    </footer>

    <script src="<?php echo e(asset('js/script.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\Padel_Pro\resources\views/layouts/app.blade.php ENDPATH**/ ?>