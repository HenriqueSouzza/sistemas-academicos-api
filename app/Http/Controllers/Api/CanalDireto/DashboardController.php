<?php

namespace App\Http\Controllers\Api\CanalDireto;

use App\Http\Controllers\Controller;
use App\Models\CanalDireto\Ticket;
use Illuminate\Http\Request;

use App\Http\Controllers\Traits\ApiControllerTrait;

class DashboardController extends Controller
{

    use ApiControllerTrait;

    private $model;

    public function __construct(Ticket $model)
    {
        $this->model = $model;
    }

    public function index(Request $request){

        $requested = $request->all();

        $requestedPermitted = ['ano', 'mes', 'dia', 'setor'];

        if(!array_intersect($requestedPermitted, array_keys($requested))):
            $error = ['message' => "Nenhum parâmetro passado"];
            return $this->createResponse($error, 422);
        endif;

        $requestAproved = array_intersect($requestedPermitted, array_keys($requested));

        $query = $this->model;

        foreach($requestAproved as $key => $value):
            switch ($value) {
                case 'dia':
                    $query = $query->whereDay('created_at', $requested[$value]);
                break;
                
                case 'mes':
                    $query = $query->whereMonth('created_at', $requested[$value]);
                break;
                
                case 'ano':
                    $query = $query->whereYear('created_at', $requested[$value]);
                    break;
                
                default:
                    $query = $query->where($value, $requested[$value]);
                break;
            }
        endforeach;
        
        if($query->count() < 1):
            return $this->createResponse([], 422);
        endif;
        
        $result = $query->get();


        $data['TicketAbertoFechadoMesAno'] = [];
        $data['ticketFechadosUsuario'] = [];
        $data['ticketCategoria'] = [];

        $countUsuario = 0;
        $countCategoria = 0;
        $countAbertoMesAno = 1;
        $countFechadoMesAno = 1;

        foreach($result as $key => $value):
            $ano = date_format(date_create($value->CREATED_AT), 'Y');
            $mes = date_format(date_create($value->CREATED_AT), 'm');


            /****************** TICKET ABERTOS E FECHADOS POR MES E ANO ******************/
            $data['TicketAbertoFechadoMesAno'][$ano][$mes]['ano'] = $ano;
            $data['TicketAbertoFechadoMesAno'][$ano][$mes]['mes'] = $mes;

            
            if(!isset($data['TicketAbertoFechadoMesAno'][$ano][$mes]['aberto'])){
                $data['TicketAbertoFechadoMesAno'][$ano][$mes]['aberto'] = $this->model->whereYear('CREATED_AT', $ano)
                                                                            ->whereMonth('CREATED_AT', $mes)
                                                                            ->whereIn('STATUS', [1,2,3])->count();

            }

            if(!isset($data['TicketAbertoFechadoMesAno'][$ano][$mes]['fechado'])){
                $data['TicketAbertoFechadoMesAno'][$ano][$mes]['fechado'] = $this->model->whereYear('CREATED_AT', $ano)
                                                                            ->whereMonth('DT_FECHAMENTO', $mes)
                                                                            ->whereIn('STATUS', [4,5])->count();
            }
            
            /****************** TICKET FECHADOS POR USUARIO ******************/
            if(!key_exists($value->USUARIO_FECHAMENTO, $data['ticketFechadosUsuario'])){
                $countUsuario = 1;
            }

            if($value->USUARIO_FECHAMENTO){
                $data['ticketFechadosUsuario'][$value->USUARIO_FECHAMENTO] = [
                    'usuario' => $value->USUARIO_FECHAMENTO,
                    'quantidade' => $countUsuario++
                ];
            }

            /****************** TICKETS POR CATEGORIA ******************/
            if(!key_exists($value->ID_CATEGORIA, $data['ticketCategoria'])){
                $countCategoria = 1;
            }

            $data['ticketCategoria'][$value->ID_CATEGORIA] = [
                'categoria' => $value->categoria->DESCRICAO,
                'quantidade' => $countCategoria++
            ];

        endforeach;
        $data['ticketFechadosUsuario'] = array_values($data['ticketFechadosUsuario']);
        $data['ticketCategoria'] = array_values($data['ticketCategoria']);
        $data['TicketAbertoFechadoMesAno'] = array_values($data['TicketAbertoFechadoMesAno']);

        foreach($data['TicketAbertoFechadoMesAno'] as $key => $value):
            $data['TicketAbertoFechadoMesAno'] = array_values($value);
        endforeach;

        return $this->createResponse($data, 200);
    }
}
