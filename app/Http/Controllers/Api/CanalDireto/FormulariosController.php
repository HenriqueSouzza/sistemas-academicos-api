<?php

namespace App\Http\Controllers\Api\CanalDireto;

use App\Models\CanalDireto\Formularios;
use Illuminate\Http\Request;

use App\Http\Controllers\Traits\ApiControllerTrait;
use App\Http\Controllers\Api\CanalDireto\CamposFormulariosController;
use App\Http\Controllers\Controller;

class FormulariosController extends Controller
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
     * Atributo Responsável para receber os metodos da classe "CamposFormulariosController"  
     */
    protected $camposFormulariosController;
    

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
    public function __construct(Formularios $model, CamposFormulariosController $CamposFormulariosController)
    {
        $this->model = $model;
        $this->camposFormulariosController = $CamposFormulariosController;
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
        $inserted =  $this->storeTrait($request);

        $dataInserted = json_decode($inserted->getContent());

        if(isset($dataInserted->response->content->error)):
            return $inserted;
        endif;
        
        $request->merge(['id_formulario' => $dataInserted->response->content->id]);

        foreach($request->id_campos as $key => $value):

            $request->merge(['id_campos' => $value]);

            $this->camposFormulariosController->store($request);

        endforeach;

        $result = $this->camposFormulariosController->index($request);

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->showTrait($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updated = $this->updateTrait($request, $id);

        $dataUpdated = json_decode($updated->getContent());

        if(isset($dataUpdated->response->content->error)):
            return $updated;
        endif;
        
        $request->merge(['id_formulario' => $dataUpdated->response->content->id]);

        $request->merge(['where'=> array('id_formulario' => $dataUpdated->response->content->id)]);

        $resultCampos = $this->camposFormulariosController->index($request);

        $dataDeleted = json_decode($resultCampos->getContent());

        foreach($dataDeleted->response->content as $key => $value):

            $this->camposFormulariosController->destroy($value->id);
            
        endforeach;

        foreach($request->id_campos as $key => $value):

            $request->merge(['id_campos' => $value]);

            $this->camposFormulariosController->store($request);

        endforeach;

        $result = $this->camposFormulariosController->index($request);

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->destroyTrait($id);
    }
}
