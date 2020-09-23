<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Traits\ApiControllerTrait;
use Illuminate\Support\Facades\Gate;

use App\Models\Permissoes;

class PermissoesController extends Controller
{

    /**
     * <b>use ApiControllerTrait</b> Usa a trait e sobreescreve os seus nomes e sua visibilidade, para a classe
     * que esta utilizando a mesma. Sendo assim temos um método index neste classe e um na ApiControllerTrait. 
     * Para não causar conflito é alterado o seu nome exemplo: index as protected indexTrait;
     * Mais informações em: http://php.net/manual/en/language.oop5.traits.php (Changing Method Visibility)
    */
    use ApiControllerTrait
    {

        index as protected indexTrait;
        store as protected storeTrait;
        show as protected showTrait;
        update as protected updateTrait;
        destroy as protected destroyTrait;
    }
    
    /**
     * <b>model</b> Atributo responsável em guardar informações a respeito de qual model a controller ira utilizar. 
     * Por causa do D.I (injeção de dependencia feita) o mesmo armazena um objeto da classe que ira ser utilizada.
     * OBS: Este atributo é utilizado na ApiControllerTrait, para diferenciar qual classe esta utilizando os seus recursos
     */
    protected $model;

    /**
     * <b>relationships</b> Atributo responsável em guardar informações sobre relacionamentos especificados na models
     * Estes relacionamentos são utilizados entre as models e suas respectivas tabelas.
     * OBS: Caso tenha algum relacionamento na model o mesmo deverá ser descrito o nome do mesmo aqui, para que a ApiControllerTrait
     * Possa utilizar o mesmo em seu método with() presente na consulta do metodo index
     */
    protected $relationships = [];
         
    /**
     * <b>__construct</b> Método construtor da classe. O mesmo é utilizado, para que atribuir qual a model será utilizada.
     * Essa informação atribuida aqui, fica disponivel na ApiControllerTrait e é utilizada pelos seus metodos.
     */
    public function __construct(Permissoes $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->indexTrait($request);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->storeTrait($request);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        return $this->showTrait($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->updateTrait($request, $id);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        return $this->destroyTrait($id);
    }


    /**
     * <b>updateAllPermissions</b> Método responsável por atualizar todas as permissões presentes no sistema. 
     * Essa atualização é realizada com base de todas as controllers e actions. Caso aconteça a criação de uma 
     * controller ou mais uma action o mesmo será contemplado o cadastro das novas ações
     * @param  \Illuminate\Http\Request  $request
     */

    public function updateAllPermissions(Request $request)
    {
        foreach(\Route::getRoutes()->getRoutes() as $route )
        {
            $action = $route->getAction();

            if(array_key_exists('controller', $action))
            {
                $controller = explode('\\', $action['controller']);
                $index = max(array_keys($controller));
                $actionPermission = explode('@', $controller[$index]);
                $actionName = ( array_key_exists('as', $action) ? $action['as'] : '' );

                $find = Permission::where('name_permission', $controller[$index])->count();

                if(!$find)
                {
                    $data = Permission::insert([
                       'name_permission'   => $controller[$index],
                       'label_permission'  => 'Acesso a ação '.$actionPermission[1],
                       'action_permission' => $actionName,
                    ]);
                }
            }
        }

        $message['message'] = 'Permissões atualizadas com sucesso !';
        $message['error'] = false;

        return $this->createResponse($message);
    }
}
