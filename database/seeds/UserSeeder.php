<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dbo.USERS')->truncate();

        User::create([
            'name' => 'Henrique Pereira de Souza',
            'email' => 'henrique.souza@iesb.br',
            'password' => Hash::make('Henrique@1997!'),
        ]);
    }
}
