<?php

namespace App\Models\CanalDireto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setor extends Model
{
    
   /**
     * <b>SoftDeletes</b> Recurso utilizado para fazer deleção de registro lógico "sem excluir"
     * Usado no campo deleted_at da tabela 
     */
    use SoftDeletes; 
    
    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    protected $table = 'cd.SETOR';    

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "ID";    

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable = [ 
        'DESCRICAO',
        'ATIVO',
    ];    

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
     */
    public $rules = [
        'DESCRICAO' => 'bail|required|max:150',
        'ATIVO'     => 'bail|required|integer|max:1',
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
    public $collection = "\App\Http\Resources\Setor::collection";    


    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\Setor";  
    
    
    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        "descricao"     => 'DESCRICAO',
        "ativo"         => 'ATIVO',
    ];    

    /**
     * <b>getPrimaryKey</b> Método responsável em retornar o nome da primaryKey.
     * OBS: Não é recomendado que este atributo seja publico, por isso foi realizado o encapsulamento
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }    
}
