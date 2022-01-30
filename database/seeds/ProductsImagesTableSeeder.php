<?php

use Illuminate\Database\Seeder;

class ProductsImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productImages =[
            ['id'=> 1,'product_id'=>3,'image'=>'black casual t shirt.jpg-41919.jpg','status'=>1],

        ];

        foreach ($productImages as $key => $record) {
            \App\ProductsImage::create($record);
        }
    }
}
