<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::whereNot('parent_id', null)->get();

        foreach ($categories as $key => $category) {
            $category_id = $category->id;

            $max = 5;
            for ($c = 1; $c <= $max; $c++) {
                Product::factory()->withCategory($category_id)->create();
            }
        }
    }
}