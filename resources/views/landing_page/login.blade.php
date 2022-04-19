<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/css/fontawesome/css/all.css')}}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{url("/")}}/favicon.ico">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Montagem Magalu</title>
    
</head>
<body>
    <div class="col-md-12 col-sm-12 col-lg-12 col-sm-12 mt-5">
        @if (\Session::has('error'))
        <div class="text-center d-flex justify-content-center">
            <div class="card" style="background-color: #ffcfcc;">
            {!! \Session::get('error') !!}
            </div>
        </div>
        @endif
        <div class="form-signin text-center d-flex justify-content-center pt-5">
            <div class="card">
                <div class="pb-2">
                    <h1 class="titulo-login"> Central de Montagem</h1>
                </div>
                <div class="mobile-only">
                    <img class="logo-login" src="{{ asset('/storage/img/logo.png') }}" alt="" width="300px" max-width: 100% >
                </div>
                <hr>
                <form action="{{url('/login')}}" id="form_login" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <h5 class="fw-normal">Insira seus dados para prosseguir</h5>
                    <div class="form-floating pt-2">
                        <label for="input_email">*CPF / CNPJ</label>
                        <input type="text" name="cpf" class="form-control" id="input_cpf" autocomplete="off" placeholder="123.456.789-00" required>
                    </div>
                    <br>
                    <Label>Informe o <b>número do pedido</b> ou sua <b>data de nascimento</b></Label>
                    <div class="form-floating pt-2">
                        <label for="floatingPassword">*Número do Pedido</label>
                        <input type="text" class="form-control" id="floatingPassword" autocomplete="off" name="chamado" required>
                    </div>
                    OU
                    <div class="form-floating pt-2">
                        <label for="floatingPassword">*Data de Nascimento</label>
                        <input type="date" class="form-control" id="data_nascimento" autocomplete="off" name="data_nascimento" required>
                    </div>
                    <div class="mt-3 mb-2">
                        <button id="btn-entra" class=" btn btn-primary" type="submit">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        img {
            margin: auto;
        }

        @media only screen and (max-width: 360px) {
            .logo-login{
                width: 250px
            }

            .titulo-login {
                font-size: 30px
            }
        }

        input { 
        text-align: center; 
        }
        body {
            background-color: #0086ff;
        }
        .card {
            border-radius: 10px;
            padding: 25px 80px 25px 80px;
        }
        @media only screen and (max-width: 420px) {

            .mobile-only {
                margin-left: -35px !important;            
            }
        }
    </style>
</body>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script>
//  Mask CPF
// $('#input_cpf').mask('000.000.000-00');

var options = {
    onKeyPress: function (cpf, ev, el, op) {
        var masks = ['000.000.000-000', '00.000.000/0000-00'];
        $('#input_cpf').mask((cpf.length > 14) ? masks[1] : masks[0], op);
    }
}

$('#input_cpf').length > 11 ? $('#input_cpf').mask('00.000.000/0000-00', options) : $('#input_cpf').mask('000.000.000-00#', options);



$("#floatingPassword").keyup(function() {
    if($("#floatingPassword").val()){
        $("#data_nascimento").attr("required",false);
    }else{
        $("#data_nascimento").attr("required",true);
    }
})

$("#data_nascimento").keyup(function() {
    if($("#data_nascimento").val()){
        $("#floatingPassword").attr("required",false);
    }else{
        $("#floatingPassword").attr("required",true);
    }
})

// $("#btn-entra").on("click",function(){
//     if($("#floatingPassword").val()){
//         alert("2")
//         $("#data_nascimento").attr("required",false);
//     }else{
//         $("#data_nascimento").attr("required",true);
//     }

//     if($("#data_nascimento").val()){
//         alert("3")
//         $("#floatingPassword").attr("required",false);
//     }else{
//         $("#floatingPassword").attr("required",true);
//     }

//     $("#form_login").jqxValidator('validate');
//     $("#form_login").submit();
// })


</script>
</html>