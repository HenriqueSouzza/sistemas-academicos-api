<?php

namespace App\Models\CanalDireto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    /**
     * <b>SoftDeletes</b> Recurso utilizado para fazer deleção de registro lógico "sem excluir"
     * Usado no campo deleted_at da tabela 
     */
    // use SoftDeletes; 
    
    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    protected $table = 'cd.MENUS';    

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "ID";    

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable = [ 
        'NOME',
        'LINK',
        'ICON',
        'ORDEM',
    ];    

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
     */
    public $rules = [
        'NOME'          => 'bail|required|max:20',
        'LINK'          => 'bail|required|max:150',
        'ICON'          => 'bail|max:20',
        'ORDEM'         => 'bail|required|integer',
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
    public $collection = "\App\Http\Resources\Menu::collection";    


    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\Menu";  
    
    
    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        'id'            => 'ID',
        'nome'          => 'NOME',
        'link'          => 'LINK',
        'icon'          => 'ICON',
        'ordem'         => 'ORDEM',
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
     * <b>papeis</b> Método responsável em definir o relacionamento entre as Ticket e InteracaoTicket e suas
     * respectivas tabelas.
     */
    public function submenu()
    {
        return $this->hasMany(SubMenu::class, 'ID_MENU', 'ID')
        ->select([
            'SUB_MENUS.ID as id', 
            'SUB_MENUS.NOME as nome',
            'SUB_MENUS.LINK as link',
            'SUB_MENUS.ICON as icon',
            'SUB_MENUS.ORDEM as ordem',
            'SUB_MENUS.ATIVO as ativo',
        ]);
    }
}
