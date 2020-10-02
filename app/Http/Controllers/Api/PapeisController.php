<?php

namespace App\Http\Controllers\Api;

use App\Models\Papeis;
use App\Models\PermissoesPapeis;
use App\Models\CanalDireto\CategoriaPapeis;
use Illuminate\Http\Request;

use App\Http\Controllers\Traits\ApiControllerTrait;
use App\Http\Controllers\Controller;

class PapeisController extends Controller
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
    public function __construct(Papeis $model)
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
     */
    public function store(Request $request, PermissoesPapeis $PermissoesPapeis, Papeis $papeis, CategoriaPapeis $categoriaPapeis)
    {   
        //Valida os campos de data
        $validatePapeis = $this->validateInputs($request);

        if(isset($validatePapeis->getData()->response->content->error))
        {
            return $validatePapeis;
        }

        //Verifica se já existe o sistema que foi informado
        $ruleSistema = (Object) $this->model->ruleUnique($request->sistema, "Sistema");         

        //Verifica se já existe o formulario que foi informado
        // $ruleFormulario = (Object) $this->model->ruleUnique($request->sistema, "Formulario");         

        if(isset($ruleSistema->error))
        {
            return $this->createResponse($ruleSistema, 422);
        }

        if(isset($ruleFormulario->error))
        {
            return $this->createResponse($ruleFormulario, 422);
        }

        $values = $this->columnsInsert($request);

        $resultPapeis = $this->model->create($values);
        
        $request->merge(['id_papeis' => $resultPapeis->ID]);
        
        /**************************************************************
         **************** CASO FOR PASSADO PERMISSAO ******************
         **************************************************************/
        $permissao = (array) $request->permissao;
        
        if(count($permissao) > 0){
            //Assume model de permissoes Papeis
            $this->model = $PermissoesPapeis;

            foreach($permissao as $key => $value ):

                $request->merge(['id_permissao' => $value]);

                $validatePermissoes = $this->validateInputs($request);

                //Verifica se já existe o sistema que foi informado
                $rulePermissoes = (Object) $this->model->ruleUnique($request->id_permissao, "Permissoes");

                if(!isset($validatePermissoes->getData()->response->content->error) && !isset($rulePermissoes->error))
                {
                    $values = $this->columnsInsert($request);

                    $this->model->create($values);
                }

            endforeach;

        }

        /**************************************************************
         ********** CASO FOR PASSADO CATEGORIA ****************
         **************************************************************/
        $categoria = (array) $request->categoria;
        
        if(count($categoria) > 0){

            //Assume model de permissoes Papeis
            $this->model = $categoriaPapeis;
            
            foreach($categoria as $key => $value):

                $request->merge(['id_categoria' => $value]);
                
                $validate = $this->validateInputs($request);

                //Verifica se já existe o sistema que foi informado
                $ruleCategoria = (Object) $this->model->ruleUnique($request->id_categoria, "Categoria");         

                if(!isset($validate->getData()->response->content->error) && !isset($ruleCategoria->error))
                {
                    $values = $this->columnsInsert($request);

                    $this->model->create($values);
                }

            endforeach;

        }

        /**************************** RETURN ***************************/
        $this->model = $papeis; 
        
        return $this->createResponse($this->columnsShow($resultPapeis), 201);
    }

    /**
     * Display the specified resource.
     *
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
     */
    public function update(Request $request, $id, PermissoesPapeis $permissoesPapeis, Papeis $papeis, CategoriaPapeis $categoriaPapeis)
    {
        $result = $this->model->findOrFail($id);

        //Método vindo da trait de api 
        $values = $this->columnsInsert($request);

        $arrayRole = array();
        
        foreach($values as $key => $val):

            if(in_array($key, array_keys($this->model->rules))):
                $arrayRole[$key] = $this->model->rules[$key];
            endif;
            
        endforeach;

        if(count($arrayRole) > 0):
            
            $validate = validator($values, $arrayRole, $this->model->messages);

        else:

            $validate = validator($values, $this->model->rules, $this->model->messages);

        endif;

        if ($validate->fails()) {
            $errors['messages'] = $this->columnsShow($validate->errors());
            $errors['error']    = true;

            return $this->createResponse($errors, 422);
        }

        $result->update($values);

        /**************************************************************
         ********** CASO FOR PASSADO PERMISSAO ****************
         **************************************************************/

        $permissao = (array) $request->permissao;

        if(count($permissao) > 0){
            
            //Assume model de permissoes Papeis
            $this->model = $permissoesPapeis;
            
            $this->model->where('FK_PAPEIS', $id)->delete();
    
            foreach($permissao as $key => $value ):
                
                $request->merge(['id_permissao' => $value]);
                $request->merge(['id_papeis' => $id]);
                
                $validatePermissoes = $this->validateInputs($request);

                //Verifica se já existe o sistema que foi informado
                $rulePermission = (Object) $this->model->ruleUnique($request->id_permissao, "Permissoes"); 
                
                if(!isset($validatePermissoes->getData()->response->content->error) && !isset($rulePermission->error))
                {
                    $values = $this->columnsInsert($request);

                    $this->model->create($values);
                }

            endforeach;

        }

        /**************************************************************
         ********** CASO FOR PASSADO CATEGORIA ****************
         **************************************************************/
        $categoria = (array) $request->categoria;
        
        if(count($categoria) > 0){

            //Assume model de permissoes Papeis
            $this->model = $categoriaPapeis;

            $this->model->where('FK_PAPEIS', $id)->delete();
            
            foreach($categoria as $key => $value):

                $request->merge(['id_categoria' => $value]);
                $request->merge(['id_papeis' => $id]);
                
                $validate = $this->validateInputs($request);

                //Verifica se já existe o sistema que foi informado
                $ruleCategoria = (Object) $this->model->ruleUnique($request->id_categoria, "Categoria");         

                if(!isset($validate->getData()->response->content->error) && !isset($ruleCategoria->error))
                {
                    $values = $this->columnsInsert($request);

                    $this->model->create($values);
                }

            endforeach;

        }

        /**************************** RETURN ***************************/
        $this->model = $papeis; 
        
        return $this->createResponse($this->columnsShow($result), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->destroyTrait($id);
    }

}
