<?php

namespace App\Mail;




use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\CanalDireto\Ticket;
use App\Models\CanalDireto\Categoria;
use App\Models\CanalDireto\Setor;
use App\Models\CanalDireto\InteracaoTicket;

class InteracaoTicketEmail extends Mailable
{

    

    use Queueable, SerializesModels;


    protected $ticket;

    protected $categoria;

    protected $setor;

    protected $interacao;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, Categoria $categoria, Setor $setor, InteracaoTicket $interacao)
    {

        $this->ticket = $ticket;

        $this->categoria = $categoria;

        $this->setor = $setor;

        $this->interacao = $interacao;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       
        return $this->markdown('canalDireto.interacaoTicket')
        ->with([
            'ticket' => $this->ticket,'categoria' => $this->categoria, 'setor' => $this->setor, 'interacao' => $this->interacao 
        ]);
    }
}
