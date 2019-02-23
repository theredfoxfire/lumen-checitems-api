<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Todo::class, 10)->make([
            'name' => 'Task No.' . str_random(5),
            'priority' => random_int(1, 2),
            'location' => null,
            'start_time' => date('H:i:s', mt_rand(1, time())),
            'completed' => random_int(0, 1),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'user_id' => 1
        ]);

        /*DB::table('todo')->insert([
            'name' => 'Task No.' . str_random(5),
            'priority' => random_int(1, 2),
            'start_time' => date('H:i:s', mt_rand(1, time())),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);*/
    }
}
