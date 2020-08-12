<?php

namespace App\Models\CanalDireto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    /**
     * <b>SoftDeletes</b> Recurso utilizado para fazer deleção de registro lógico "sem excluir"
     * Usado no campo deleted_at da tabela 
     */
    use SoftDeletes;

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    protected $table = 'cd.TICKET';

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "ID";

    /**
     * <b>dateFormat</b> dita o formato das datas que serão inseridas no campo data.
     *
     */
    // protected $dateFormat = 'U';

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable = [
        'USUARIO',
        'ID_PAPEL_USUARIO',
        'ID_SETOR',
        'ID_CATEGORIA',
        'ASSUNTO',
        'MENSAGEM',
        'USUARIO_FECHAMENTO',
        'DT_FECHAMENTO',
        'STATUS'
    ];

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
     */
    public $rules = [
        'USUARIO'               => 'bail|required|max:20',
        'ID_PAPEL_USUARIO'      => 'bail|required|integer',
        'ID_SETOR'              => 'bail|required|integer',
        'ID_CATEGORIA'          => 'bail|required|integer',
        'ASSUNTO'               => 'bail|required|max:200',
        'MENSAGEM'              => 'bail|required|max:500',
        'USUARIO_FECHAMENTO'    => 'bail|max:50',
        'DT_FECHAMENTO'         => 'bail|date',
        'STATUS'                => 'bail|required|max:20',
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
    public $collection = "\App\Http\Resources\Ticket::collection";

    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\Ticket";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        'usuario'               => 'USUARIO',
        'papel_usuario'         => 'ID_PAPEL_USUARIO',
        'setor'                 => 'ID_SETOR',
        'categoria'             => 'ID_CATEGORIA',
        'assunto'               => 'ASSUNTO',
        'mensagem'              => 'MENSAGEM',
        'usuario_fechamento'    => 'USUARIO_FECHAMENTO',
        'dt_fechamento'         => 'DT_FECHAMENTO',
        'status'                => 'STATUS'
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
     * <b>papeis</b> Método responsável em definir o relacionamento entre as de Ticket e Papeis e suas
     * respectivas tabelas.
     */
    public function papeis()
    {
        return $this->belongsTo(Papeis::class, 'ID_PAPEL_USUARIO', 'ID');
    }

    /**
     * <b>setor</b> Método responsável em definir o relacionamento entre as de Ticket e Setor e suas
     * respectivas tabelas.
     */
    public function setor()
    {
        return $this->belongsTo(Setor::class, 'ID_SETOR', 'ID');
    }

    /**
     * <b>papeis</b> Método responsável em definir o relacionamento entre as de Ticket e Papeis e suas
     * respectivas tabelas.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'ID_CATEGORIA', 'ID');
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
            case 'Setor':
                $query = (Object) Setor::whereRaw("ID={$id}");
            break;  
            case 'Categoria':
                $query = (Object) Categoria::whereRaw("ID={$id}");
            break;                                            
            default:
                $query = (Object) Papeis::whereRaw("ID={$id}");
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