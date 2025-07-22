<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\District;
use App\Helpers\BanglaTransliterator;

class TransliterateDistrictSlugs extends Command
{
    protected $signature = 'transliterate:district-slugs';
    protected $description = 'Convert existing Bangla district names to English slugs';

    public function handle()
    {
        $districts = District::all();

        foreach ($districts as $district) {
            $slug = BanglaTransliterator::transliterate($district->name);
            $district->slug = $slug;
            $district->save();
        }

        $this->info("All district slugs updated successfully.");
    }
}

