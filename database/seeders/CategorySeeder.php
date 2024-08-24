<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            [
                'name' => 'Bedroom',
                'image' => 'bedroom.jpg'
            ],
            [
                'name' => 'Mattrass',
                'image' => 'Mattrass.jpg'
            ],
            [
                'name' => 'Outdoor',
                'image' => 'outdoor.jpg'
            ],
            [
                'name' => 'Sofa',
                'image' => 'sofa.jpg'
            ],
            [
                'name' => 'Living Room',
                'image' => 'living-room.jpg'
            ],
            [
                'name' => 'Kitchen',
                'image' => 'kitchen.jpg'
            ],
        ];

        foreach ($data as $key => $value) {
            # code...
            Category::create($value);
        }
    }
}
