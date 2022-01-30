<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryRecords = [
            ['id' => 1, 'parent_id' => 0,'section_id'=> 1,'category_name'=>'T-Shirts','category_image'=>'','category_discount'=>0,'description'=>'','url'=>'t-shirts','meta_title'=>'','meta_keywords'=>'','meta_description'=>'','status' => 1],
            ['id' => 2, 'parent_id' => 1,'section_id'=> 1,'category_name'=>'Casual T-Shirts','category_image'=>'','category_discount'=>0,'description'=>'','url'=>'casual-t-shirts','meta_title'=>'','meta_keywords'=>'','meta_description'=>'','status' => 1],
        ];

        foreach ($categoryRecords as $key => $record) {
            \App\Category::create($record);
        }
    }
}
