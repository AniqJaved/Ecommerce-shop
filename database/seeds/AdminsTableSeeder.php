<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
            ['id'=>1,'name'=>'admin','type'=>'admin','mobile'=>'9800','email'=>'admin@admin.com',
                'password'=>'$2y$10$6lF75RFHov2oDTwtpRke4.bRdPtR5RQy0cUVzkeym6SvIu5QCxZrO','image'=>'','status'=>1],
        ];

        foreach ($adminRecords as $key => $record){
            \App\Admin::create($record);
        }
    }
}
