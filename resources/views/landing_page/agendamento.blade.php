@extends('layouts.app')

@section('content')
<form action="{{route('confirmacao')}}" method="post" id="form_agendar">
    {{csrf_field()}}
    <main class="col-sm-12 col-md-12 col-xl-12">
        <div class="row">
            <a href="{{url('/index')}}"> <i class="fas fa-angle-left"></i> <span>Início</span></a>
        </div>
        <div class="row" id="saudacao">
            <p>Ola <strong> {{$montagens[0][0]->slt_favorecido}}</strong> </p>
        </div>
        <div class="row mt-5">
            <h4><strong>1. Confira os detalhes da compra</strong></h4>
        </div>
        <div class="container" style="background-color: #ededed; border-radius: 5px;">
            <div class="row mt-3 mb-3 ml-2 pt-2">
                <h5> <strong> Produtos </strong></h5>
            </div>
            @foreach($montagens as $key => $dado)
            <div class="montagem pt-2 pb-2 d-flex">
                <div class="col-md-2 col-sm-2 col-xl-2 col-lg-2">
                    @if(!is_null($dado[0]->item->imagem))
                    <img src="https://magazineluiza.lansolver.com/item/imagem?imagem={{$dado[0]->item->imagem}}" alt="" style="height: 150px;">
                    @else
                    <img src="{{ asset('/storage/img/magalu.png' ) }}" alt="" style="height: 150px;">
                    @endif
                </div>
                <div class="col-sm-10 col-md-10 col-xl-10 col-lg-10">
                    <div class="item-nome">
                        <p><strong> {{$dado[0]->item->nome}} </strong></p>
                    </div>
                </div>
            </div>
            <input type="hidden" name="slt_integrationid[]" value="{{$slt_integrationid[$key]}}">
            <input type="hidden" name="cpf" value="{{$montagens[0][0]->favorecido->fav_cpf}}">
            <input type="hidden" name="chamado" value="{{$montagens[0][0]->slt_id}}">
            <div style="height:25px"></div>
            @endforeach
        </div>
        <div class="mt-5">
            <h5><strong> Endereço da montagem: </strong></h5>
        </div>
        <div><span>{{$dado[0]->local->loc_logradouro}}, {{$dado[0]->local->loc_numero}}, {{$dado[0]->local->loc_complementologradouro}}</span></div>
        <div><span> {{$dado[0]->local->loc_bairro}}, {{$dado[0]->local->loc_municipio}}</span></div>
        <div><span> {{$dado[0]->local->loc_estado}} {{$dado[0]->local->loc_cep}}</span></div>

        <div class="card mt-3" style="background-color: #ededed;">
            <div class="row pt-2 pr-2 pb-2 pl-2" style="border-radius: 5px">
                <div class="col-2 m-auto d-flex justify-content-center">
                    <img id="alert-circle" src="{{asset('storage/img/exclamation.png')}}" height="25px" alt="">
                </div>
                <div class="col-10">
                    <span> <strong> Não é seu endereço? </strong></span> 
                    <br>
                    <span> Fique tranquilo! Antes de prosseguir com o agendamento solicite a alteração pelo <strong> 0800 9431 900</strong>. </span>
                </div>
            </div>
        </div>
        
        <div class="mt-5 row col-sm-12 col-md-12 col-xl-12">
            <h5> <strong> 2. Escolha uma data </strong></h5>
        </div>
        <p>Todas as montagens serão feitas em horário comercial, de Segunda a Sexta entre 9:00 e 18:00hs.</p>
        
        <div class="card-deck mt-3 row col-sm-12 col-md-12 col-xl-12">
            @foreach($datas as $key => $data)
            @if(is_null($data->technicians[0]))
                <div class="card">
                    Não existem datas disponíveis no momento. Por favor, entre em contato com o nosso 0800.
                </div>
            @endif
            <label class="card card-dia text-center ml-2" for="{{$key}}">
                <input class="d-none" type="radio" id="{{$key}}" name="data_agendamento" value="{{$data->date}}" data-dia="{{$data->dayweek}}" data-mes="{{$mes}}" data-dianum="{{substr($data->date, 8)}}">
                <span class="dia">{{$data->dayweek}}</span>
                <h2 class="dia-num">{{substr($data->date, 8)}}</h2>
                <span class="dia">de {{$mes}}</span>
            </label>
            @endforeach
        </div>
        <input type="hidden" id="tecnico" name="tecnico[]" value="">

        <div class="form-group mt-5">
            <h5> <strong> 3. Informações adicionais </strong>(Opcional)</h5>
            <h5>Quem recebe o montador?</h5>
            <div class="mt-3">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Nome" name="nome_recebedor" id="nome_recebedor">
                </div>
                <div class="form-group mt-2">
                    <input type="text" class="form-control" placeholder="Telefone" name="telefone" id="telefone_recebedor">
                </div>
            </div>
            <div class="mt-4">
                <h5>
                    Informações complementares do seu endereço
                </h5>
            </div>
            <div class="form-group pt-2">
                <input type="text" class="form-control" placeholder="Complemento" name="ponto_referencia" id="referencia_recebedor">
            </div>

            <!-- <div class="row mt-2">
                <div class="col campos"><label for=""> Nome </label></div>
                <div class="col campos"><label for=""> Telefone com DDD </label></div>
                <div class="col campos"><label for=""> Ponto de referência </label></div>
            </div>
            <div class="row mt-2">
                <div class="col"><input class="form-control" type="text" name="nome_recebedor" ></div>
                <div class="col"><input class="form-control" type="text" name="telefone"></div>
                <div class="col"><input class="form-control" type="text" name="ponto_referencia"></div>
            </div> -->

            <button disabled id="agendar_montagem" type="button" class="col-sm-3 col-md-3 col-xl-3  btn btn-default mt-5" data-toggle="modal" data-target="#modalAgendamento"> Agendar montagem </button>
        </div>

        <!-- Modal Confirmar Agendamento-->
        <div class="modal fade col-sm-12 col-md-12 col-xl-12" id="modalAgendamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Confirmação </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body ml-4">
                        <div class="row">
                            <p class="mt-3"><strong> Confirmar agendamento da montagem? </strong></p>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xl-4" style="height: 50%;">
                                <div class="card-body card-dia-agendado text-center">
                                    <span id="dia-card" class="dia"></span>
                                    <h2 id="dia-num-card" class="dia-num"></h2>
                                    <span id="mes-card" class="dia"></span>
                                    <div class="d-none">
                                        <div id="append1"></div>
                                        <div id="append2"></div>
                                        <div id="append3"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-8 col-xl-8 mt-3">
                                <div class="mt-2">
                                    <span><strong>Quem recebe o montador</strong></span>
                                </div>
                                <span id="recebe_montador"></span>
                                <div class="mt-2">
                                    <span><strong>Telefone</strong></span>
                                </div>
                                <span id="recebe_telefone"></span>
                                <div class="mt-2">
                                    <span><strong>Complemento</strong></span>
                                </div>
                                <span>BL 1</span>
                                <div class="mt-2" >
                                    <span><strong>Ponto de referência</strong></span>
                                </div>
                                <span id="recebe_referencia"></span>
                                <div>
                                    <span><strong>Horário</strong></span>
                                </div>
                                <span>Entre 9:00 e 18:00hs</span>
                                <div class="mt-2">
                                    <span><strong> Endereço da montagem: </strong></span>
                                </div>
                                <div><span>{{$dado[0]->local->loc_logradouro}}, {{$dado[0]->local->loc_numero}}, {{$dado[0]->local->loc_complementologradouro}}</span></div>
                                <div><span> {{$dado[0]->local->loc_bairro}}, {{$dado[0]->local->loc_municipio}}</span></div>
                                <div><span> {{$dado[0]->local->loc_estado}} {{$dado[0]->local->loc_cep}}</span></div>
                                <div class="card mt-3" style="background-color: #ededed;">
                                    <div class="row pt-2 pr-2 pb-2 pl-2" style="border-radius: 5px">
                                        <div class="col-2 m-auto d-flex justify-content-center">
                                            <img id="alert-circle" src="{{asset('storage/img/exclamation.png')}}" height="25px" alt="">
                                        </div>
                                        <div class="col-10">
                                            <span> <strong> Não é seu endereço? </strong></span> 
                                            <br>
                                            <span> Fique tranquilo! Antes de prosseguir com o agendamento solicite a alteração pelo <strong> 0800 9431 900</strong>. </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-inline text-right mr-2">
                        <button class="btn mt-2" style="color: black;" data-dismiss="modal" > Voltar </button>
                        <button class="btn btn-default2 mt-2"> Confirmar </button>
                    </div>
                    <br>
                </div>
            </div>
        </div>

    </main>
<form>

<style>
    .montagem {
        background-color: white;
        margin: 5px 10px 5px 10px;
        border-radius: 5px;
    }
    .radio_teste{
        position:absolute;
        margin-left: 20px;
        margin-top: 20px;
        height: 40px;
        width: 50px;
        /* opacity: 0; */
        cursor: pointer;
    }
    #entre-aqui {
        color: #58c22e;
    }
    .card-dia {
        background-color: #e3e1e1;
        border:none;
        cursor: pointer;
    }

    .card-dia-agendado {
        background-color: #1789fc;
        border:none;
        color: white;
        border-radius: 10px;
    }
    .dia{
        padding: 8px 0 8px 0;
    }
    .dia-num{
        font-weight: 800;
    }
    .invisivel {
        visibility: hidden;
    }
    .campos {
        font-weight: bold;
    }
    .btn-default {
        font-weight: bold;
        background-color: #58c22e;
        color: white;
    }
    .btn-default2 {
        font-weight: bold;
        background-color: #58c22e;
        color: white;
    }

    .modal-header {
        background-color:#1789fc;
        color: white;
    }
    .item-nome {
        margin: 60px 0 0 0;
    }
    @media only screen and (max-width: 420px) {
        #alert-circle{
            margin: -44px 0 0 40px !important;
            height: 20px !important;
        }
        .item-nome {
            margin: 20px 0 0 0;
        }
        .invisivel {
            display:none;
        }
        .card-dia-agendado {
        width: 250px;
        background-color: #1789fc;
        border:none;
        color: white;
        border-radius: 5px;
        }
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script>
    function select(elemento) {
        elemento.on('click', function() {
            this.css('background-color', 'black')
        })
    }

    //script exibe warning
    $('#agendar_montagem').click(function () {
        $('#warning').css('display', 'flex')
    })

    $(".card-dia").on("click", function() {
        $(".card-dia").css("background", "#e3e1e1");
        $(".card-dia").css("color", "black");
        $(this).css("background", "#1789fc");
        $(this).css("color", "white");
        $("#agendar_montagem").attr("disabled",false);
    }); 


//  Script que insere o valor para o input hidden
// if($('#0').is(':checked')) {    
//     alert('deu');
// }
$('#0').on('click', function () {
    $('#tecnico').val(`{{$datas[0]->technicians[0]->tec_integrationid}}`)
})
$('#1').on('click', function () {
    $('#tecnico').val(`{{$datas[1]->technicians[0]->tec_integrationid}}`)
})
$('#2').on('click', function () {
    $('#tecnico').val(`{{$datas[2]->technicians[0]->tec_integrationid}}`)
})
$('#3').on('click', function () {
    $('#tecnico').val(`{{$datas[3]->technicians[0]->tec_integrationid}}`)
})
$('#4').on('click', function () {
    $('#tecnico').val(`{{$datas[4]->technicians[0]->tec_integrationid}}`)
})
$('#5').on('click', function () {
    $('#tecnico').val(`{{$datas[5]->technicians[0]->tec_integrationid}}`)
})
$('#6').on('click', function () {
    $('#tecnico').val(`{{$datas[6]->technicians[0]->tec_integrationid}}`)
})

//  Mascara no input de telefone
$('#telefone_recebedor').mask('(00) 00000-0000');


// Script para mostrar os dados inseridos no modal
// inserindo nome      
$('input[name="nome_recebedor"]').keyup(function(){
  console.log($(this).val());
  $('#recebe_montador').text($(this).val())
});

//  Inserindo Telefone
$('input[name="telefone"]').keyup(function(){
  console.log($(this).val());
  $('#recebe_telefone').text($(this).val())
});

//  Inserindo ponto de referencia
$('input[name="ponto_referencia"]').keyup(function(){   
    console.log($(this).val());
  $('#recebe_referencia').text($(this).val())
});


//  Script pra alterar os dados do card de agendamento

$('#agendar_montagem').on('click', function() {
    console.log('clicou')
    var dia = $('input[type=radio][name=data_agendamento]:checked').data('dia');
    var mes = $('input[type=radio][name=data_agendamento]:checked').data('mes');
    var dia_num = $('input[type=radio][name=data_agendamento]:checked').data('dianum');
    console.log(dia, mes, dia_num)

    document.getElementById('dia-card').textContent = dia
    document.getElementById('mes-card').textContent = mes
    document.getElementById('dia-num-card').textContent = dia_num
    
    // Incluindo hidden pra mandar as datas do agendamento
    var input_dia = `
    <input type="hidden" name="dia" value="${dia}">
    `;
    
    var input_mes = `
    <input type="hidden" name="mes" value="${mes}">
    `;
    
    var input_dia_num = `
    <input type="hidden" name="dia_num" value="${dia_num}">
    `;

    $('#append1').append(`<input type="hidden" name="dia" value="${dia}">`);
    $('#append2').append(`<input type="hidden" name="dia_num" value="${dia_num}">`);
    $('#append3').append(`<input type="hidden" name="mes" value="${mes}">`);
})

</script>
@endsection
