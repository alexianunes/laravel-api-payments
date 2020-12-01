<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [

            [
                'name' => 'Alexia',
                'email' => 'ale@gmail.com',
                'password' => Hash::make('123456'),
                'document' => '07465906520',
                'balance_wallet' => '500.00',
                'type' => 1,
            ],

            [
                'name' => 'Teste Lojista',
                'email' => 'teste@gmail.com',
                'password' => Hash::make('123456'),
                'document' => '70202179000145',
                'balance_wallet' => '200.00',
                'type' => 2,
            ],

        ];

        DB::table('users')->insert($users);
    }
}
