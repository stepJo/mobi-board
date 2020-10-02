<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        DB::table('tasks')->insert([
            't_title'       => 'UML Diagram',
            't_description' => 'Create the structure',
            'u_id'          => $user->u_id,
        ]);

        DB::table('tasks')->insert([
            't_title'       => 'API Development',
            't_description' => 'Create API',
            'u_id'          => $user->u_id,
        ]);
    }
}
