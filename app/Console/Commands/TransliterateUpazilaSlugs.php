<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Upazila;
use App\Helpers\BanglaTransliterator;

class TransliterateUpazilaSlugs extends Command
{
    protected $signature = 'transliterate:upazila-slugs';
    protected $description = 'Convert existing Bangla upazila names to English slugs';

    public function handle()
    {
        $upazilas = Upazila::all();

        foreach ($upazilas as $upazila) {
            $slug = BanglaTransliterator::transliterate($upazila->name);
            $upazila->slug = $slug;
            $upazila->save();
        }

        $this->info("All upazila slugs updated successfully.");
    }
}
