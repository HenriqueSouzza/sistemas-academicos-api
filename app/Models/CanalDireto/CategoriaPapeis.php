<?php

namespace App\Models\CanalDireto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaPapeis extends Model
{
    /**
     * <b>SoftDeletes</b> Recurso utilizado para fazer deleção de registro lógico "sem excluir"
     * Usado no campo deleted_at da tabela 
     */
    // use SoftDeletes;

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    protected $table = 'cd.CATEGORIA_PAPEIS';

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "ID";

    /**
     * <b>dateFormat</b> dita o formato das datas que serão inseridas no campo data.
     *
     */
    // protected $dateFormat = 'ymd';

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable = [
        'FK_CATEGORIA',
        'FK_PAPEIS',
    ];

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
     */
    public $rules = [
        'FK_CATEGORIA'      => 'bail|required|integer',
        'FK_PAPEIS'         => 'bail|required|integer',
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
    public $collection = "\App\Http\Resources\CategoriaPapeis::collection";

    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\CategoriaPapeis";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        'id_papeis'         => 'FK_PAPEIS',
        'id_categoria'      => 'FK_CATEGORIA',
    ];

    /**
     * <b>getPrimaryKey</b> Método responsável em retornar o nome da primaryKey.
     * OBS: Não é recomendado que este atributo seja publico, por isso foi realizado o encapsulamento
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    ///////////////////////////////////////////////////////////////////
    ///////////////////// REGRAS DE NEGOCIO ///////////////////////////
    ///////////////////////////////////////////////////////////////////

    /**
     * <b>ruleUnique</b> Método responsável em realizar a seguinte verificação:
     * REGRA : Verifica se existe o papel e o usuario informado, caso não exista retornará uma mensagem de erro
     * caso contrario retorna true
     * @param $id 
     * @param $model 
    */
    public function ruleUnique($id, $model)
    {   
        switch ($model) {
            case 'Papeis':
                $query = (Object) \app\Models\Papeis::whereRaw("ID={$id}");
                break;  
            case 'Categoria':
                $query = (Object) Categoria::whereRaw("id={$id}");
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
