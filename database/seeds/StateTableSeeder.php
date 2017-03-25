<?php

use App\Models\State;
use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $state;
    protected $query;

    public function __construct(State $state, City $city)
    {
    	$this->state = $state;
    }


    public function run()
    {
        $items = collect([

            'Lagos' => [
                ''
            ],
            'Abuja FCT',
            'Ogun',
            'Akwa Ibom',
            'Cross River',
            'Kaduna',
            'Katsina',
            'Anambra',
            'Benue',
            'Borno',
            'Imo',
            'Kano',
            'Kwara',
            'Niger',
            'Oyo',
            'Adamawa',
            'Delta',
            'Edo',
            'Jigawa',
            'Kebbi',
            'Kogi',
            'Osun',
            'Taraba',
            'Yobe',
            'Abia',
            'Bauchi',
            'Enugu',
            'Ondo',
            'Plateau',
            'Rivers',
            'Sokoto',
            'Bayelsa',
            'Ebonyi',
            'Ekiti',
            'Gombe',
            'Nasarawa',
            'Zamfara'
        ]);

        $items->each( function( $item, $key ) {


        	$this->query = State::create([
        		'name' => $key
        	]);

        	$cities = collect( $item );

        	$cities->each( function( $city, $key ) {
        		$this->query->city()->create([
        			'city'	=> $city
        		]);
        	});

        } );
        

    }
}
