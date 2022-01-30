<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords =[
            ['id'=> 1,'category_id'=>4,'section_id'=>1,'product_name'=>'Blue Casual T-shirts','product_code'=>'BT001','product_color'=>'Blue',
                'product_price'=>1500,'product_discount'=>10,'product_weight'=>200,'product_video'=>'','main_image'=>'',
                'description'=>'Test product','wash_care'=>'','fabric'=>'','pattern'=>'','sleeve'=>'','fit'=>'','occasion'=>'','meta_title'=>'',
                'meta_description'=>'','meta_keywords'=>'','is_featured'=>'No','status'=>1],
            ['id'=> 2, 'category_id'=>4 ,'section_id'=>1,'product_name'=>'Red Casual T-shirts','product_code'=>'R001','product_color'=>'Red',
                'product_price'=>2000,'product_discount'=>10,'product_weight'=>200,'product_video'=>'','main_image'=>'',
                'description'=>'Test product','wash_care'=>'','fabric'=>'','pattern'=>'','sleeve'=>'','fit'=>'','occasion'=>'','meta_title'=>'',
                'meta_description'=>'','meta_keywords'=>'','is_featured'=>'Yes','status'=>1]
        ];

        foreach ($productRecords as $key => $record) {
            \App\Product::create($record);
        }
    }
}
