@extends('layouts.app')

@section('content')

<main class="col-sm-12 col-md-12 col-xl-12">
    <div class="row">
        <a id="btn-inicio" href="{{url('index')}}" onClick=""> <i class="fas fa-angle-left"></i> <span>Início</span></a>
    </div>
    <div class="row" id="saudacao">
    </div>

    <div class="text-center mt-12">
        <h1><strong> Ops! Ocorreu um erro</strong></h1>
        <img src="{{ asset('/storage/img/alert.png')}}" width="200px" alt="">
    </div>



    <div class="row mt-5">
        <h1 class=" text-center m-auto"><strong> Entre em contato com 0800 9431 900</strong></h1>
    </div>
    <div class="col-sm-5 col-md-5 col-xl-5 pt-3 text-center m-auto">
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
