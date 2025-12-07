<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'en' => 'Travel',
                'fr' => 'Voyage',
                'es' => 'Viaje',
            ],
            [
                'en' => 'Nature',
                'fr' => 'Nature',
                'es' => 'Naturaleza',
            ],
        ];

        foreach ($tags as $tagTranslations) {
            $tag = new Tag;
            $tag->setTranslations('name', $tagTranslations);
            $tag->save();
        }

        $this->command->info('Tags seeded successfully.');
    }
}
