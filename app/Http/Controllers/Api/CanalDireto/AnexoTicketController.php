<?php

namespace App\Http\Controllers\Api\CanalDireto;

use App\Models\CanalDireto\anexoTicket;
use Illuminate\Http\Request;

// use App\Http\Controllers\Traits\ApiControllerTrait;
use App\Http\Controllers\Controller;

class AnexoTicketController extends Controller
{


    /**
     * Define os tipos de arquivos permitidos
     */
    private $extensionPermitted = [];


    /**
     * Define o caminho que será salvo dentro da pasta "Storage\App"
     */
    private $pathFile = '';

    /**
     * Define o nome do arquivo que será salvo
     */
    private $nameFile = '';


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
    public function __construct(AnexoTicket $model)
    {
        $this->model = $model;
    }

    private function setPathFile($path){
        $this->pathFile = $path;
    }

    private function setNameFile($nameFile){
        $this->nameFile = $path;
    }

    private function getPathFile(){
        return $this->pathFile;
    }

    private function getNameFile(){
        return $this->nameFile = $path;
    }

    /**
     * 
     */
    public function saveArchive($request){
        
        //pega o type do arquivo
        $typeArchive = $request->arquivo->getClientMimeType();

        //pega extensao do arquivo
        $extension = $request->file('img_itens')->getClientOriginalExtension();

        $result = $request->file('arquivo')->storeAs(
            $this->pathFile, $this->nameFile . '.' .$request->file('arquivo')->extension()
        );

    }
}