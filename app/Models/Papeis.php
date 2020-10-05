<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Papeis extends Model
{
    /**
     * <b>SoftDeletes</b> Recurso utilizado para fazer deleção de registro lógico "sem excluir"
     * Usado no campo deleted_at da tabela 
     */
    use SoftDeletes;

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    protected $table = 'PAPEIS';

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "ID";

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable = [
        'PAPEL',
        'DESCRICAO',
        'SISTEMA',
        'FK_FORMULARIO'
    ];

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
     */
    public $rules = [
        'PAPEL'             => 'bail|required|max:50',
        'DESCRICAO'         => 'bail|required|max:100',
        'SISTEMA'           => 'bail|required|integer',
        'FK_FORMULARIO'     => 'bail|integer',
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
    public $collection = "\App\Http\Resources\Papeis::collection";

    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\Papeis";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        'papel'         => 'PAPEL',
        'descricao'     => 'DESCRICAO',
        'sistema'       => 'SISTEMA',
        'formulario'    => 'FK_FORMULARIO',
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
     * <b>Papeis</b> Método responsável por realizar o relacionamento muito para muitos entre a tabela de PAPEIS e a tabela de PERMISSOES
     * Sendo o primeiro parametro a model e o segundo a tabela
     * @return type
     */
    
    public function permissoes()
    {
        return $this->belongsToMany(Permissoes::class, 'PERMISSOES_PAPEIS', 'FK_PAPEIS', 'FK_PERMISSOES')->select([
            'PERMISSOES.ID as id', 
            'PERMISSOES.PERMISSAO as permissao',
            'PERMISSOES.DESCRICAO as descricao',
            'PERMISSOES.PREFIX as prefix',  
            'PERMISSOES.ACTION_PERMISSOES as action_permissoes'
        ]);
    }

    /**
     * <b>papeis</b> Método responsável em definir o relacionamento entre as de Papeis e Sistemas e suas
     * respectivas tabelas.
     */
    public function sistemas()
    {
        return $this->belongsTo(Sistemas::class, 'SISTEMA', 'ID')->select([
            'SISTEMAS.ID as id', 
            'SISTEMAS.NOME_SISTEMA as nome_sistema',
            'SISTEMAS.ATIVO as ativo',
        ]);
    }

    /**
     * <b>papeis</b> Método responsável em definir o relacionamento entre as de Papeis e Formularios e suas
     * respectivas tabelas.
     */
    public function formulario()
    {
        return $this->belongsTo(CanalDireto\Formularios::class, 'FK_FORMULARIO', 'ID')->select([
            'FORMULARIOS.ID as id', 
            'FORMULARIOS.NOME as nome',
            'FORMULARIOS.DESCRICAO as descricao',
        ]);
    }

    /**
     * <b>papeis</b> Método responsável em definir o relacionamento entre as de Papeis e Menus e suas
     * respectivas tabelas.
     */
    public function menus()
    {
        return $this->belongsToMany(CanalDireto\SubMenu::class, 'cd.PAPEIS_MENUS', 'FK_PAPEIS', 'FK_SUBMENU')
        ->join('cd.MENUS', 'MENUS.ID', '=', 'SUB_MENUS.ID_MENU')
        ->select([
            'MENUS.ID as id', 
            'MENUS.NOME as nome', 
            'MENUS.LINK as link', 
            'MENUS.ICON as icon', 
            'SUB_MENUS.ID as id_submenu', 
            'SUB_MENUS.NOME as nome_submenu',
            'SUB_MENUS.LINK as link_submenu',
            'SUB_MENUS.ICON as icon_submenu',
            'SUB_MENUS.ATIVO as ativo_submenu',
        ]);
    }

    /**
     * <b>papeis</b> Método responsável em definir o relacionamento entre as de Papeis e Setor e suas
     * respectivas tabelas.
     */
    public function categoria()
    {
        return $this->belongsToMany(CanalDireto\Categoria::class, 'cd.CATEGORIA_PAPEIS', 'FK_PAPEIS', 'FK_CATEGORIA')
        ->join('cd.SETOR', 'SETOR.ID', '=', 'CATEGORIA.ID_SETOR')
        ->select([
            'CATEGORIA.ID as id', 
            'SETOR.ID as id_setor',
            'SETOR.DESCRICAO as setor',
            'SETOR.ATIVO as ativo',
            'CATEGORIA.DESCRICAO as descricao',
            'CATEGORIA.PERMITE_ABERTURA_TICKET as permite_abertura_ticket',
            'CATEGORIA.PERMITE_INTERACAO as permite_interacao',
            'CATEGORIA.PERMITE_N_TICKETS_ABERTOS as permite_n_tickets_abertos',
            'CATEGORIA.ATIVO as ativo'
        ]);
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
            case 'Sistema':
                $query = (Object) Sistemas::whereRaw("ID={$id}");
            break;  
            case 'Formulario':
                $query = (Object) CanalDireto\Formularios::whereRaw("ID={$id}");
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
