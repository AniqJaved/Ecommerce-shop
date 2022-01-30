<?php

use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannerRecords =[
            ['id'=> 1,'image'=>'banner1.png','link'=>'','title'=>'Black jacket','alt'=>'Black jacket','status'=>1],
            ['id'=> 2,'image'=>'banner2.png','link'=>'','title'=>'Half Sleeve T-Shirt','alt'=>'Black jacket','status'=>1],
            ['id'=> 3,'image'=>'banner3.png','link'=>'','title'=>'Full Sleeve T-Shirt','alt'=>'Black jacket','status'=>1],


        ];

        foreach ($bannerRecords as $key => $record) {
            \App\Banner::create($record);
        }
    }
}
