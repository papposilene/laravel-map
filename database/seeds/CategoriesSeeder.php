<?php

use App\Categories;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();
        Categories::create([
                'uuid' => Str::uuid(),
                'name' => 'Restaurants',
                'description' => 'Toutes les bonnes adresses concernant la nourriture : restaurants, boulangeries, street, junk et autres snack food.',
                'icon' => 'utensils',
                'color' => 'green'
			]);
        Categories::create([
                'uuid' => Str::uuid(),
                'name' => 'Bars',
                'description' => 'Toutes les bonnes adresses concernant la boisson : bars, cafés, etc.',
                'icon' => 'glass-cheers',
                'color' => 'blue'
			]);
		Categories::create([
                'uuid' => Str::uuid(),
                'name' => 'Activity',
                'description' => 'Toutes les bonnes adresses d’activités : musées et autres activités touristiques.',
                'icon' => 'university',
                'color' => 'red'
			]);
		Categories::create([
                'uuid' => Str::uuid(),
                'name' => 'Shop',
                'description' => 'Toutes les bonnes adresses pour le shopping.',
                'icon' => 'shopping-bag',
                'color' => 'cadetblue'
			]);
        Categories::create([
                'uuid' => Str::uuid(),
                'name' => 'Crafts',
                'description' => 'Toutes les bonnes adresses d’artisanat et autres produits locaux.',
                'icon' => 'industry',
                'color' => 'beige'
			]);
		Categories::create([
                'uuid' => Str::uuid(),
                'name' => 'Hotel',
                'description' => 'Toutes les bonnes adresses où dormir, telles que hôtel, bed & breakfast ou autres locations.',
                'icon' => 'bed',
                'color' => 'black'
			]);
		Categories::create([
                'uuid' => Str::uuid(),
                'name' => 'Other',
                'description' => 'Toutes les adresses ne rentrant pas dans les catégories précédentes.',
                'icon' => 'random',
                'color' => 'pink'
			]);
    }
}
