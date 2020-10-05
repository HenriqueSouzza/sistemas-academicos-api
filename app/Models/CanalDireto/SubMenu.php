<?php

namespace App\Models\CanalDireto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubMenu extends Model
{
    /**
     * <b>SoftDeletes</b> Recurso utilizado para fazer deleção de registro lógico "sem excluir"
     * Usado no campo deleted_at da tabela 
     */
    // use SoftDeletes; 
    
    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    protected $table = 'cd.SUB_MENUS';    

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "ID";    

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable = [ 
        'ID_MENU',
        'NOME',
        'LINK',
        'ICON',
        'ATIVO',
    ];    

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
     */
    public $rules = [
        'ID_MENU'       => 'bail|required|integer',
        'NOME'          => 'bail|required|max:20',
        'LINK'          => 'bail|required|max:150',
        'ICON'          => 'bail|max:20',
        'ATIVO'         => 'bail|required|boolean',
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
    public $collection = "\App\Http\Resources\SubMenu::collection";    


    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\SubMenu";  
    
    
    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        'id'            => 'ID',
        'menu'          => 'ID_MENU',
        'nome'          => 'NOME',
        'link'          => 'LINK',
        'icon'          => 'ICON',
        'ativo'         => 'ATIVO'
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
     * <b>papeis</b> Método responsável em definir o relacionamento entre as Menu e SubMenu e suas
     * respectivas tabelas.
     */
    public function menu()
    {
        return $this->hasMany(Menu::class, 'ID', 'ID_MENU')
        ->select([
            'MENUS.ID as id', 
            'MENUS.NOME as nome',
            'MENUS.LINK as link',
            'MENUS.ICON as icon',
        ]);
    }

    ///////////////////////////////////////////////////////////////////
    ///////////////////// REGRAS DE NEGOCIO ////////////////////////////
    ///////////////////////////////////////////////////////////////////

    /**
    * <b>ruleUnique</b> Método responsável em realizar a seguinte verificação:
    * REGRA : Verifica se existe o papel informado, caso seja verdadeiro retornará uma mensagem de erro
    * caso contrario retorna true
    * @param $idPapel (id do papel)
    */

    public function ruleUnique($id, $model)
    {   
        switch ($model) {
            default:
                $query = (Object) Menu::whereRaw("ID={$id}");
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
