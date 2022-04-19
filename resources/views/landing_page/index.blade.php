@extends('layouts.app')

@section('content')
    <!-- Saudação -->

    <main class="col-sm-12 col-md-12 col-xl-12">
        <div class="ml-3">
            <div class="row" id="saudacao">
                <!-- incluir blade com o nome -->
                <p>Olá, <strong> {{$dados[0]->slt_favorecido}}</strong> </p>
            </div>
            
            <div class="row mt-5">
                <h1 id="title-mobile"><strong>Central de Montagem</strong></h1>
            </div>

            <div class="row mt-5">
                <div>
                    <h5 id="sub-title-mobile" style="color:#636363;">Produtos disponíveis para agendamento</h5>
                </div>
            </div>
        </div>
        <hr>
        <!-- Cards Montagens -->
        <form action="{{route('agendamento')}}" method="post" id="form_agendar">
            {{ csrf_field() }}
            <div id="append_cards">
                <div id="card_todas">
                <div class="card-deck mt-3 col-sm-12 col-md-12 col-xl-12" >
                    @foreach($dados as $key => $dado)
                    @if($dado->slt_status == "Aguardando agendamento" || $dado->slt_status == "Aguardando Reagendamento" || $dado->slt_status == "Aguardando Montagem")
                    <label {!! $dado->slt_status == "Aguardando agendamento" || $dado->slt_status == "Aguardando Reagendamento" ? "class='card aguardando-agendamento'" : "class='card'" !!} for="{{$dado->slt_id}}">
                        <div class="card-body text-center">
                            @if(!is_null($dado->item->imagem))
                            <img src="https://magazineluiza.lansolver.com/item/imagem?imagem={{$dado->item->imagem}}" alt="" style="height: 200px; width: 200px;">
                            @else
                            <img src="{{ asset('/storage/img/magalu.png' ) }}" alt="" style="max-height: 200px; max-width: 200px;">
                            @endif
                            <div class="item-description mt-3">
                                <p> {{$dado->item->nome}} </p>
                            </div>
                            <div class="">
                                <span class="agendamento-label">Data do Agendamento</span>
                                @if($dado->slt_status == "Aguardando Pagamento")
                                <p>Aguardando Pagamento</p>
                                @elseif($dado->slt_status == "Aguardando Montagem")
                                <p>{{date('d-m-Y', strtotime($dado->tarefas[0]->trf_datahorainicio))}}</p>
                                @elseif($dado->slt_status == "Aguardando agendamento" || $dado->slt_status == "Aguardando Reagendamento")
                                <img src="{{ asset('/storage/img/check.png')}}" class="check" alt="">
                                <p>Aguardando Agendamento</p>
                                @endif
                            </div>
                        </div>
                        @if($dado->slt_status == "Aguardando agendamento" || $dado->slt_status == "Aguardando Reagendamento")
                        <?php $botao = 1; ?>
                        <input type="checkbox" class="d-none aguardando" style="border-radius: 50px; position: absolute" id="{{$dado->slt_id}}" value="{{$dado->slt_id}}" name="slt[]">
                        <!-- <div class="card-footer" style="background-color: #58c22e;"> -->
                            <!-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalAgendamento">Agendar Montagem</button> -->
                        <!-- </div> -->
                        @elseif($dado->slt_status == "Aguardando Pagamento")
                        <div class="">
                            <button type="button" class="btn btn-card"> Aguardando Pagamento </button>
                        </div>
                        @elseif($dado->slt_status == "Aguardando Montagem")
                        <div class="card_footer">
                            <a href="{{route('acompanhar', $dado->slt_id)}}"><button type="button" class="btn btn-card"> Acompanhar </button></a>
                        </div>
                        @endif
                    </label>
                    @endif
                    @endforeach
                </div>
                @if(isset($botao) && $botao == 1)
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-auto pt-5">
                    <button disabled type="button" id="btn-modalAgendamento" class="btn btn-default" data-toggle="modal" data-target="#modalAgendamento" style="height:49px;border-radius:8px;background-color: #28a745;">Agendar Montagem</button>
                </div>
                @endif
                </div>
            </div>
        </form>
        <!-- Fim Cards montagem -->


        <div class="mt-5">
            <p>
                Ver o historico de montagens anteriores 
                <button class="dropdown-historico" type="button" data-toggle="collapse" data-target="#collapse_historico" aria-expanded="false" aria-controls="collapse_historico">
                    <i class="fas fa-chevron-down"></i>
                </button> 
            </p>    
            <div class="collapse" id="collapse_historico">
                <div class="">
                    @php
                        $zero = 0;
                    @endphp
                    @foreach(array_chunk($pedidos_anteriores,3) as $key => $dadoChuck)

                        <div class="row">
                            <div class="card-deck mt-3 col-sm-12 col-md-12 col-xl-12">
                               
                                @foreach($dadoChuck as $key => $dado)
                                    @if($dado->slt_status != "Aguardando Montagem" && $dado->slt_status != "Aguardando agendamento" && $dado->slt_status != "Aguardando Pagamento")
                                    <?php $zero = $zero +1; ?>
                                    <div class="card" id="{{$dado->slt_id}}">
                                        <div class="card-body text-center">
                                            @if(!is_null($dado->item->imagem))
                                                <img src="https://magazineluiza.lansolver.com/item/imagem?imagem={{$dado->item->imagem}}" alt="" style="height: 200px; width: 200px;">
                                            @else
                                                <img src="{{ asset('/storage/img/magalu.png' ) }}" alt="" style="max-height: 200px; max-width: 200px;">
                                            @endif
                                            <div class="item-description mt-3">
                                                <p>{{$dado->item->nome }}</p>
                                            </div>
                                            <div class="">
                                                <span class="agendamento-label">Data do Agendamento</span>
                                                @if($dado->slt_status == 'Cancelado')
                                                <p>Cancelado</p>
                                                @elseif(empty($dado->tarefas))
                                                <p>Não agendado</p>
                                                @else
                                                <p> {{date('d-m-Y', strtotime($dado->created_at->date))}}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            
                             
                            </div>
                        </div>
                    @endforeach
                     
                        @if($zero == 0)
                        <div class="row">
                            <div class="card-deck mt-3 col-sm-12 col-md-12 col-xl-12">
                                <div class="card" style="background: #eceaea;">
                                    <p class="mt-3 mb-3 mr-3 ml-3" >
                                        Não existem montagens anteriores
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Agendar Montagem-->
        <div class="modal fade" id="modalAgendamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Confirmação </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('/storage/img/truck.png' ) }}" alt="" height="80px">
                        <div class="mt-4">
                            <h3 style="padding:0 15px 0 15px;color:#4da5ff;"><strong> Você já recebeu seu(s) produto(s)? </strong></h3>
                        </div>
                        <div class="mt-5">
                                <button form="form_agendar" id="btn-agendar-mobile" class="btn btn-success" style="border-radius:8px;height: 55px;font-weight:bolder"> Continuar agendamento</button>
                        </div>
                        <div>
                            <button class="btn mt-2" style="color: black;" data-dismiss="modal"> Agendar depois </button>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <style>
    .card {
        border-radius: 15px;

    }
    .card_footer {
        border-top: 0.5px solid #ededed;
        height: 50px;
    }
    .check {
        position: absolute;
        z-index: 1;
        margin-left: 50px;
        height: 80px;
        border: none;
        margin-top: -260px;
        display:none;
    }   
    .card-deck {
        padding: 20px 15px 20px 15px;
        background-color: #ededed;
        border-radius: 10px;
    }
    .aguardando-agendamento {
        border-radius: 15px;
        cursor: pointer;
    }    
    .aguardando-agendamento:hover {
        transition: all .3s ease;
        -webkit-transition: all .3s ease;
        border: 1px solid black;
    }
    .main-title{
        font-family: Reboto Bold;
        font-size: 42px;
        line-height: 100%;
        letter-spacing: -2%;
    }
    .btn-filter {
        border-radius: 15px;
    }
    .btn-default {
        width: 100%;
        height: 100%;
        font-weight: bold;
        background-color: #58c22e;
        color: white;
    }
    .btn-card {
        width: 100%;
        height: 100%;
        font-weight: bold;
        color: #58c22e;
    }
    .btn-confirm-modal {
        font-weight: bold;
        background-color: #58c22e;
        color: white;
    }
    .card-footer {
        background-color: white;
    }
    .item-description {
        font-weight: bold;
        height: 50px;
    }
    .agendamento-label {
        font-weight: bold;
    }
    .dropdown-historico {
        background-color: white;
        border: none;
    }
    .modal-header {
        background-color:#1789fc;
        color: white;
    }
    .btn-agendar-mobile{
        height:55px;
    }

    @media only screen and (max-width: 420px) {
   #title-mobile {
    font-size: 35px !important;
   }
   #sub-title-mobile{
    font-size: 35px;
   }
   .check {
    position: absolute;
    z-index: 1;
    height: 70px;
    border: none;
    margin-top: -271px;
    margin-left: auto;
    }
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>

<script>
    //  Script de seleção de cards
    $(".btn-filter").on("click", function() {
        $(".btn-filter").css("background", "#f2f2f2");
        $(this).css("background", "#d4d4d4");
    });

    // Preperando conteudo para o append
    const append_nao_agendadas = `
    
            <div id="card_nao_agendadas">
                <div class="card-deck mt-3 col-sm-12 col-md-12 col-xl-12" >
                    @foreach($dados as $key => $dado)
                    @if($dado->slt_status == "Aguardando agendamento")
                    <label class='card aguardando-agendamento' for="{{$dado->slt_id}}">
                        <div class="card-body text-center">
                            @if(!is_null($dado->item->imagem))
                            <img src="https://magazineluiza.lansolver.com/item/imagem?imagem={{$dado->item->imagem}}" alt="" style="height: 200px; width: 200px;">
                            @else
                            <img src="{{ asset('/storage/img/guardaroupa.JPG' ) }}" alt="" style="height: 200px; width: 200px;">
                            @endif
                            <div class="item-description mt-3">
                                <p> {{$dado->item->nome}} </p>
                            </div>
                            <div class="">
                                <span class="agendamento-label">Data do Agendamento</span>
                                @if($dado->slt_status == "Cancelado" || $dado->slt_status == "Aguardando Pagamento")
                                <p>Não agendado</p>
                                @elseif($dado->slt_status == "Aguardando agendamento")
                                <p>Aguardando Agendamento</p>
                                @else
                                <p>{{date('d-m-Y', strtotime($dado->created_at->date))}}</p>
                                @endif
                            </div>
                        </div>
                        @if($dado->slt_status == "Aguardando agendamento")
                        <?php $botao = 1; ?>
                        <input type="checkbox" class="d-none aguardando" style="border-radius: 50px; position: absolute" id="{{$dado->slt_id}}" value="{{$dado->slt_id}}" name="slt[]">
                        <!-- <div class="card-footer" style="background-color: #58c22e;"> -->
                            <!-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalAgendamento">Agendar Montagem</button> -->
                        <!-- </div> -->
                        @endif
                    </label>
                    @endif
                    @endforeach
                </div>
                @if(isset($botao) && $botao == 1)
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-auto pt-5">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalAgendamento" style="height:49px;border-radius:8px;background-color: #1789fc;">Agendar Montagem</button>
                </div>
                @endif
            </div>
    `

    const append_agendadas = `
    <div class="card-deck mt-3 col-sm-12 col-md-12 col-xl-12" id="card_agendadas">
        @foreach($dados as $key => $dado)
        @if($dado->slt_status == "Aguardando Montagem")
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ asset('/storage/img/guardaroupa.JPG' ) }}" alt="" style="height: 200px; width: 200px;">
                <div class="item-description mt-3">
                    <p> {{$dado->item->nome}} </p>
                </div>
                <div class="">
                    <span class="agendamento-label">Data do Agendamento</span>
                    @if(empty($dado->tarefas))
                    <p>Não agendado</p>
                    @else
                    <p>{{date('d-m-Y', strtotime($dado->tarefas[0]->created_at->date))}}</p>
                    @endif
                </div>
            </div>
            @if($dado->slt_status == "Aguardando Agendamento")
            <div class="card-footer" style="background-color: #58c22e;">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalAgendamento" >Agendar Montagem</button>
            </div>
            @elseif($dado->slt_status == "Aguardando Montagem")
            <div class="card-footer">
                <a href="{{route('acompanhar', $dado->slt_id)}}"><button type="button" class="btn btn-card"> Acompanhar </button></a>
            </div>    
            @endif
        </div>  
        @endif
        @endforeach
    </div>`

    const append_todas = `
        
            <div id="card_todas">
                <div class="card-deck mt-3 col-sm-12 col-md-12 col-xl-12" >
                    @foreach($dados as $key => $dado)
                    @if($dado->slt_status != "Cancelado")
                    <label {!! $dado->slt_status == "Aguardando agendamento" ? "class='card aguardando-agendamento'" : "class='card'" !!}  for="{{$dado->slt_id}}">
                        <div class="card-body text-center">
                            @if(!is_null($dado->item->imagem))
                            <img src="https://magazineluiza.lansolver.com/item/imagem?imagem={{$dado->item->imagem}}" alt="" style="height: 200px; width: 200px;">
                            @else
                            <img src="{{ asset('/storage/img/guardaroupa.JPG' ) }}" alt="" style="height: 200px; width: 200px;">
                            @endif
                            <div class="item-description mt-3">
                                <p> {{$dado->item->nome}} </p>
                            </div>
                            <div class="">
                                <span class="agendamento-label">Data do Agendamento</span>
                                @if($dado->slt_status == "Cancelado" || $dado->slt_status == "Aguardando Pagamento")
                                <p>Não agendado</p>
                                @elseif($dado->slt_status == "Aguardando agendamento")
                                <p>Aguardando Agendamento</p>
                                @else
                                <p>{{date('d-m-Y', strtotime($dado->created_at->date))}}</p>
                                @endif
                            </div>
                        </div>
                        @if($dado->slt_status == "Aguardando agendamento")
                        <?php $botao = 1; ?>
                        <input type="checkbox" class="d-none aguardando" style="border-radius: 50px; position: absolute" id="{{$dado->slt_id}}" value="{{$dado->slt_id}}" name="slt[]">
                        <!-- <div class="card-footer" style="background-color: #58c22e;"> -->
                            <!-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalAgendamento">Agendar Montagem</button> -->
                        <!-- </div> -->
                        @elseif($dado->slt_status == "Aguardando Montagem")
                        <div class="card-footer">
                            <a href="{{route('acompanhar', $dado->slt_id)}}"><button type="button" class="btn btn-card"> Acompanhar </button></a>
                        </div>
                        @elseif($dado->slt_status == "Aguardando Pagamento")
                        <div class="card-footer">
                            <button type="button" class="btn btn-card"> Aguardando Pagamento </button>
                        </div>
                        @else
                        <div class="card-footer">
                            <button type="button" class="btn btn-card">{{$dado->slt_status}}, entre em contato pela central. </button>
                        </div>
                        @endif
                    </label>
                    @endif
                    @endforeach
                </div>
                @if(isset($botao) && $botao == 1)
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-auto pt-5">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalAgendamento" style="height:49px;border-radius:8px;background-color: #1789fc;">Agendar Montagem</button>
                </div>
                @endif
            </div>
           `
    
    //Script para o append de agendadas
    $('#btn_agendadas').on('click', function () {
        $('#card_todas').remove();
        $('#card_agendadas').remove();
        $('#card_nao_agendadas').remove();
        $('#append_cards').append(append_agendadas)
    });

    //Script para o append de todas as montagens
    $('#btn_todas').on('click', function () {
        $('#card_todas').remove();
        $('#card_agendadas').remove();
        $('#card_nao_agendadas').remove();
        $('#append_cards').append(append_todas)
        $(".aguardando-agendamento").on("click", function() {
            if ($(this).css("background-color") == "rgb(255, 255, 255)") {
                $(this).css("background-color", "rgb(214, 214, 214)"); 
                $(this).css("box-shadow", "rgba(0, 0, 0, 0.25) 0px 5px 15px");
            } else if ($(this).css("background-color") == "rgb(214, 214, 214)") {
                $(this).css("background-color", "rgb(255, 255, 255)");
                $(this).css("box-shadow", "rgba(0, 0, 0, 0) 0px 0px 0px");
            
            }   
        }); 
    });

    //Script para o append de não agendadas
    $('#btn_nao_agendadas').on('click', function () {
        $('#card_todas').remove();
        $('#card_agendadas').remove();
        $('#card_nao_agendadas').remove();
        $('#append_cards').append(append_nao_agendadas)
        $(".aguardando-agendamento").on("click", function() {
            if ($(this).css("background-color") == "rgb(255, 255, 255)") {
                $(this).css("background-color", "rgb(214, 214, 214)"); 
                $(this).css("box-shadow", "rgba(0, 0, 0, 0.25) 0px 5px 15px");
            } else if ($(this).css("background-color") == "rgb(214, 214, 214)") {
                $(this).css("background-color", "rgb(255, 255, 255)");
                $(this).css("box-shadow", "rgba(0, 0, 0, 0) 0px 0px 0px");
            
            }   
        }); 
    });
    
    $('').fadeOut(500, function(){ $(this).remove();});

    
    $(document).ready(function() {
        $(".aguardando-agendamento").on("click", function() {
            if ($(this).css("background-color") == "rgb(255, 255, 255)") {
                $(this).css("background-color", "rgb(225, 236, 252)"); 
                $(this).css("box-shadow", "rgba(0, 0, 0, 0.25) 0px 5px 15px");
                jQuery(".check", this).show();
                $("#btn-modalAgendamento").attr("disabled",false)
            } else if ($(this).css("background-color") == "rgb(225, 236, 252)") {
                $(this).css("background-color", "rgb(255, 255, 255)");
                $(this).css("box-shadow", "rgba(0, 0, 0, 0) 0px 0px 0px");
                jQuery(".check", this).hide()
                if($(".check[style='display: inline;']").length == 0){
                    $("#btn-modalAgendamento").attr("disabled",true)
                }
            }   
        }); 
    })

</script>
@endsection

