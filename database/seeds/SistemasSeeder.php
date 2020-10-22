<?php

use Illuminate\Database\Seeder;
use App\Models\Sistemas;

class SistemasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dbo.SISTEMAS')->truncate();

        Sistemas::create([
            'nome_sistema'  => 'canal direto',
            'ativo'         => 1,
        ]);
    }
}
