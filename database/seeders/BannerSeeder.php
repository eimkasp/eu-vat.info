<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fingida Banner (Sidebar)
        Banner::updateOrCreate(
            ['title' => 'Fingida Accounting'],
            [
                'link_url' => 'https://fingida.lt/',
                'position' => 'sidebar',
                'content' => '
                    <div style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); color: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); text-align: center; transition: transform 0.3s;" onmouseover="this.style.transform=\'scale(1.02)\'" onmouseout="this.style.transform=\'scale(1)\'">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">Accounting and Tax Support</h3>
                        <p style="color: #dbeafe; margin-bottom: 1rem; font-size: 0.875rem;">Professional accounting services for your business.</p>
                        <div style="display: inline-block; background-color: white; color: #1d4ed8; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 700; font-size: 0.875rem;">
                            Visit Fingida.lt
                        </div>
                    </div>
                ',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // BusinessPress Banner (Country Sidebar)
        Banner::updateOrCreate(
            ['title' => 'BusinessPress CMS'],
            [
                'link_url' => '#', // Replace with actual URL
                'position' => 'country_sidebar',
                'content' => '
                    <div style="background: linear-gradient(135deg, #0f172a 0%, #334155 100%); color: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); text-align: center; transition: transform 0.3s;" onmouseover="this.style.transform=\'scale(1.02)\'" onmouseout="this.style.transform=\'scale(1)\'">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">BusinessPress</h3>
                        <p style="color: #cbd5e1; margin-bottom: 1rem; font-size: 0.875rem;">The Ultimate CMS & CRM for Business.</p>
                        <div style="display: inline-block; background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 700; font-size: 0.875rem;">
                            Get Started
                        </div>
                    </div>
                ',
                'is_active' => true,
                'sort_order' => 2,
            ]
        );
    }
}
