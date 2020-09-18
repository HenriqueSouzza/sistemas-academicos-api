@component('mail::message')
# HELP DESK - IESB

Olá {{ $ticket->USUARIO }}.

Recebemos o seu Ticket nº <b>{{ $ticket->ID }}</b>

@component('mail::panel')
## Detalhes da Solicitação

<p><b>Setor:</b> {{ $setor->DESCRICAO }}</p>

<p><b>Categoria:</b> {{ $categoria->DESCRICAO }}</p>

<p><b>Assunto:</b> {{ $ticket->ASSUNTO }}</p>

<p><b>Solicitacao:</b> {{ $ticket->MENSAGEM }}</p>

<p><b>Data de Solicitacao:</b> {{ date( 'd/m/Y H:i' , strtotime($ticket->CREATED_AT))}}</p>

@endcomponent



@endcomponent
