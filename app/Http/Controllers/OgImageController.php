<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class OgImageController extends Controller
{
    protected ImageManager $imageManager;

    /**
     * Path to the regular font file
     */
    protected string $fontRegular;

    /**
     * Path to the bold font file
     */
    protected string $fontBold;

    /**
     * List of possible font paths to check (in order of preference)
     */
    protected array $fontPaths = [
        'regular' => [
            '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
            '/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf',
            '/usr/share/fonts/truetype/freefont/FreeSans.ttf',
            '/usr/share/fonts/truetype/lato/Lato-Regular.ttf',
        ],
        'bold' => [
            '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
            '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf',
            '/usr/share/fonts/truetype/freefont/FreeSansBold.ttf',
            '/usr/share/fonts/truetype/lato/Lato-Bold.ttf',
        ],
    ];

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver);
        $this->initializeFonts();
    }

    /**
     * Initialize fonts by finding available font files
     */
    protected function initializeFonts(): void
    {
        $this->fontRegular = $this->findAvailableFont($this->fontPaths['regular']);
        $this->fontBold = $this->findAvailableFont($this->fontPaths['bold']) ?? $this->fontRegular;
    }

    /**
     * Find the first available font from a list of paths
     */
    protected function findAvailableFont(array $fontPaths): ?string
    {
        foreach ($fontPaths as $fontPath) {
            if (file_exists($fontPath)) {
                return $fontPath;
            }
        }

        return null;
    }

    /**
     * Generate dynamic OG image for a country page
     */
    public function country(string $slug)
    {
        $country = Country::where('slug', $slug)->firstOrFail();

        // Check if fonts are available
        if (! $this->fontRegular) {
            return $this->generateFallbackImage($country);
        }

        // Check if image already exists
        $imagePath = "og-images/country-{$slug}.png";

        if (Storage::disk('public')->exists($imagePath)) {
            $lastModified = Storage::disk('public')->lastModified($imagePath);
            if ($lastModified >= $country->updated_at->timestamp) {
                return response()->file(Storage::disk('public')->path($imagePath), [
                    'Content-Type' => 'image/png',
                    'Cache-Control' => 'public, max-age=86400',
                ]);
            }
        }

        // Generate new image
        $imageContent = $this->generateCountryOgImage($country);

        // Ensure directory exists
        Storage::disk('public')->makeDirectory('og-images');

        // Save to storage
        Storage::disk('public')->put($imagePath, $imageContent);

        return response($imageContent, 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    /**
     * Generate a simple fallback image when fonts are not available
     */
    protected function generateFallbackImage(Country $country): \Illuminate\Http\Response
    {
        $width = 1200;
        $height = 630;

        $image = $this->imageManager->create($width, $height);
        $this->drawGradientBackground($image, $width, $height);

        return response($image->toPng()->toString(), 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    /**
     * Generate the OG image for a country
     */
    protected function generateCountryOgImage(Country $country): string
    {
        // Create a 1200x630 image (standard OG image size)
        $width = 1200;
        $height = 630;

        // Create image with gradient background
        $image = $this->imageManager->create($width, $height);

        // Draw gradient background (blue gradient)
        $this->drawGradientBackground($image, $width, $height);

        // Draw decorative elements
        $this->drawDecorativeElements($image, $width, $height);

        // Add country flag emoji/indicator
        $this->drawFlagIndicator($image, $country);

        // Add title text
        $this->drawTitle($image, $country);

        // Add VAT rate info
        $this->drawVatInfo($image, $country);

        // Add branding
        $this->drawBranding($image, $width, $height);

        return $image->toPng()->toString();
    }

    /**
     * Draw gradient background
     */
    protected function drawGradientBackground($image, int $width, int $height): void
    {
        // Create a modern gradient from dark blue to lighter blue
        $steps = 100;
        for ($i = 0; $i < $steps; $i++) {
            $ratio = $i / $steps;
            // From #1e3a5f to #3b82f6
            $r = (int) (30 + (59 - 30) * $ratio);
            $g = (int) (58 + (130 - 58) * $ratio);
            $b = (int) (95 + (246 - 95) * $ratio);

            $y = (int) ($height * $i / $steps);
            $rectHeight = (int) ($height / $steps) + 1;

            $image->drawRectangle(0, $y, function ($draw) use ($width, $rectHeight, $r, $g, $b) {
                $draw->size($width, $rectHeight);
                $draw->background("rgb({$r}, {$g}, {$b})");
            });
        }
    }

    /**
     * Draw decorative elements
     */
    protected function drawDecorativeElements($image, int $width, int $height): void
    {
        // Add subtle decorative circles
        $image->drawEllipse($width - 100, 100, function ($draw) {
            $draw->size(300, 300);
            $draw->background('rgba(255, 255, 255, 0.05)');
        });

        $image->drawEllipse(100, $height - 100, function ($draw) {
            $draw->size(200, 200);
            $draw->background('rgba(255, 255, 255, 0.03)');
        });
    }

    /**
     * Draw flag indicator
     */
    protected function drawFlagIndicator($image, Country $country): void
    {
        // Draw a rectangle with EU blue and country code
        $image->drawRectangle(80, 140, function ($draw) {
            $draw->size(120, 60);
            $draw->background('rgba(255, 255, 255, 0.15)');
            $draw->border('rgba(255, 255, 255, 0.3)', 2);
        });

        // Add ISO code text
        $image->text($country->iso_code, 140, 180, function ($font) {
            $font->filename($this->fontBold);
            $font->size(28);
            $font->color('white');
            $font->align('center');
            $font->valign('middle');
        });
    }

    /**
     * Draw title text
     */
    protected function drawTitle($image, Country $country): void
    {
        // Main title - Country name
        $image->text($country->name, 80, 280, function ($font) {
            $font->filename($this->fontBold);
            $font->size(56);
            $font->color('white');
            $font->align('left');
            $font->valign('top');
        });

        // Subtitle
        $image->text('VAT Rates & Information', 80, 350, function ($font) {
            $font->filename($this->fontRegular);
            $font->size(28);
            $font->color('rgba(255, 255, 255, 0.8)');
            $font->align('left');
            $font->valign('top');
        });
    }

    /**
     * Draw VAT information
     */
    protected function drawVatInfo($image, Country $country): void
    {
        // Standard rate box
        $image->drawRectangle(80, 420, function ($draw) {
            $draw->size(250, 130);
            $draw->background('rgba(255, 255, 255, 0.15)');
            $draw->border('rgba(255, 255, 255, 0.3)', 2);
        });

        $image->text('Standard Rate', 205, 455, function ($font) {
            $font->filename($this->fontRegular);
            $font->size(18);
            $font->color('rgba(255, 255, 255, 0.8)');
            $font->align('center');
        });

        $image->text($country->standard_rate.'%', 205, 505, function ($font) {
            $font->filename($this->fontBold);
            $font->size(42);
            $font->color('white');
            $font->align('center');
        });

        // Reduced rate box (if exists)
        if ($country->reduced_rate) {
            $image->drawRectangle(350, 420, function ($draw) {
                $draw->size(250, 130);
                $draw->background('rgba(255, 255, 255, 0.1)');
                $draw->border('rgba(255, 255, 255, 0.2)', 2);
            });

            $image->text('Reduced Rate', 475, 455, function ($font) {
                $font->filename($this->fontRegular);
                $font->size(18);
                $font->color('rgba(255, 255, 255, 0.7)');
                $font->align('center');
            });

            $image->text($country->reduced_rate.'%', 475, 505, function ($font) {
                $font->filename($this->fontBold);
                $font->size(42);
                $font->color('rgba(255, 255, 255, 0.9)');
                $font->align('center');
            });
        }

        // EU Member badge
        $image->drawRectangle(900, 450, function ($draw) {
            $draw->size(200, 60);
            $draw->background('rgba(16, 185, 129, 0.8)');
            $draw->border('rgba(16, 185, 129, 1)', 2);
        });

        $image->text('EU Member', 1000, 488, function ($font) {
            $font->filename($this->fontBold);
            $font->size(20);
            $font->color('white');
            $font->align('center');
            $font->valign('middle');
        });
    }

    /**
     * Draw branding elements
     */
    protected function drawBranding($image, int $width, int $height): void
    {
        // Bottom bar
        $image->drawRectangle(0, $height - 60, function ($draw) use ($width) {
            $draw->size($width, 60);
            $draw->background('rgba(0, 0, 0, 0.2)');
        });

        // Site name
        $image->text('eu-vat.info', $width - 100, $height - 30, function ($font) {
            $font->filename($this->fontBold);
            $font->size(22);
            $font->color('rgba(255, 255, 255, 0.9)');
            $font->align('right');
            $font->valign('middle');
        });

        // Additional info
        $image->text('Current VAT Rates for EU Countries', 80, $height - 30, function ($font) {
            $font->filename($this->fontRegular);
            $font->size(18);
            $font->color('rgba(255, 255, 255, 0.6)');
            $font->align('left');
            $font->valign('middle');
        });
    }
}
