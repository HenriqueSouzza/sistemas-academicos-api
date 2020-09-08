<?php

namespace App\Models\CanalDireto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CamposFormularios extends Model
{
    /**
     * <b>SoftDeletes</b> Recurso utilizado para fazer deleção de registro lógico "sem excluir"
     * Usado no campo deleted_at da tabela 
     */
    use SoftDeletes;

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
     */
    protected $table = 'cd.CAMPOS_FORMULARIOS';
    
    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "ID";

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable = [
        'ID_FORMULARIOS',
        'ID_CAMPOS_FORMS',
    ];

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
     */
    public $rules = [
        'ID_FORMULARIOS'        => 'bail|required|integer',
        'ID_CAMPOS_FORMS'       => 'bail|required|integer',
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
    public $collection = "\App\Http\Resources\CamposFormularios::collection";   
    
    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\CamposFormularios";    

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        'id_formulario'        => 'ID_FORMULARIOS',
        'id_campos'            => 'ID_CAMPOS_FORMS',
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
     * <b>formularios</b> Método responsável em definir o relacionamento entre camposFormularios e formularios e suas
     * respectivas tabelas.
     */
    public function formularios()
    {
        return $this->belongsTo(formularios::class, 'ID_FORMULARIOS', 'ID');
    }   

    /**
     * <b>camposforms</b> Método responsável em definir o relacionamento entre as de camposFormularios e camposForms e suas
     * respectivas tabelas.
     */
    public function camposForms()
    {
        return $this->belongsTo(CamposForm::class, 'ID_CAMPOS_FORMS', 'ID');
    }


     ///////////////////////////////////////////////////////////////////
    ///////////////////// REGRAS DE NEGOCIO ///////////////////////////
    ///////////////////////////////////////////////////////////////////

    /**
     * <b>ruleUnique</b> Método responsável em realizar a seguinte verificação:
     * REGRA : Verifica se existe o formulario e o campo informado, caso não exista retornará uma mensagem de erro
     * caso contrario retorna true
     * @param $id 
     * @param $model 
    */
    public function ruleUnique($id, $model)
    {   
        switch ($model) {
            case 'Formularios':
                $query = (Object) Formularios::whereRaw("ID={$id}");
                break;  
            case 'CamposForm':
                $query = (Object) CamposForm::whereRaw("ID={$id}");
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
