<?php

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect([
        		'Fashion',
        		'Beauty',
        		'Lifestyle',
        		'Technology',
        		'Marketing',
        		'Education',
        		'Design',
        		'Travel',
        		'DIY',
        		'Career',
        		'Automobile',
        		'Fitness and Health',
        		'Sports',
        		'Entertainment',
        		'Humor',
        		'Photography'
        	]);
        $categories->each(function($item, $key){
        	$check = Category::where('category', $item)->get();
        	if(!$check->count()){
        		Category::create([
        			'category'	=> $item,
        			'slug'		=> str_slug($item)
        		]);
        	}
        });
    }
}
