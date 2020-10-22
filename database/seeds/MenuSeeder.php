<?php

use Illuminate\Database\Seeder;
use App\Models\CanalDireto\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cd.MENUS')->truncate();

        Menu::create([
            'nome'  => 'Meus Tickets',
            'link'  => '#',
            'icon'  => 'fa fa-address-card',
            'ordem' => 1
        ]);

        Menu::create([
            'nome'  => 'Tickets meu setor',
            'link'  => '#',
            'icon'  => 'fa fa-building',
            'ordem' => 2
        ]);

        Menu::create([
            'nome'  => 'Padrões de acessos',
            'link'  => '#',
            'icon'  => 'fa fa-cogs',
            'ordem' => 3
        ]);

    }
}
