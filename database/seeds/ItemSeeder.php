<?php

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'name' => 'Tenda Dome 4 Orang',
                'description' => 'Tenda kapasitas 4 orang, waterproof double layer.',
                'price' => 50000,
                'stock' => 5,
                'image' => 'placeholder.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Carrier 60L',
                'description' => 'Tas gunung kapasitas 60 liter, backsystem nyaman.',
                'price' => 40000,
                'stock' => 4,
                'image' => 'placeholder.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sleeping Bag Polar',
                'description' => 'Kantong tidur bahan polar hangat model mummy.',
                'price' => 15000,
                'stock' => 10,
                'image' => 'placeholder.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kompor Portable',
                'description' => 'Kompor mini windproof anti badai.',
                'price' => 20000,
                'stock' => 6,
                'image' => 'placeholder.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cooking Set DS-308',
                'description' => 'Alat masak lengkap bahan aluminium anodized.',
                'price' => 25000,
                'stock' => 5,
                'image' => 'placeholder.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tenda Dome 6 Orang',
                'description' => 'Tenda kapasitas 6 orang, waterproof double layer.',
                'price' => 60000,
                'stock' => 5,
                'image' => 'placeholder.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Carrier 100L',
                'description' => 'Tas gunung kapasitas 100 liter, backsystem nyaman.',
                'price' => 50000,
                'stock' => 4,
                'image' => 'placeholder.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        \DB::table('items')->insert($items);
    }
}
