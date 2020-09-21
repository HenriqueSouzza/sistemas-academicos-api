@component('mail::message')
# HELP DESK - IESB

Olá {{ $ticket->USUARIO }}.

Temos novidades sobre seu ticket nº <b>{{ $ticket->ID }}</b>

@component('mail::panel')
## Detalhes da Solicitação

<p><b>Setor:</b> {{ $setor->DESCRICAO }}</p>

<p><b>Categoria:</b> {{ $categoria->DESCRICAO }}</p>

<p><b>Assunto:</b> {{ $ticket->ASSUNTO }}</p>

<p><b>Solicitacao:</b> {{ $ticket->MENSAGEM }}</p>

<p><b>Data de Solicitacao:</b> {{ date( 'd/m/Y H:i' , strtotime($ticket->CREATED_AT))}}</p>

@endcomponent

@component('mail::panel')

<p><b>Mensagem:</b> {{ $interacao->MENSAGEM }}</p>
<p><b>Usuário:</b> {{ $interacao->USUARIO_INTERACAO }}</p>
<p><b>Data de Solicitacao:</b> {{ date( 'd/m/Y H:i' , strtotime($interacao->CREATED_AT))}}</p>


@endcomponent





@endcomponent
