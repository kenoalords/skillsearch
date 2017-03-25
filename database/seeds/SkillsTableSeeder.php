<?php

use App\Models\Skills;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = collect([
        	'Music Artist',
        	'Makeup Artist',
        	'Graphics Designer',
        	'Website Developer',
        	'Catering',
        	'Event Services',
        	'Fashion Designer',
            'Content Writers',
            'Social Media Consultants',
            'Copywriters',
            'SEO Experts',
            'Video Production',
            'Photography',
            '3D Animation',
            'Audio Production',
            'Data Entry',
            'Legal Practitioner',
            'Project Manager',
            'Researcher',
            'Advertising',
            'Marketing',
            'Film Making',
            'Tattoo Design',
            'Voice Over',
            'Interior Design',
            'Printing',
            'Software Engineer',
            'Branding',
            'Sales Representative',
            'Hair Stylist',
            'Auditor',
            'Home Services',
            'Auto Services',
        ]);

        $skills->each(function($item, $key)
        {
        	Skills::create([
        		'skill'	=> $item
        	]);
        });

    }
}
