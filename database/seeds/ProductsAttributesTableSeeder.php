<?php

use Illuminate\Database\Seeder;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productAttributeSeeder = [
            ['id'=>1,'product_id'=> 1,'size'=>'small','price'=>1200,'stock'=>10,'sku'=>'BT001-S',
                'status'=>1],
            ['id'=>2,'product_id'=> 1,'size'=>'medium','price'=>1250,'stock'=>20,'sku'=>'BT001-M',
                'status'=>1],
            ['id'=>3,'product_id'=> 1,'size'=>'small','price'=>1300,'stock'=>30,'sku'=>'BT001-L',
                'status'=>1]
        ];
        foreach ($productAttributeSeeder as $key => $record) {
            \App\ProductsAttribute::create($record);
        }
    }

}
