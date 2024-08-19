<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UpdateImageUrlsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entries = DB::table('blogs')
            ->where('content', 'like', '%<img src="/storage/images/%')
            ->get();

        $pattern = '/<img src="\/storage\/images\/(\d+)\/([a-f0-9]+_thumb\.jpg)">/i';
        $replacement = '<img src="https://cbpw.nyc3.cdn.digitaloceanspaces.com/blog/$1/$2">';

        foreach ($entries as $entry) {
            $updatedContent = preg_replace($pattern, $replacement, $entry->content);

            // Update the entry in the database
            DB::table('blogs')
                ->where('id', $entry->id)
                ->update(['content' => $updatedContent]);
        }
    }
}
