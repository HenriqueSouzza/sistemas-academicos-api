<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permissoes extends Model
{
    /**
     * <b>SoftDeletes</b> Recurso utilizado para fazer deleção de registro lógico "sem excluir"
     * Usado no campo deleted_at da tabela 
     */
    use SoftDeletes;

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    protected $table = 'PERMISSOES';

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "ID";

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable = [
        'PERMISSAO',
        'DESCRICAO',
        'PREFIX',
    ];

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
     */
    public $rules = [
        'DESCRICAO'         => 'bail|required|max:100',
        'PERMISSAO'         => 'bail|required|max:250',
        'PREFIX'            => 'bail|max:150',
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
        'pivot'
    ];

    /**
     * <b>collection</b> Atributo responsável em informar o namespace e o arquivo do resource
     * O mesmo é utilizado em forma de facade.
     * OBS: Responsável em retornar uma coleção com os alias(apelido) atribuidos para cada coluna. 
     */
    public $collection = "\App\Http\Resources\Permissoes::collection";

    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\Permissoes";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        'permissao'     => 'PERMISSAO',
        'descricao'     => 'DESCRICAO',
        'prefix'        => 'PREFIX',
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
     * <b>Papeis</b> Método responsável por realizar o relacionamento muito para muitos entre a tabela de PERMISSOES e a tabela de PAPEIS
     * Sendo o primeiro parametro a model e o segundo a tabela
     * @return type
     */
    public function papeis()
    {
        return $this->belongsToMany(Papeis::class, 'PERMISSOES_PAPEIS', 'FK_PERMISSOES', 'FK_PAPEIS');
    }

}
