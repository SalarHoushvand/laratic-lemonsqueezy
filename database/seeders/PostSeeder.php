<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\Tags\Tag;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = public_path('posts.csv');

        if (! File::exists($csvFile)) {
            $this->command->warn('Posts CSV file not found at: '.$csvFile);

            return;
        }

        $file = fopen($csvFile, 'r');
        $headers = fgetcsv($file);

        $tags = Tag::all();

        while (($row = fgetcsv($file)) !== false) {
            $data = array_combine($headers, $row);

            $post = Post::create([
                'reference_number' => $data['reference_number'],
                'title' => $data['title'],
                'description' => $data['description'],
                'slug' => $data['slug'],
                'image_url' => $data['image_url'],
                'author' => $data['author'],
                'content' => $data['content'],
                'is_promoted' => (bool) $data['is_promoted'],
                'is_active' => (bool) $data['is_active'],
                'language' => $data['language'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]);

            // Randomly assign 1-2 tags to each post
            if ($tags->count() > 0) {
                $numberOfTags = rand(1, 2);
                $randomTags = $tags->random(min($numberOfTags, $tags->count()));
                $post->attachTags($randomTags);
            }
        }

        fclose($file);

        $this->command->info('Posts seeded successfully from CSV.');
    }
}
