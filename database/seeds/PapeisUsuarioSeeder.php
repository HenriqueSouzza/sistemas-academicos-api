<?php

use Illuminate\Database\Seeder;
use App\Models\PapeisUsuario;

class PapeisUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('dbo.PAPEIS_USUARIOS')->truncate();

        PapeisUsuario::create([
            'fk_user'    => 1,
            'fk_papeis'  => 4,
        ]);
        
    }
}
