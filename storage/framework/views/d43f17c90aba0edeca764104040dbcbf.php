<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Not Found - EU VAT Info</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center">
    <div class="text-center px-4">
        <h1 class="text-9xl font-bold text-blue-600">404</h1>
        <p class="text-2xl font-semibold text-gray-800 mt-4">Page Not Found</p>
        <p class="text-gray-500 mt-2 mb-8">Sorry, we couldn't find the page you're looking for.</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                Go Home
            </a>
            <a href="/vat-calculator" class="px-6 py-3 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                VAT Calculator
            </a>
        </div>
    </div>
</body>
</html>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/errors/404.blade.php ENDPATH**/ ?>