<?php

namespace App\Models\CanalDireto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnexoTicket extends Model
{
    /**
     * <b>SoftDeletes</b> Recurso utilizado para fazer deleção de registro lógico "sem excluir"
     * Usado no campo deleted_at da tabela 
     */
    use SoftDeletes;

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    protected $table = 'cd.ANEXO_TICKET';

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "ID";

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable = [
        'ID_TICKET',
        'ID_INTERACAO_TICKET',
        'ARQUIVO',
    ];

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
     */
    public $rules = [
        'ID_TICKET'             => 'bail|required|integer',
        'ID_INTERACAO_TICKET'   => 'bail|integer',
        'ARQUIVO'               => 'bail|required|max:200',
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
    public $collection = "\App\Http\Resources\AnexoTicket::collection";   
    
    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\AnexoTicket";   

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        'id'                    => 'ID',
        'id_ticket'             => 'ID_TICKET',
        'id_interacao_ticket'   => 'ID_INTERACAO_TICKET',
        'arquivo'               => 'ARQUIVO',
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
     * <b>ticket</b> Método responsável em definir o relacionamento entre AnexoTicket e interaçãoTickets e suas
     * respectivas tabelas.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ID_TICKET', 'ID');
    }   

     /**
     * <b>interacaoTicket</b> Método responsável em definir o relacionamento entre as de AnexoTicket e interacaoTicket e suas
     * respectivas tabelas.
     */
    public function interacaoTicket()
    {
        return $this->belongsTo(InteracaoTicket::class, 'ID_INTERACAO_TICKET', 'ID');
    }

    ///////////////////////////////////////////////////////////////////
    ///////////////////// REGRAS DE NEGOCIO ///////////////////////////
    ///////////////////////////////////////////////////////////////////

    /**
     * <b>ruleUnique</b> Método responsável em realizar a seguinte verificação:
     * REGRA : Verifica se existe o ticket e o interacaoticket informado, caso não exista retornará uma mensagem de erro
     * caso contrario retorna true
     * @param $id 
     * @param $model 
    */
    public function ruleUnique($id, $model)
    {   
        switch ($model) {
            case 'Ticket':
                $query = (Object) Ticket::whereRaw("ID={$id}");
                break;  
            case 'InteracaoTicket':
                $query = (Object) InteracaoTicket::whereRaw("ID={$id}");
                break;   
        }
        
        $count = $query->get()->count();

        if($count < 1)
        {
            $error['message'] = $model . " não Cadastrado (a).";
            $error['error']   = true;

            return $error;
        }

    }
}