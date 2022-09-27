<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use App\Models\Group;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Model::unguard();

        $this->call(GroupsTableSeeder::class);

        Model::reguard();
    }
}

class GroupsTableSeeder extends Seeder
{
    public function run()
    {
        Group::create(
            [
                'id' => 1, //念の為
                'name' => 'グループなし',
                'administrator_userid' => 0, //0は誰もいない
            ]
        );
    }
}
