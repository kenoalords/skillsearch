<?php
use App\Models\Skills;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class SkillsTableSeederLatest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = collect([
            'Architecture',
            'DJ (Disk Jockey)',
            'Cocktails',
            'Mobile App Design',
            'Mobile App Development',
            'Art Painting',
            'Shoe Making',
            'Bead Making',
            'Gele Stylist',
            'Cinematography',
            'Motion Graphics',
            'Ankara Craft',
            'Cake Baking',
            'Small Chops &amp; Snacks',
            'Network Engineer',
            'Fashion Stylist',
            'Fashion Model',
            'Leatherworks',
            'Woodwork',
            'Sculptor',
            'Furniture Design'
        ]);

        $skills->each(function($item, $key)
        {
        	Skills::create([
        		'skill'	=> $item
        	]);
        });
    }
}
