<?php

use Illuminate\Database\Seeder;
use App\Models\CanalDireto\SubMenu;

class SubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cd.SUB_MENUS')->truncate();

        SubMenu::create([
            'id_menu'  => 1,
            'nome'  => 'Novo Ticket',
            'link'  => '/meus-tickets/novo',
            'icon'  => 'fa fa-edit',
            'ordem' => 1,
            'ativo' => 1
        ]);

        SubMenu::create([
            'id_menu'  => 1,
            'nome'  => 'Abertos',
            'link'  => '/meus-tickets/abertos',
            'icon'  => 'fa fa-envelope-open',
            'ordem' => 2,
            'ativo' => 1
        ]);

        SubMenu::create([
            'id_menu'  => 1,
            'nome'  => 'Fechados',
            'link'  => '/meus-tickets/fechados',
            'icon'  => 'fa fa-envelope',
            'ordem' => 3,
            'ativo' => 1
        ]);

        SubMenu::create([
            'id_menu'  => 2,
            'nome'  => 'Para meu setor',
            'link'  => '/tickets-setor/para-meu-setor',
            'icon'  => 'fa fa-object-group',
            'ordem' => 1,
            'ativo' => 1
        ]);

        SubMenu::create([
            'id_menu'  => 2,
            'nome'  => 'Meus tickets',
            'link'  => '/tickets-setor/meus-tickets',
            'icon'  => 'fa fa-address-book',
            'ordem' => 2,
            'ativo' => 1
        ]);

        SubMenu::create([
            'id_menu'  => 3,
            'nome'  => 'Usuários',
            'link'  => '/padroes-acessos/usuarios',
            'icon'  => 'fa fa-users',
            'ordem' => 1,
            'ativo' => 1
        ]);

        SubMenu::create([
            'id_menu'  => 3,
            'nome'  => 'Papéis',
            'link'  => '/padroes-acessos/papeis',
            'icon'  => 'fa fa-list-ul',
            'ordem' => 2,
            'ativo' => 1
        ]);

        SubMenu::create([
            'id_menu'  => 3,
            'nome'  => 'Permissões',
            'link'  => '/padroes-acessos/permissoes',
            'icon'  => 'fa fa-list-ul',
            'ordem' => 3,
            'ativo' => 1
        ]);
        
        SubMenu::create([
            'id_menu'  => 3,
            'nome'  => 'Setor',
            'link'  => '/padroes-acessos/setor',
            'icon'  => 'fa fa-sitemap',
            'ordem' => 4,
            'ativo' => 1
        ]);

        SubMenu::create([
            'id_menu'  => 3,
            'nome'  => 'Status Ticket',
            'link'  => '/padroes-acessos/status-ticket',
            'icon'  => 'fa fa-list-ul',
            'ordem' => 5,
            'ativo' => 1
        ]);

        SubMenu::create([
            'id_menu'  => 3,
            'nome'  => 'Formulários',
            'link'  => '/padroes-acessos/formularios',
            'icon'  => 'fa fa-list-ul',
            'ordem' => 6,
            'ativo' => 1
        ]);

        SubMenu::create([
            'id_menu'  => 3,
            'nome'  => 'Campos Formulários',
            'link'  => '/padroes-acessos/campos-formularios',
            'icon'  => 'fa fa-list-ul',
            'ordem' => 7,
            'ativo' => 1
        ]);

        SubMenu::create([
            'id_menu'  => 3,
            'nome'  => 'Menu',
            'link'  => '/padroes-acessos/menus',
            'icon'  => 'fa fa-list-ul',
            'ordem' => 8,
            'ativo' => 1
        ]);
    }
}
