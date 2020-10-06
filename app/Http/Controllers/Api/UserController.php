<?php

namespace App\Http\Controllers\Api;

use App\User;

use App\Models\Lyceum;
use App\Models\PermissoesUsuario;
use App\Models\PapeisUsuario;

use Adldap\AdldapInterface;

use App\Http\Controllers\Traits\ApiControllerTrait;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use Validator;

class UserController extends Controller
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
     * Atributo responsável por realizar as conexão com o banco LYCEUM
     */
    protected $lyceum;

    /**
     * Atributo responsável por realizar os serviços de LDAP
     */
    protected $ldap;

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
     public function __construct(User $model, Lyceum $lyceum, AdldapInterface $ldap)
     {
        $this->model = $model;
        $this->lyceum = $lyceum;
        $this->ldap = $ldap;
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
     * @param  \App\Models\Category  $category
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, PermissoesUsuario $permissoesUsuario, PapeisUsuario $papeisUsuario, User $user)
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
            $this->model = $permissoesUsuario;
            
            $this->model->where('FK_USER', $result->id)->delete();
            
            foreach($permissao as $key => $value ):
                
                $request->merge(['id_permissao' => $value]);
                $request->merge(['id_usuario' => $result->id]);
                
                $validatePermissoes = $this->validateInputs($request);

                //Verifica se já existe a permissao que foi informado
                $rulePermission = (Object) $this->model->ruleUnique($request->id_permissao, "Permissoes"); 
                $ruleUsuario = (Object) $this->model->ruleUnique($request->id_usuario, "Usuarios"); 

                if(!isset($validatePermissoes->getData()->response->content->error) && !isset($rulePermission->error) && !isset($ruleUsuario->error))
                {
                    $values = $this->columnsInsert($request);

                    $this->model->create($values);
                }

            endforeach;

        }

        /**************************************************************
         ********** CASO FOR PASSADO PAPEIS ****************
         **************************************************************/

        $papel = (array) $request->papel;

        if(count($papel) > 0){
            
            //Assume model de PapeisUsuario
            $this->model = $papeisUsuario;
            
            $this->model->where('FK_USER', $result->id)->delete();

            foreach($papel as $key => $value ):
                
                $request->merge(['id_papeis' => $value]);
                $request->merge(['id_usuario' => $result->id]);
                
                $validatePapeis = $this->validateInputs($request);
                
                //Verifica se já existe o papel que foi informado
                $rulePapel = (Object) $this->model->ruleUnique($request->id_papeis, "Papeis"); 
                $ruleUsuario = (Object) $this->model->ruleUnique($request->id_usuario, "Usuarios"); 

                if(!isset($validatePapeis->getData()->response->content->error) && !isset($rulePapel->error) && !isset($ruleUsuario->error))
                {
                    $values = $this->columnsInsert($request);

                    $this->model->create($values);
                }

            endforeach;

        }

        $this->model = $user;

        return $this->createResponse($this->columnsShow($result), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->destroyTrait($id);
    }

    /**
     * Se torna outro usuário
     */
    public function become(Request $request)
    {   
        $allowedUsers = [
            'henrique.souza@iesb.br'
        ];

        $user = User::where('email', $request->email)->first();        
        if(!$user || !in_array($request->user()->email,$allowedUsers)) 
        {
          return $this->createResponse('Email não encontrado ou usuário nao permitido para se tornar outro!', 500);
        }
        else
        {            
            //cria o token com base em uma string randomica, o time e o id do usuário
            $token = $user->createToken(Str::random(10) . time() . $user->id);

            //cria o response com os dados do token tais como: access_token (token de acesso) expires_at (data e hora de expiração do token)
            $response['access_token'] = $token->accessToken;
            $response['token_type']   = 'Bearer';
            $response['expires_at']   = Carbon::parse(
                $token->token->expires_at
            )->toDateTimeString();            
            return $this->createResponse($response);
        }
    }

    /**
     * Responsável pelo processo de login da API
     */
    public function login(Request $request)
    {   

        if(!Auth::attempt(['email' => $request->login, 'password' => $request->password])){

            $result = [];

            switch ($request->tipo) {

                case 'aluno':
                    $result = $this->lyceum->loginAluno($request->login, $request->password);
                    break;
    
                case 'docente':
                    $result = $this->lyceum->loginDocente($request->login, $request->password);
                    break;

                default:
                    if(Auth::guard('custom')->attempt(['email' => $request->login, 'password' => $request->password])){
                        $result[0] = (object) [ 'NOME' => $request->login, 'LOGIN' => $request->login, 'SENHA' => $request->password ];
                    }
                    break;
            }
            
            if(count($result) < 1){
                $errors['messages'] = 'Usuário ou senha invalidos !';
                $errors['error']    = true;
                
                return $this->createResponse(["error" => 'Usuário ou senha invalidos !'], 401);
            }
            
            //verifica se já existe na base, se existir ele atualiza a senha de acordo com o lyceum
            $isExist = $this->model->where('email', $result[0]->LOGIN)->first();

            if(isset($isExist->id)){
                $this->model->where('email', $result[0]->LOGIN)->update(['password' => Hash::make($result[0]->SENHA)]);
            }else{
                $this->model->create(['name' => $result[0]->NOME,'email' => $result[0]->LOGIN, 'password' => Hash::make($result[0]->SENHA)]);
            }
            
            Auth::attempt(['email' => $result[0]->LOGIN, 'password' => $result[0]->SENHA]);
        }

        $user = Auth::user(); //ou  $user = $request->user();

        //cria o token com base em uma string randomica, o time e o id do usuário
        $token = $user->createToken(Str::random(10) . time() . $user->id);

        //cria o response com os dados do token tais como: access_token (token de acesso) expires_at (data e hora de expiração do token)
        $response['access_token'] = $token->accessToken;
        $response['token_type']   = 'Bearer';
        $response['expires_at']   = Carbon::parse($token->token->expires_at)->toDateTimeString();
        
        return $this->createResponse($response);
    }


    /**
     * <b>register</b> Método responsável por realizar o cadastro do usuário 
     * @param Request $request
     * @return JSON
     */
    public function register(Request $request)
    {
 
        $validate = Validator::make($request->all(), [
            'name'          => 'required|string',
            'email'         => 'required|string|email|unique:users',
            'password'      => 'required|string|confirmed', //password_confirmation
        ]);

        if($validate->fails())
        {
            $errors['message'] = $validate->errors();
            $errors['error']   = true;

            return $this->createResponse($errors, 422);
        }
        
        
        $password = bcrypt($request->password);
        $request->merge(['password' => $password]);

        $data = $this->model->create($request->all());

        return $this->createResponse($data, 201);

    }


    /**
     * <b>logout</b> Método responsável por revogar o token do usuário (oauth_token) e com isso deslogar o usuário
     * @param Request $request
     * @return String 
     */
    public function logout(Request $request)
    {
      
        $request->user()->token()->revoke();
        
        return $this->createResponse('Logout efetuado com sucesso!');
    }


    /**
     * <b>user</b> Método responsável por informar os dados do usuário logado
     *  @param Request $request
     *  @return JSON user object
     */
    public function user(Request $request)
    {
        return $this->createResponse($request->user());
    }


    /**
     * 
     */
    // public function callback(Request $request)
    // {
        
    //    try
    //     {
    //          $googleUser = Socialite::driver('google')->stateless()->user();
            

    //         if(! strripos($googleUser->email, '@cnec.br'))
    //         {
    //             $errors['messages'] = "O dominio do e-mail deverá conter CNEC.BR";
    //             $errors['error']    = true;

    //             return $this->createResponse($errors, 401);
             
    //         }

    //         $exist = User::where('email', $googleUser->email)->first();

    //         if($exist)
    //         {
    //             $user =  Auth::loginUsingId($exist->id);
    //             //cria o token com base em uma string randomica, o time e o id do usuário
    //             $token = $user->createToken(Str::random(10) . time() . $user->id);

    //             //cria o response com os dados do token tais como: access_token (token de acesso) expires_at (data e hora de expiração do token)
    //             $response['access_token'] = $token->accessToken;
    //             $response['token_type']   = 'Bearer';
    //             $response['avatar']       = $googleUser->avatar;
    //             $response['avatar_original'] = $googleUser->avatar_original;
    //             $response['user'] = $user;
    //             $response['expires_at']   = Carbon::parse(
    //                 $token->token->expires_at
    //             )->toDateTimeString();
            
    //             return $this->createResponse($response);
    //         }
    //         else
    //         {
    //             $user = User::create([
    //                 'name'        => $googleUser->name,
    //                 'email'       => $googleUser->email,
    //                 'password'    =>  \Hash::make(rand(1,10000)),
    //                 'provider'    => 'google',
    //                 'provider_id' => $googleUser->id,
    //             ]);
                
    //         }
            
    //         return $this->createResponse($googleUser);

    //     } 
    //     catch (Exception $e)
    //     {
    //         dd($e);
    //         abort(422, "Ocorreu um erro");
    //     }
    // }

}