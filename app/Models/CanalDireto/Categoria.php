<?php

namespace App\Models\CanalDireto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    /**
     * <b>SoftDeletes</b> Recurso utilizado para fazer deleção de registro lógico "sem excluir"
     * Usado no campo deleted_at da tabela 
     */
    use SoftDeletes;

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    protected $table = 'cd.CATEGORIA';  
    
    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "ID";  
    
    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable = [
        'ID_SETOR',
        'DESCRICAO',
        'ATIVO',
        'PERMITE_ABERTURA',
        'PERMITE_INTERACAO',
        'PERMITE_N_TICKETS',      
        'USUARIO',
    ];   
    
    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
     */
    public $rules = [
        'ID_SETOR'          => 'bail|required|integer',
        'DESCRICAO'         => 'bail|required',
        'ATIVO'             => 'bail|required|max:1',
        'PERMITE_ABERTURA'  => 'bail|required|max:1',
        'PERMITE_INTERACAO' => 'bail|required|max:1',
        'PERMITE_N_TICKETS' => 'bail|required|max:1',        
        'USUARIO'           => 'bail|required'
    ];   
    

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
     */
    public $messages = [
       
    ];   
    
    /**
     * <b>hidden</b> Atributo responsável em esconder colunas que não deverão ser retornadas em uma requisição
     */
    protected $hidden  = [

    ];

    /**
     * <b>collection</b> Atributo responsável em informar o namespace e o arquivo do resource
     * O mesmo é utilizado em forma de facade.
     * OBS: Responsável em retornar uma coleção com os alias(apelido) atribuidos para cada coluna. 
     */
    public $collection = "\App\Http\Resources\Categoria::collection";   
    
    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\Categoria";    

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        'setor'              => 'ID_SETOR',
        'descricao'          => 'DESCRICAO',
        'ativo'              => 'ATIVO',
        'permite_abertura'   => 'PERMITE_ABERTURA',
        'permite_interacao'  => 'PERMITE_INTERACAO',
        'permite_n_tickets'  => 'PERMITE_N_TICKETS',
        'usuario'            => 'USUARIO',
    ];    

    /**
     * <b>getPrimaryKey</b> Método responsável em retornar o nome da primaryKey.
     * OBS: Não é recomendado que este atributo seja publico, por isso foi realizado o encapsulamento
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }    

    /**
     * <b>setor</b> Método responsável em definir o relacionamento entre as de Setor e Categoria e suas
     * respectivas tabelas.
     */
    public function setor()
    {
        return $this->belongsTo(Setor::class, 'ID_SETOR', 'ID');
    }   
    
    /**
    * <b>ruleUnique</b> Método responsável em realizar a seguinte verificação:
    * REGRA : Verifica se existe o setor informado, caso seja verdadeiro retornará uma mensagem de erro
    * caso contrario retorna true
    * @param $idPapel (id do papel)
    */

    public function ruleUnique($idSetor)
    {
        $query = (Object) Setor::whereRaw("ID={$idSetor}");
        
         $count = $query->get()->count();

        if($count < 1)
        {
            $error['message'] = "O Setor não existe!";
            $error['error']   = true;

            return $error;
        }

    }    

}
