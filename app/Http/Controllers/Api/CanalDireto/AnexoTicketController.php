<?php

namespace App\Http\Controllers\Api\CanalDireto;

use App\Models\CanalDireto\anexoTicket;
use Illuminate\Http\Request;

// use App\Http\Controllers\Traits\ApiControllerTrait;
use App\Http\Controllers\Controller;

class AnexoTicketController extends Controller
{

    /**
     * 
     */
    private $idInteracaoTicket = '';

    /**
     * 
     */
    private $idTicket = '';

    /**
     * Atributo para definir os tipos de arquivo permitidos;
     */
    private $AcceptFile = [];

    /**
     * Atributo para definir o caminho que será salvo dentro da pasta "Storage\App"
     */
    private $pathFile = '';

    /**
     * Atributo para definir o nome do arquivo que será salvo
     */
    private $nameFile = '';

    /**
     * Atributo para definir o tamanho do arquivo que será aceito em byte
     */
    private $sizeFile = 5000000;

    /**
     * Atributo para guardar as mensagens caso tive algum erro
     */
    private $errorSaveFile = '';

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

    public function setIdTicket($idTicket){
        $this->idTicket = $idTicket;
    }

    public function setIdInteracaoTicket($idInteracaoTicket){
        $this->idInteracaoTicket = $idInteracaoTicket;
    }

    public function setAcceptFile($acceptFile){
        $this->AcceptFile = $acceptFile;
    }

    public function setPathFile($path){
        $this->pathFile = $path;
    }

    public function setNameFile($nameFile){
        $this->nameFile = $nameFile;
    }

    public function getIdTicket(){
        return $this->idTicket;
    }

    public function getIdInteracaoTicket(){
        return $this->idInteracaoTicket;
    }

    public function getAcceptFile(){
        return $this->AcceptFile;
    }

    public function getPathFile(){
        return $this->pathFile;
    }

    public function getNameFile(){
        return $this->nameFile;
    }

    public function getErrorSaveFile(){
        return $this->errorSaveFile;
    }

    /**
     * Faz as validações e guarda o arquivo dentro da pasta "Storage\app" na raíz do projeto
     */
    public function addFile($file){

        //Nome do arquivo original
        $nameFileOriginal = $file->getClientOriginalName();

        //pega o mime(type) do arquivo
        $acceptFile = $file->getClientMimeType();

        if(!in_array($acceptFile, $this->AcceptFile)){

            $this->errorSaveFile = "O arquivo ('$nameFileOriginal') possui o tipo não permitido";

            return false;
        }

        //pega tamanho do arquivo
        $sizeFile = $file->getSize();

        //Valida o tamanho do arquivo
        if($sizeFile > $this->sizeFile):

            $this->errorSaveFile = "O arquivo ('$nameFileOriginal') possui o tamanho não permitido";

            return false;

        endif;

        $pathFile = $file->storeAs($this->pathFile, $this->nameFile . '.' . $file->extension());

        return $pathFile;

    }

    /**
     * 
     */
    public function store($values){

        $validate = validator($values, $this->model->rules, $this->model->messages);
        
        if ($validate->fails()) {

            $errors['message'] = $validate->errors();
            $errors['error'] = true;
            
            return $errors;
        }

        $result = $this->model->create($values);

        return $result;

    }

    
}