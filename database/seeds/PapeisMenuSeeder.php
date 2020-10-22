<?php

use Illuminate\Database\Seeder;
use App\Models\CanalDireto\PapeisMenu;

class PapeisMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('cd.PAPEIS_MENUS')->truncate();

        for($i = 1; $i <= 13; $i++):
                
            PapeisMenu::create([
                'fk_submenu'  => $i,
                'fk_papeis'  => 4,
            ]);
            
        endfor;

    }
}
