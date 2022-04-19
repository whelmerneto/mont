@extends('layouts.app')

@section('content')

<main class="col-sm-12 col-md-12 col-xl-12">
    <form action="{{url('reagendamento')}}" id="form-reagendamento" mothod="post">
        <input type="hidden" name="slt" value="{{$dados->slt_id}}">
    </form>
    <div class="row">
        <a href="{{url('index')}}" id="btn-inicio"> <i class="fas fa-angle-left"></i> <span>Início</span></a>
    </div>
    <div class="row" id="saudacao">
        <p>Olá <strong> {{$dados->slt_favorecido}}</strong> </p>
    </div>

    <div class="mt-5">
        <h1><strong> Acompanhar montagem </strong></h1>
    </div>

    <div class="mt-5">
        <h4><strong>Detalhes do agendamento</strong></h4>
    </div>

    <div class="row mt-2">
        <div class="col-sm-3 col-md-3 col-xl-3">
            @if(!is_null($dados->item->imagem))
            <img src="https://magazineluiza.lansolver.com/item/imagem?imagem={{$dados->item->imagem}}" alt="" style="height: 200px; width: 200px;">
            @else
            <img src="{{ asset('/storage/img/magalu.png' ) }}" alt="" style="height: 200px; width: 200px;">
            @endif
        </div>
        <div class="col-sm-3 col-md-3 col-xl-3">
            <span><strong>Produto:</strong></span>
            <div>
                <span>{{$dados->item->nome}}
                </span>
            </div>
            <div class="mt-5">
                <span><strong>Nome:</strong></span>
                <div><span>{{$dados->slt_favorecido}}</span></div>
            </div>
        </div>
        <div class="col-sm-3 col-md-3 col-xl-3">
            <span><strong>Endereço da montagem:</strong></span>
            <div>
                @if(!is_null($dados->local))
                <span>
                    {{$dados->local->loc_logradouro}}, {{$dados->local->loc_numero}} - {{$dados->local->loc_municipio}} 
                </span>
                @else
                <span>
                    teste 
                </span>
                @endif
            </div>
            <div class="mt-5">
                <span><strong>Telefone</strong></span>
                <div><span>{{$dados->favorecido->fav_telefone}}</span></div>
            </div>
        </div>
        <div class="col-sm-3 col-md-3 col-xl-3">
            <span><strong>Ponto de referência:</strong></span>
            <div>
                @if(!empty($dados->tarefas))
                <span>
                {{$dados->tarefas[0]->trf_observacao}}
                </span>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h4><strong>Situação da solicitação de montagem</strong></h4>
    </div>
    <div class="mt-3">
        <span><strong>Nome do montador:</strong></span>
        <div>
            @if(!empty($dados->tarefas))
            <span>{{$dados->tarefas[0]->tecnico->tec_nome}}</span>
            @else
            <span>Aguardando Confirmação</span>
            @endif
        </div>
    </div>

    <!-- Warning faltaram Peças -->
    <!-- <div class="row mt-5 alert alert-warning" id="warning" role="alert" >
        <div><i style="color:orange" class="fas fa-exclamation-triangle"></i></div>
        <div class="ml-3"><span><strong> Parece que faltaram algumas peças durante a montagem</strong></span></div>
        <div class="ml-3"><span>Por favor, aguarde o recebimento das novas peças e realize o agendamento de
uma nova visita usando o botão abaixo.</span></div>
    </div> -->
    <!-- Fim Warning faltaram Peças -->

    <div class="row mt-4">
        <button type="button" id="btn-reagendar" form="form" class="btn btn-default">
            Reagendar
        </button>
    </div>

</main>




<style>
.btn-default {
    font-weight: bold !important;
    background-color: #58c22e !important;
    color: white !important;
}
</style>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script>
    $(window).on("load", function(){
        var formReagendar = document.getElementById("form-reagendamento");
        $("#btn-reagendar").on('click', function() {
            formReagendar.submit();
        })
    })
</script>