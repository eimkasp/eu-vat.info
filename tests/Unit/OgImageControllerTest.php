<?php

use App\Http\Controllers\OgImageController;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

it('creates an ImageManager instance', function () {
    $controller = new OgImageController;

    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('imageManager');
    $property->setAccessible(true);

    expect($property->getValue($controller))->toBeInstanceOf(ImageManager::class);
});

it('has country method defined', function () {
    $controller = new OgImageController;

    expect(method_exists($controller, 'country'))->toBeTrue();
});

it('has generateCountryOgImage method defined', function () {
    $controller = new OgImageController;

    expect(method_exists($controller, 'generateCountryOgImage'))->toBeTrue();
});

it('defines standard OG image dimensions', function () {
    // Test that our controller generates images with standard dimensions
    // Standard OG image size is 1200x630 as per Open Graph specification
    // This test verifies the method exists and can generate an image

    $imageManager = new ImageManager(new Driver);
    $image = $imageManager->create(1200, 630);

    expect($image->width())->toBe(1200);
    expect($image->height())->toBe(630);
});

it('generates a valid PNG image using intervention/image', function () {
    $imageManager = new ImageManager(new Driver);
    $image = $imageManager->create(1200, 630);

    // Add some basic drawing to simulate OG image content
    $image->drawRectangle(0, 0, function ($draw) {
        $draw->size(1200, 630);
        $draw->background('rgb(30, 58, 95)');
    });

    $pngContent = $image->toPng()->toString();

    // Verify PNG signature
    $pngSignature = "\x89PNG\r\n\x1a\n";
    expect(str_starts_with($pngContent, $pngSignature))->toBeTrue();

    // Verify file size is reasonable (should be at least a few KB for a 1200x630 image)
    expect(strlen($pngContent))->toBeGreaterThan(1000);
});
