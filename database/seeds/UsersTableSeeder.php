<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Hashing\BcryptHasher;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new App\Models\Users();
        $user->username   = 'donni';
        $user->email      = 'donnigundala@gmail.com';
        $user->password   = (new BcryptHasher())->make('password');
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');

        if ($user->save()) {
            for ($i=0; $i <= 10; $i++) {
                $todo = new \App\Models\Todo();
                $todo->name = 'Task No.' . mt_rand(10, 99);
                $todo->priority = mt_rand(10, 99);
                $todo->start_time = date('H:i:s', mt_rand(1, time()));
                $todo->completed = random_int(0, 1);
                $todo->created_at = date('Y-m-d H:i:s');
                $todo->updated_at = date('Y-m-d H:i:s');
                $todo->user_id = $user->id;
                $todo->save();
            }
        }
    }
}
