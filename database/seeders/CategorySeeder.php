<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
              "name" => "Buah",
            ],
            [
              "name" => "Bumbu Makanan",
            ],
            [
              "name" => "Makanan",
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
