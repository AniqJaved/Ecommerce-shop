<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brandsRecords = [
            ['id' => 1, 'name' => 'Nike', 'status' => 1],
            ['id' => 2, 'name' => 'Adidas', 'status' => 1],
            ['id' => 3, 'name' => 'Gap', 'status' => 1],
        ];

        foreach ($brandsRecords as $key => $record) {
            \App\Brand::create($record);
        }
    }
}
