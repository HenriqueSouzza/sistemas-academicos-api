<?php

use Illuminate\Database\Seeder;
use App\Models\Papeis;

class PapeisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dbo.PAPEIS')->truncate();

        Papeis::create([
            'papel'         => 'Funcionário',
            'descricao'     => 'Papel responsável pelos funcionários do iesb',
            'sistema'       => 1,
        ]);

        Papeis::create([
            'papel'         => 'Aluno',
            'descricao'     => 'Papel responsável pelos Alunos do iesb',
            'sistema'       => 1,
        ]);

        Papeis::create([
            'papel'         => 'Docente',
            'descricao'     => 'Papel responsável pelos Docentes do iesb',
            'sistema'       => 1,
        ]);

        Papeis::create([
            'papel'         => 'Administrador',
            'descricao'     => 'administrador do sistema',
            'sistema'       => 1,
        ]);
    }
}
