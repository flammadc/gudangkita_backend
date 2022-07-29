<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
              "name" => "Anggur",
              "category_id" => 1,
              "stock" => 40,
              "price" => "20000"
            ],
            [
              "name" => "Bawang Merah",
              "category_id" => 2,
              "stock" => 50,
              "price" => "40000"
            ],
            [
              "name" => "Ayam Fillet",
              "category_id" => 3,
              "stock" => 20,
              "price" => "35000"
            ],
            [
              "name" => "Lada Hitam",
              "category_id" => 2,
              "stock" => 100,
              "price" => "10000"
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
