@extends('layouts.app')

@section('content')

<main class="col-sm-12 col-md-12 col-xl-12">
    <div class="row">
        <a id="btn-inicio" href="{{url('index')}}" onClick=""> <i class="fas fa-angle-left"></i> <span>Início</span></a>
    </div>
    <div class="row" id="saudacao">
        <p>Olá <strong>{{$slt_favorecido}} </strong> </p>
    </div>

    <div class="text-center mt-5">
        <h1><strong> Anote a data! </strong></h1>
    </div>

    <div class="text-center m-auto col-sm-2 col-md-2 col-xl-2 col-lg-2 ">
    <img src="{{ asset('/storage/img/check.png')}}" id="check" alt="">
    </div>
    <div class="text-center m-auto col-sm-2 col-md-2 col-xl-2 col-lg-2 pt-5">
        <!-- <i class="fas fa-check-circle" style="position:absolute; z-index: 1; padding-left: 30px; font-size: 60px; color:green;"></i> -->
        <div class="card card-dia-agendado pt-2 pl-2 pm-2 pb-2" style="border-radius: 10px; background-color: #1789fc">
            <span>{{$dia}}</span>
            <h1>{{$dia_num}}</h1>
            <span>de {{$mes}}</span>
        </div>
    </div>

    <div class="row mt-5">
        <h1 class=" text-center m-auto"><strong> Montagem agendada com sucesso. </strong></h1>
    </div>
    <div class="col-sm-5 col-md-5 col-xl-5 pt-3 text-center m-auto">
        <span> Sua montagem será realizada na data agendada no período comercial </span>
        
        <div class="mt-3">
        <span><strong>Importante:</strong></span>
        </div>
        <span>
            O lugar onde seu produto será montado precisa estar livre, tá?
        </span>
        <br>
        <span>Ah, e é necessário uma pessoa maior de 18 anos para companhar o montador</span>

        <div class="mt-4">
            <a type="button" class="btn btn-default" id="btn-inicio" href="{{url('index')}}">Voltar para o Início</a>
        </div>
    </div>
</main>

@endsection

<style>
.card-dia-agendado {
    border:none;
    color: white;
}
#check {
    position:absolute;
    z-index: 1;
    margin-left:30px;
    margin-top:15px;
    height: 80px;
    border: none;
}
.btn-default {
    font-weight: bold !important;
    background-color: #58c22e !important;
    color: white !important;
}
@media only screen and (max-width: 420px) {
    .card-dia-agendado {
        margin: auto !important;
        width: 200px;
    }
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
