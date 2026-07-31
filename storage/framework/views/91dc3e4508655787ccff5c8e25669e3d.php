<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <?php
        $seoTitle = trim($__env->yieldContent('title', 'MaxinPro — Temukan Properti Impianmu di Jabodetabek'));
        $seoDescription = trim($__env->yieldContent('meta_description', 'MaxinPro adalah platform properti terpercaya untuk jual, beli, titip properti, project baru, dan simulasi KPR di kawasan Jabodetabek.'));
        // Canonical defaults to the current path WITHOUT query strings, so filtered
        // and paginated variants don't compete with each other as duplicate content.
        $seoCanonical = trim($__env->yieldContent('canonical', url()->current()));
        $seoImage = trim($__env->yieldContent('og_image', asset('images/og-default.jpg')));
        $seoType = trim($__env->yieldContent('og_type', 'website'));
    ?>

    <title><?php echo e($seoTitle); ?></title>
    <meta name="description" content="<?php echo e($seoDescription); ?>">
    <link rel="canonical" href="<?php echo e($seoCanonical); ?>">
    <meta name="robots" content="<?php echo $__env->yieldContent('robots', 'index, follow, max-image-preview:large, max-snippet:-1'); ?>">

    
    <meta property="og:site_name" content="MaxinPro">
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="<?php echo e($seoType); ?>">
    <meta property="og:title" content="<?php echo e($seoTitle); ?>">
    <meta property="og:description" content="<?php echo e($seoDescription); ?>">
    <meta property="og:url" content="<?php echo e($seoCanonical); ?>">
    <meta property="og:image" content="<?php echo e($seoImage); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($seoTitle); ?>">
    <meta name="twitter:description" content="<?php echo e($seoDescription); ?>">
    <meta name="twitter:image" content="<?php echo e($seoImage); ?>">

    
    <script type="application/ld+json">
<?php echo json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'RealEstateAgent',
    'name' => 'MaxinPro',
    'url' => url('/'),
    'logo' => asset('images/logo-cropped.png'),
    'image' => asset('images/logo-cropped.png'),
    'description' => 'Platform properti untuk jual, beli, titip properti, project baru, dan simulasi KPR di kawasan Jabodetabek.',
    'telephone' => '+62-811-1234-5678',
    'email' => 'halo@maxinpro.com',
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Tangerang Selatan',
        'addressRegion' => 'Banten',
        'addressCountry' => 'ID',
    ],
    'areaServed' => [
        'Jakarta',
        'Tangerang',
        'Tangerang Selatan',
        'Bekasi',
        'Depok',
        'Bogor'
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>

</script>

    
    <?php echo $__env->yieldPushContent('schema'); ?>

    <link rel="icon" type="image/png" href="<?php echo e(asset('favicon.png')); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-sans">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[100] focus:bg-white focus:px-4 focus:py-2 focus:rounded-lg focus:font-bold">
        Lompat ke konten utama
    </a>

    <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main id="main-content">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\Layang\maxinpro.com\resources\views\layouts\app.blade.php ENDPATH**/ ?>