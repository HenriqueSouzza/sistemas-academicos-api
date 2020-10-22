<?php

use Illuminate\Database\Seeder;
use App\Models\CanalDireto\StatusTicket;

class StatusTicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusTicket::truncate();

        StatusTicket::create([
                'nome'          => 'Em Aberto',
                'descricao'     => 'Todos os tickets em abertos do setor, porém sem designação',
                'ordem'         => 1,
        ]);

        StatusTicket::create([
                'nome'          => 'Em andamento',
                'descricao'     => 'Todos os tickets em aberto que possui um atendente; obs.: Se o solicitante reabrir o chamando ele terá esse mesmo status',
                'ordem'         => 2,
        ]);

        StatusTicket::create([
                'nome'          => 'Pendente',
                'descricao'     => 'Todos os tickets que houve uma interação, porém precisa de uma resposta do interlocutor; (Exemplo, para efetuar a demanda, é preciso o uma resposta de outro setor)',
                'ordem'         => 3,
        ]);

        StatusTicket::create([
                'nome'          => 'Resolvido',
                'descricao'     => 'Todos os tickets que foram fechados pelo atendente',
                'ordem'         => 4,
        ]);
        
        StatusTicket::create([
                'nome'           => 'Cancelado',
                'descricao'      => 'Todos os tickets que foram fechados pelo solicitante',
                'ordem'          => 5,
        ]);

    }
}
