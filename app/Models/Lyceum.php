<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Lyceum extends Model
{
    protected $connection = 'lyceum';

    /**
     * 
     */
    public function loginAluno($aluno, $senha) {

        $sql = "SELECT  A.ALUNO                     LOGIN,
                        DBO.DECRYPT(P.SENHA_TAC)    SENHA, 
                        P.NOME_COMPL                NOME
                FROM    LY_ALUNO    A 
                JOIN    LY_PESSOA   P ON P.PESSOA = A.PESSOA
                WHERE   A.ALUNO = :aluno
                AND     DBO.DECRYPT(P.SENHA_TAC) = :senha";

        return DB::connection($this->connection)->select($sql, ['aluno' => $aluno, 'senha' => $senha]);
    }

    /**
     * 
     */
    public function loginDocente($docente, $senha) {

        $sql = "SELECT  NUM_FUNC                    LOGIN,
                        DBO.DECRYPT(P.SENHA_DOL)    SENHA, 
                        NOME_COMPL                  NOME
                FROM    LY_DOCENTE     
                WHERE   NUM_FUNC = :docente
                AND     DBO.DECRYPT(P.SENHA_DOL) = :senha";

        return DB::connection($this->connection)->select($sql, ['docente' => $docente, 'senha' => $senha]);
    }
}
