<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


use App\Models\CanalDireto\Papeis;
use App\Models\Permissoes;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

     /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
     */
    public $table = "USERS";

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'provider',
        'provider_id',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     
    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
    */
    protected $primaryKey = 'id';

    /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'email_verified_at'];

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */
    public $rules = [
        'name'     => 'bail|required',
        'email'    => 'bail|required',
        'password' => 'bail|required'
    ];

    
    /**
     * <b>messages</b> Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
     */
    public $messages = [

    ];

    /**
     *<b>collection</b> Atributo responsável em informar o namespace e o arquivo do resource
     * O mesmo é utilizado em forma de facade.
     * OBS: Responsável em retornar uma coleção com os alias(apelido) atribuidos para cada coluna. 
     * Mais informações em https://laravel.com/docs/5.8/eloquent-resources
    */
    public $collection = "\App\Http\Resources\User::collection";

    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\User";

   /**
    * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
    * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
    */
    public $map = [
       'id'             => 'id',
       'name'           => 'name',
       'email'          => 'email',
       'password'       => 'password',
       'provider'       => 'provider',
       'provider_id'    => 'provider_id',
       'email_verified' => 'email_verified_at',
       'created_at'     => 'created_at',
       'updated_at'     => 'updated_at',
       'deleted_at'     => 'deleted_at',
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
     * <b>roles</b> Metodo responsável por realizar o relacionamento de muitos para muitos entre as tabelas de users, PAPEIS e USUARIOS_PAPEIS
     * Sendo o primeiro parametro a model e o segundo a tabela
     */
    public function papeis()
    {
        return $this->belongsToMany(Models\Papeis::class, 'PAPEIS_USUARIOS', 'FK_USER', 'FK_PAPEIS')
        ->select([
            'PAPEIS.ID as id', 
            'PAPEIS.PAPEL as papel',
            'PAPEIS.DESCRICAO as descricao',
        ]);
    }

    /****************************************************************
    ************************* ACL METHODS *************************** 
    *****************************************************************
    *****************************************************************/
       
    /**
     * <b>hasPermission</b> Recupera todas as permissões atribuidas a um papel
     * exemplo: permissão visualizar papel: administrador  
     * @param Permission $permission
     */
    public function hasPermission(Permissoes $permission)
    {
        return $this->hasAnyRoles($permission->papeis); 
        
    }
    
    /**
     * <b>hasAnyRoles</b> Verifica se o usuário que esta logado tem a permissão adequada para realizar o acesso 
     *
     * @param type $roles
     */
    public function hasAnyRoles($papeis)
    {
        // So cai nesse if, se um ou mais papeis,for passado
        if(is_array($papeis) || is_object($papeis))
        {
            return !! $papeis->intersect($this->papeis)->count();
        }

        return $this->papeis->contains('PAPEL', $papeis);
    }
}
