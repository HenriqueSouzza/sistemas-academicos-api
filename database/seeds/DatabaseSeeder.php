<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(StatusTicketsSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(SubMenuSeeder::class);
        $this->call(SistemasSeeder::class);
        $this->call(PapeisSeeder::class);
        $this->call(PapeisUsuarioSeeder::class);
        $this->call(PapeisMenuSeeder::class);
        // $this->call(PapeisSeeder::class);
    }
}
