<?php

namespace App\Http\Controllers\Api\CanalDireto;

use App\Models\CanalDireto\InteracaoTicket;
use Illuminate\Http\Request;

use App\Http\Controllers\Traits\ApiControllerTrait;
use App\Http\Controllers\Api\CanalDireto\AnexoTicketController;
use App\Http\Controllers\Controller;

use App\Models\CanalDireto\Ticket;
use App\Models\CanalDireto\Categoria;
use App\Models\CanalDireto\Setor;

use Illuminate\Support\Facades\Mail; //dependencia de envio de email


class InteracaoTicketController extends Controller
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
    protected $relationships = ['AnexoTicket'];

    /**
     * Reponsável para impressa de anexos 
     */
    protected $AnexoTicketController;

    /**
     * <b>__construct</b> Método construtor da classe. O mesmo é utilizado, para que atribuir qual a model será utilizada.
     * Essa informação atribuida aqui, fica disponivel na ApiControllerTrait e é utilizada pelos seus metodos.
     */
    public function __construct(InteracaoTicket $model, AnexoTicketController $anexo)
    {
        $this->model = $model;
        $this->AnexoTicketController = $anexo;
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
    public function store(Request $request)
    {
        //Valida os inputs passado, o método validateInputs vem da trait (ApiControllerTrait)
        $validate = $this->validateInputs($request);

        $responseValidate =  $validate->original['response']['content'];

        if(isset($responseValidate->error))
        {
            return $validate;
        }

        //Verifica se já existe o papel que foi informado
        $rulePapel = (Object) $this->model->ruleUnique($request->papel_usuario, "Papel");
        
        //Verifica se já existe o ticket que foi informado
        $ruleTicket = (Object) $this->model->ruleUnique($request->id_ticket, "Ticket");         

        if(isset($rulePapel->error))
        {
            return $this->createResponse($rulePapel, 422);

        }else if (isset($ruleTicket->error))
        {
            return $this->createResponse($ruleTicket, 422);
        }

        $insert = $this->storeTrait($request);

        $dados = json_decode($insert->getContent());

        if($request->arquivo){
            
            $resultUpload = $this->saveArchive($request, $dados);

            $insert->setContent(json_encode($resultUpload));

        }

        try {

            $ticket = Ticket::findOrFail($dados->response->content->id);

            $categoria = Categoria::findOrFail($ticket->ID_CATEGORIA);
        
            $setor = Setor::findOrFail($ticket->ID_SETOR);

            //var_dump($dados->response->content->id);
            Mail::to('henrique.lindao10@gmail.com')->send(new InteracaoTicket($ticket, $categoria, $setor));
            var_dump('sucesso');
        } catch (\Throwable $th) {
            var_dump('error');
        }

        return $insert;
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
    public function update(Request $request, $id)
    {
        return $this->updateTrait($request, $id);
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

    /**
     * Tratar os arquivos que serão salvos
     */
    private function saveArchive($request, $data){

        $files = $request->arquivo;

        $error = [];

        foreach($files as $key => $val):

            $this->AnexoTicketController->setAcceptFile(['image/jpeg', 'image/png', 'application/pdf']);

            $this->AnexoTicketController->setPathFile('canal-direto/interacoes');
            
            $addFile = $this->AnexoTicketController->addFile($val);

            if(!$addFile){
            
                $error['error'][$key] = true;
                $error['message'][$key] = $this->AnexoTicketController->getErrorSaveFile();
    
                $data->response->errorUpload = (object) $error;
    
            }

            if(!isset($data->response->errorUpload)):

                $dataInsert = [
                    'ID_TICKET' => $request->id_ticket,
                    'ID_INTERACAO_TICKET' => $data->response->content->id,
                    'ARQUIVO' => asset('storage/'.$addFile)
                ];
        
                $result = $this->AnexoTicketController->store($dataInsert);
    
            endif;
            
        endforeach;
        
        return $data;
        
    }   
}
