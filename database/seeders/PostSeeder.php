<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = new Post();
        $post->user_id = 1;
        $post->title = 'La Calita';
        $post->description = 'Between the rocks and a cliff, a spit of sand breaks through to form the Playa de La Calita. Surrounded by single family homes belonging to the Vistahermosa housing development, this stretch of low coast, between reddish cliffs, is mainly frequented by residents of the area. Toward the southeast, there are other smaller coves and sandy areas, equally deserving as places to swim and visit.';
		$post->publication_date = '2021-06-02';
		$post->image = '1625320508project-8.jpg';
		$post->save();
		
		$post = new Post();
        $post->user_id = 2;
        $post->title = 'jellyfish';
        $post->description = 'Cnidarians are marine animals which include jellyfish and other stinging
		organisms. They are equipped with very specialized cells called cnidocytes, mainly concentrated along their tentacles, which are able to inject a
		protein-based mixture containing venom through a barbed filament for defense purposes and for capturing prey. The mechanism regulating filament
		eversion is among the quickest and most effective biological processes in
		nature: it takes less than a millionth of second and inflicts a force of 70 tons
		per square centimetre at the point of impact';
		$post->publication_date = '2021-06-02';
		$post->image = 'medusa.jpg';
		
	    $post->save();
    }
}
