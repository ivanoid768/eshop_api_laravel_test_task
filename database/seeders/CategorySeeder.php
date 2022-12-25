<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->count(4)->create();

        $parent_categories = Category::all();

        foreach ($parent_categories as $key => $parent_category) {
            $parent_id = $parent_category->id;

            $max = 4;
            for ($c = 1; $c <= $max; $c++) {
                Category::factory()->withParent($parent_id)->create();
            }
        }

        $parent_categories = Category::whereNot('parent_id', null)->get();

        foreach ($parent_categories as $key => $parent_category) {
            $parent_id = $parent_category->id;

            $max = 4;
            for ($c = 1; $c <= $max; $c++) {
                Category::factory()->withParent($parent_id)->create();
            }
        }
    }
}