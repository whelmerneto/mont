<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts Awesome --> 
    <link href="{{ asset('/css/fontawesome/css/all.css')}}" rel="stylesheet">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Agendamento de montagem</title>
    <link rel="icon" type="image/x-icon" href="{{url("/")}}/favicon.ico">
</head>
<body>

    <div class="header">
        <nav class="navbar navbar-dark col-sm-12 col-md-12 col-xl-12" style="text-align: center; justify-content: normal; flex-wrap: inherit">
            <!-- Incluir logo --> 
            <div class="navbar-brand" style="margin-right:-170px">
                <img src="{{ asset('/storage/img/logo.png' ) }}" alt="" width="300px">
            </div>
            <h2 style="width: 100%"> Central de Montagem </h2>
        </nav>
    </div>

    <div class="container mt-5">
        @yield('content')
    </div>

    <footer class="mt-5 col-sm-12 col-md-12 col-xl-12">
        <div class="container mt-5">
            <h4 id="perguntas_frequentes" class="mt-6">Perguntas Frequentes</h4>
            <div class="container mt-5">
                <div class="row">
                    <p> O produto da imagem não é o mesmo que comprei, o que devo fazer? </p>  
                    <div class="ml-auto">
                        <button class="dropdown-faq" type="button" data-toggle="collapse" data-target="#collapse_faq1" aria-expanded="false" aria-controls="collapse_faq1">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse" id="collapse_faq1">
                        <div class="card card-body">
                       <span> Caso o produto da imagem esteja divergente com o produto comprado, antes de prosseguir com o agendamento da montagem entre em contato com a central de montagem do Magalu através do <strong>0800 943 1900.</strong></span>   
                        </div>
                    </div>
                </div>
                <hr> 

                <div class="row d-inline-float">
                    <p> Como alterar o endereço onde o móvel será montado? </p>  
                    <div class="ml-auto">
                        <button class="dropdown-faq" type="button" data-toggle="collapse" data-target="#collapse_faq2" aria-expanded="false" aria-controls="collapse_faq2">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse" id="collapse_faq2">
                        <div class="card card-body">
                            O endereço mostrado na tela de agendamento da montagem, é o mesmo disponível no cadastro do cliente utilizado na venda. Caso seja necessário alterar antes de prosseguir com o agendamento da montagem, entre em contato com a central de montagem do Magalu através do <strong>0800 943 1900.</strong>
                        </div>
                    </div>
                </div>
                <hr> 

                <div class="row d-inline-float">
                    <p> O que devo fazer para agendar em uma data diferente das datas disponíveis no sistema? </p>  
                    <div class="ml-auto">
                        <button class="dropdown-faq" type="button" data-toggle="collapse" data-target="#collapse_faq3" aria-expanded="false" aria-controls="collapse_faq3">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse" id="collapse_faq3">
                        <div class="card card-body">
                            O sistema mostra as datas disponíveis mais próximas, caso nenhuma data atenda sua necessidade, você pode realizar o agendamento na central de montagem do Magalu através do <strong>0800 943 1900.</strong> Lembrando que o prazo de garantia de seu móvel é de 03 meses, o ideal é realizar a montagem dentro desse prazo, para que em caso de necessidade de solicitar peças, o fabricante possa atender
                        </div>
                    </div>
                </div>
                <hr> 

                <div class="row d-inline-float">
                    <p> Tenho outros móveis no local da montagem, o montador irá realizar a desmontagem? </p>  
                    <div class="ml-auto">
                        <button class="dropdown-faq" type="button" data-toggle="collapse" data-target="#collapse_faq4" aria-expanded="false" aria-controls="collapse_faq4">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse" id="collapse_faq4">
                        <div class="card card-body collapsed-card">
                            O Magalu não se responsabiliza pela desmontagem do produto a ser substituído, então pedimos a gentileza de que deixe o espaço livre para que o montador possa realizar a montagem do seu novo produto.
                        </div>
                    </div>
                </div>
                <hr> 
                <div class="row d-inline-float">
                    <p> Posso deixar minha vizinha ou meu filho menor de idade, para acompanhar o montador? </p>  
                    <div class="ml-auto">
                        <button class="dropdown-faq" type="button" data-toggle="collapse" data-target="#collapse_faq5" aria-expanded="false" aria-controls="collapse_faq4">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse" id="collapse_faq5">
                        <div class="card card-body collapsed-card">
                            Pensando na sua segurança, de seu filho e do montador, o Magalu solicita que somente pessoas maiores de 18 anos acompanhe o atendimento onde será instalado o novo produto. Ah, antes de concluir o agendamento da montagem não se esqueça de informar o nome da pessoa que irá receber o montador.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h4 id="duvidas"> Ainda está com dúvidas? </h4>
                <h5 id="acesse"> Acesse nossa Central de Atendimento </h5>
                <span style="font-weight: bold;">Ou ligue:</span>
                <br>
                <span>0800 9431 900</span>
            </div>
        </div>
        
    </footer>

    <style>
        .header {
            Font-size: 42px;
            Line-height: 100%;
            Letter-spacing: -2%;
            color: white;
            background-color: #1789fc;
        }
        footer {
            background-color: #eceaea;
            padding-top: 50px;
            height: 800px;
        }
        #perguntas_frequents {
            font-weight: bold;
        }
        .dropdown-faq {
            background-color: #eceaea;
            border: none;
        }
        #duvidas {
            font-weight: bold;
            padding-top: 50px;
        }
        #acesse {
            color:  #58c22e;
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
</html>