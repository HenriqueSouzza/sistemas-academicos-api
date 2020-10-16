<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Lyceum extends Model
{
    protected $connection = 'lyceum';

    protected $usuario = '';

    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }

    public function getUsuario(){
        return $this->usuario;
    }

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

    public function buscarDadosUsuario(){

        $result = [];

        $sql = "SELECT	A.ALUNO         aluno
                        ,A.NOME_COMPL   nome_compl
                        ,A.TURNO        turno
                        ,A.SERIE        serie
                        ,A.SIT_ALUNO    sit_aluno
                        ,C.CURSO        curso
                        ,C.NOME			nome_curso
                        ,C.MODALIDADE	modalidade	
                        ,C.TIPO         tipo
                        ,TC.DESCRICAO	tipo_descricao
                FROM	LY_ALUNO	A
                JOIN	LY_CURSO	C		ON C.CURSO = A.CURSO
                JOIN	LY_TIPO_CURSO TC	ON TC.TIPO = C.TIPO
                WHERE	ALUNO = :usuario";

        $result = DB::connection($this->connection)->select($sql, ['usuario' => $this->usuario]);

        if(count($result) > 0){
            return $result;
        }

        $sql = "SELECT	NUM_FUNC        num_func
                        ,NOME_COMPL     nome_compl
                        ,E_MAIL         e_mail
                FROM	LY_DOCENTE
                WHERE   NUM_FUNC = :usuario";

        $result = DB::connection($this->connection)->select($sql, ['usuario' => (int) $this->usuario]);

        return $result;

    }
}
