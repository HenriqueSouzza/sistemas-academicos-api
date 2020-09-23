<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Models\Permissoes;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
          * <b>Passport</b> Definição de duração de token, rotas para autenticação via API 
          */
        Passport::routes();//routes passport
        Passport::tokensExpireIn(Carbon::now()->addDays(15));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

        /**
        * <b>Permission::with('roles')->get();</b> Recuperar os dados do relacionamento entre a tabela de permissão e a tabela de papeis
        * Tem como parametro o nome do relacionamento que esta na model de permission
        * verifica se possui a tabela antes de realizar as verificações 
        * Essa ação evita erros caso a tabela não exista na hora de rodar a migration
        */ 
        
        $table = "PERMISSOES";

        $count =  DB::select("SELECT * FROM information_schema.tables WHERE TABLE_NAME = '$table'");

        if(count($count))
        {
            $permissions = Permissoes::with('Papeis')->get();

            foreach( $permissions as $permission )
            {
                Gate::define($permission->PERMISSAO, function(User $user) use ($permission){
                    return $user->hasPermission($permission) ;
                });
            }
            
            /**
            * <b> Gate::before</b> Caso o usuário tenha papel de administrador irá passar direto sem passar pelo gate acima
            */
            Gate::before(function(User $user, $ability)
            {
                if( $user->hasAnyRoles('Administrador') )
                {
                    //if( $user->hasAnyRoles('1') )
                    return true;
                }
            });

        }
    }
}
