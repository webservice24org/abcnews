<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Page;

class PagesTableSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['title' => 'About Us', 'slug' => 'about-us', 'description' => 'About Us page content here.', 'page_thumbnail' => null],
            ['title' => 'Contact Us', 'slug' => 'contact-us', 'description' => 'Contact Us page content here.', 'page_thumbnail' => null],
            ['title' => 'Privacy & Policy', 'slug' => 'privacy-policy', 'description' => 'Privacy & Policy page content here.', 'page_thumbnail' => null],
            ['title' => 'Our Staff', 'slug' => 'our-staff', 'description' => 'Our Staff page content here.', 'page_thumbnail' => null],
            ['title' => 'Ethics & Guidelines', 'slug' => 'ethics-guidelines', 'description' => 'Ethics & Guidelines page content here.', 'page_thumbnail' => null],
            ['title' => 'How We Make Money', 'slug' => 'how-we-make-money', 'description' => 'How We Make Money page content here.', 'page_thumbnail' => null],
            ['title' => 'ABS.News Help & FAQs ', 'slug' => 'help-faqs', 'description' => 'ABS.News Help & FAQs .', 'page_thumbnail' => null],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(
                ['slug' => $page['slug']], // avoid duplicates
                $page
            );
        }
    }
}