<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;

class AcessoController extends Controller
{
    public function login_form() {
        return view('landing_page.login');
    }

    public function gera_token() {

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => env("API_LOGIN"),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'email' => env("EMAIL_API"),       
                'password' => env("SENHA_API")
            ]),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          return json_decode($response);
        }
    }

    #   Função de autenticação e redireionamento para a página index
    public function auth_login(Request $request) {
        #   Gerando Token de Acesso
        $dados = new AcessoController;
        $token = $dados->gera_token();
        $token = $token->token;
        
        #   Credentials by request
        $cpf = $request->cpf;
        #  Retira os espaços do começo e do final.
        $cpf = trim($cpf);
        #   Substitui o ponto por nada
        $cpf = str_replace(".", "", $cpf);
        #   Troca o traço por nada
        $cpf = str_replace("-", "", $cpf);
        #   Troca a barra por nada
        $cpf = str_replace("/", "", $cpf);
        #   Troca o espaço por nada, caso sobre algum
        $cpf = str_replace(" ", "", $cpf);
        //Troca a barra por nada
        
        $cpf = str_replace("-", "", $cpf);
        $chamado = $request->chamado;
        
        $consulta = $dados->consultar($cpf);

        #   Mandando de volta caso não encontre resultados
        if ($consulta->total == 0) {
            return redirect()->back()->with('error', 'Verifique os dados inseridos');
        }
        $id = [];
        foreach ($consulta->dados as $key => $consult) {
            foreach ($consult->campo_custom_valor as $key => $customvalor) {
               
                if(isset($customvalor->custom->cfd_integrationid) && $customvalor->custom->cfd_integrationid === "numpedido"){
                    $id[] = $customvalor->cfv_externalvalue;
                }
            
            }
        }
    
        if (in_array($chamado, $id)) {

            $request->session()->put('authenticated', time());
            $request->session()->put('dados', $consulta->dados);
            $request->session()->put('cpf', $cpf);
            $request->session()->put('chamado', $chamado);

            $dados = $consulta->dados;

            $pedidos_anteriores = [];

            foreach ($dados as $key => $dado) {
                if($dado->slt_status != "Aguardando Montagem" && $dado->slt_status != "Aguardando agendamento" && $dado->slt_status != "Aguardando Pagamento"){
                    $pedidos_anteriores[] = $dado;
                }
            }
    
            return view('landing_page.index', ['dados' => $dados, "pedidos_anteriores" => $pedidos_anteriores]);

        } else {
            return redirect()->back()->with('error', 'Pedido/Documento não encontrado');
        }

    }

    public function index(Request $request) {
        try {
            $api = new AcessoController;
            $token = $api->gera_token();
            $consulta = $api->consultar($request->session()->get("cpf"));
            $dados = $consulta->dados;
            $request->session()->put('dados', $dados);
      
    
            $pedidos_anteriores = [];
    
            foreach ($dados as $key => $dado) {
                if($dado->slt_status != "Aguardando Montagem" && $dado->slt_status != "Aguardando agendamento" && $dado->slt_status != "Aguardando Pagamento"){
                    $pedidos_anteriores[] = $dado;
                }
            }
    
            return view('landing_page.index', ['dados' => $dados, "pedidos_anteriores" => $pedidos_anteriores]);
        } catch (\Exception $e) {
            return view('landing_page.error');
        }
    }

    #   Função que recebe os pedidos via requisição e redireciona para a pagina de agendamentos
    public function agendamento(Request $request) {
        try {
            #   Gerando Token de Acesso
            $dados = new AcessoController;
            $token = $dados->gera_token();
            $token = $token->token;

            #   Data atual
            $data_atual = date('Y-m-d');
            $data_atual = date('Y-m-d', strtotime($data_atual . "+1 days"));
            $mes_atual = date('F');
            #   Tratando os meses
            if ($mes_atual == "January") {
                $mes_atual = "Janeiro";
            } else if ($mes_atual == "February") {
                $mes_atual = "Fevereiro";
            } else if ($mes_atual == "March") {
                $mes_atual = "Março";
            } else if ($mes_atual == "April") {
                $mes_atual = "Abril";
            } else if ($mes_atual == "May") {
                $mes_atual = "Maio";
            } else if ($mes_atual == "June") {
                $mes_atual = "Junho";
            } else if ($mes_atual == "July") {
                $mes_atual = "Julho";
            } else if ($mes_atual == "August") {
                $mes_atual = "Agosto";
            } else if ($mes_atual == "September") {
                $mes_atual = "Setembro";
            } else if ($mes_atual == "October") {
                $mes_atual = "Outubro";
            } else if ($mes_atual == "November") {
                $mes_atual = "Novembro";
            } else if ($mes_atual == "December") {
                $mes_atual = "Dezembro";
            }

            #   Array de Montagens via requisição
            $slt = $request->slt;

            #   Consultando chamados por id
            foreach ($slt as $slt_id) {
                $consulta_body = [
                    'filtro' => [
                        [
                            'campo' => 'solicitacoes.slt_categoria',
                            'condicao' => '=',
                            'valor' => 'MONTAGEM',
                            'operador' => null
                        ],
                        [
                            'campo' => 'solicitacoes.slt_id',
                            'condicao' => '=',
                            'valor' => $slt_id,
                            'operador' => null
                        ]
                    ],
                    'offset' => 0
                ];
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => env("API_CONSULTAR"),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($consulta_body),
                    CURLOPT_HTTPHEADER => [
                        "Authorization: Bearer {$token}",
                        "Content-Type: application/json"
                    ],
                ]);
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                $response = json_decode($response);

                $montagens[] = $response->dados;
            }
            #   Buscando slt_integration_id de cada montagem
            foreach($montagens as $key => $montagem) {
                $slt_integrationid[$key] = $montagem[0]->slt_integrationid;
            }
            #   Buscando data disponivel por pedido
            $consulta_data_body = [
                'slt_integrationid' => 
                    $slt_integrationid
                ,
                'numberofdays' => 7,
                'mandatorydays' => 6,
                'minpercentage' => 10,
                'startingdate' => $data_atual,
                'form' => 'formulario_montagem'
            ];
            $curl_data = curl_init();
            curl_setopt_array($curl_data, [
                CURLOPT_URL => env('API_CONSULTAR_DATAS'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($consulta_data_body),
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$token}",
                    "Content-Type: application/json"
                ],
            ]);
                
            $response_data = curl_exec($curl_data);
            $err = curl_error($curl_data);
            curl_close($curl_data);
            $response_data = json_decode($response_data);
                
            $datas = $response_data->dates;

            return view('landing_page.agendamento', ['montagens' => $montagens, 'datas' => $datas, 'mes' => $mes_atual, 'slt_integrationid' =>$slt_integrationid]);
        
        } catch (\Exception $e) {
            return view('landing_page.error');
        }
    }

    public function agendar($data, array $slt_integrationid, $tec_id, $observacao) {
        try {
            #   Gerando Token de Acesso
            $dados = new AcessoController;
            $token = $dados->gera_token();
            $token = $token->token;
            
            $body_nova_tarefa = [
                [
                    'atv_integrationid' => 'formulario_montagem',
                    'solicitacao' => $slt_integrationid,
                    'datainicial' => $data,
                    'tec_integrationid' => $tec_id,
                    'tipo' => 4,
                    'observacao' => $observacao,
                    'campocustom' => [
                        'tarefa_observacao' => $observacao
                    ],
                    'origin' => 'SixApp'
                ],
            ];

            // testando 
            foreach($slt_integrationid as $integrationid) {
                $body_new[] = [
                    'atv_integrationid' => 'formulario_montagem',
                    'solicitacao' => $integrationid,
                    'datainicial' => $data,
                    'tec_integrationid' => $tec_id,
                    'tipo' => 4,
                    'observacao' => $observacao,
                    'campocustom' => [
                        'tarefa_observacao' => $observacao
                    ],
                    'origin' => 'SixApp'
                ];
            }

            
            // fim testando
            $curl = curl_init();
            curl_setopt_array($curl, [
            CURLOPT_URL => env('API_NOVA_TAREFA'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($body_new),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$token}",
                "Content-Type: application/json"
            ],
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            return json_decode($response);
        } catch (\Exception $e) {
            $statusCode = method_exists($Exception, 'getStatusCode') ? $Exception->getStatusCode() : 500;
            abort($statusCode, $e->getMessage());
        }


    }

    #   Função para realizar o agendamento
    public function confirmar(Request $request) {
        try {
            $dados = new AcessoController;
            $cpf = $request->session()->get("cpf");
            $chamado = $request->session()->get("chamado");
           
            $slt_favorecido = $request->session()->get("dados")[0]->slt_favorecido;
           
            #   Erro caso não selecionar uma data
            if (is_null($request->data_agendamento)) {
                return redirect()->back()->with('error', 'Selecione uma data para o agendamento');
            }
    
            #   Datas por requisição
            $dia = $request->dia;
            $dia_num = $request->dia_num;
            $mes = $request->mes;
    
            $data = $request->data_agendamento;
            $observacao = $request->nome_recebedor . $request->telefone . $request->ponto_referencia . $request->observacao;
            $tec_integrationid = $request->tecnico[0];
    
            $slt_integrationids = $request->slt_integrationid;
    
            #   Correto
            // $dados->deletar($slt_integrationids);
            $agendamento = $dados->agendar($data, $slt_integrationids, $tec_integrationid, $observacao);
            
            return redirect()->route('confirmado', compact('dia', 'dia_num', 'mes', 'cpf', 'chamado', 'slt_favorecido'));

        } catch (\Exception $e) {
            return view('landing_page.error');
        }


    }

    #   Função que faz a consulta por cpf
    public function consultar($cpf) {
        try {
            #   Gerando Token de Acesso
            $dados = new AcessoController;
            $token = $dados->gera_token();
            $token = $token->token;

            $consulta_body = [
                'filtro' => [
                    [
                        'campo' => 'solicitacoes.slt_categoria',
                        'condicao' => '=',
                        'valor' => 'MONTAGEM',
                        'operador' => null
                    ],
                    [
                        'campo' => 'solicitacoes.slt_fav_cpf',
                        'condicao' => '=',
                        'valor' => $cpf,
                        'operador' => null
                    ], 
                    [
                        'campo' => 'solicitacoes.created_at',
                        'condicao' => '>',
                        'valor' => date("Y-m-d",strtotime(date("Y-m-d")."-90 days")),
                        'operador' => null
                    ]
            ],
                'offset' => 0
            ];
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => env("API_CONSULTAR"),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($consulta_body),
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$token}",
                    "Content-Type: application/json"
                ],
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $response = json_decode($response);

            return $response;
        } catch (\Exception $e) {
            $statusCode = method_exists($Exception, 'getStatusCode') ? $Exception->getStatusCode() : 500;
            abort($statusCode, $e->getMessage());
        }
    }

    public function consultar_datas(array $slt_integrationid) {

    }

    public function deletar(array $slt_integrationid) {
        try {
            #   Gerando Token de Acesso
            $dados = new AcessoController;
            $token = $dados->gera_token();
            $token = $token->token;

            $body_chamado = [
                'solicitacao' => $slt_integrationid
            ];

            $curl = curl_init();
            curl_setopt_array($curl, [
            CURLOPT_URL => env('API_DELETE'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_POSTFIELDS => json_encode($body_chamado),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$token}",
                "Content-Type: application/json"
            ],
            ]);
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
            return json_decode($err);
            } else {
            return json_decode($response);
            }
        }catch (\Exception $e) {
            $statusCode = method_exists($Exception, 'getStatusCode') ? $Exception->getStatusCode() : 500;
            abort($statusCode, $e->getMessage());
        }

    }

    public function acompanhar(Request $request) {
        try {
            #   Solicitando Token de acesso
            $dados = new AcessoController;
            $token = $dados->gera_token();
            $token = $token->token;

            #   Requisição do id do pedido
            $slt_id = $request->route('id');

            #   Solicitando dados do pedido
            $consulta_body = [
                'filtro' => [
                    [
                        'campo' => 'solicitacoes.slt_id',
                        'condicao' => '=',
                        'valor' => $slt_id,
                        'operador' => null
                    ]
                ],
                'offset' => 0
            ];
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => env("API_CONSULTAR"),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($consulta_body),
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$token}",
                    "Content-Type: application/json"
                ],
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $response = json_decode($response);

            
            foreach($response->dados as $res) {
                $dados = $res;
            }

            return view('landing_page.acompanhar', ['dados' => $dados]);
        } catch (\Exception $e) {
            return view('landing_page.error');
        }

    }

    public function reagendamento(Request $request) {
        try{
            #   Solicitando Token de acesso
            $dados = new AcessoController;
            $token = $dados->gera_token();
            $token = $token->token;
            
            #   Data atual
            $data_atual = date('Y-m-d');
            $data_atual = date('Y-m-d', strtotime($data_atual . "+1 days"));
            $mes_atual = date('F');
            #   Tratando os meses
            if ($mes_atual == "January") {
                $mes_atual = "Janeiro";
            } else if ($mes_atual == "February") {
                $mes_atual = "Fevereiro";
            } else if ($mes_atual == "March") {
                $mes_atual = "Março";
            } else if ($mes_atual == "April") {
                $mes_atual = "Abril";
            } else if ($mes_atual == "May") {
                $mes_atual = "Maio";
            } else if ($mes_atual == "June") {
                $mes_atual = "Junho";
            } else if ($mes_atual == "July") {
                $mes_atual = "Julho";
            } else if ($mes_atual == "August") {
                $mes_atual = "Agosto";
            } else if ($mes_atual == "September") {
                $mes_atual = "Setembro";
            } else if ($mes_atual == "October") {
                $mes_atual = "Outubro";
            } else if ($mes_atual == "November") {
                $mes_atual = "Novembro";
            } else if ($mes_atual == "December") {
                $mes_atual = "Dezembro";
            }
            #   Array de Montagens via requisição
            $slt = $request->slt;
        
            $consulta_body = [
                'filtro' => [
                    [
                        'campo' => 'solicitacoes.slt_categoria',
                        'condicao' => '=',
                        'valor' => 'MONTAGEM',
                        'operador' => null
                    ],
                    [
                        'campo' => 'solicitacoes.slt_id',
                        'condicao' => '=',
                        'valor' => $slt,
                        'operador' => null
                    ]
                ],
                    'offset' => 0
            ];
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => env("API_CONSULTAR"),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($consulta_body),
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$token}",
                    "Content-Type: application/json"
                ],
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $response = json_decode($response);

            $montagens = $response->dados;
            

            #   Buscando o slt_integrationid
            foreach($montagens as $key => $montagem) {
                $slt_integrationid = $montagem->slt_integrationid;
            }

            #   Buscando data disponivel por pedido
            $consulta_data_body = [
                'slt_integrationid' => 
                    $slt_integrationid
                ,
                'numberofdays' => 7,
                'mandatorydays' => 6,
                'minpercentage' => 10,
                'startingdate' => $data_atual,
                'form' => 'formulario_montagem'
            ];
            $curl_data = curl_init();
            curl_setopt_array($curl_data, [
                CURLOPT_URL => env('API_CONSULTAR_DATAS'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($consulta_data_body),
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$token}",
                    "Content-Type: application/json"
                ],
            ]);
                
            $response_data = curl_exec($curl_data);
            $err = curl_error($curl_data);
            curl_close($curl_data);
            $response_data = json_decode($response_data);
                
            $datas = $response_data->dates;
        
            return view('landing_page.reagendamento', ['montagens' => $montagens, 'datas' => $datas, 'mes' => $mes_atual, 'slt_integrationid' => $slt_integrationid]);
        } catch (\Exception $e) {
            return view('landing_page.error');
        }
    }   
    
    public function reagendar(Request $request) {
        try {
            #   Solicitando Token de acesso
            $dados = new AcessoController;
            $token = $dados->gera_token();
            $token = $token->token;

            $data = $request->data_agendamento;
            $observacao = $request->nome_recebedor . $request->telefone . $request->ponto_referencia . $request->observacao;
            $tec_integrationid = $request->tecnico[0];

            $slt_integrationids = $request->slt_integrationid;

            $hoje_diff = new DateTime();
            $data_diff = new DateTime($data);
            $diff = date_diff($data_diff, $hoje_diff);

            #   Dados por requisição
            $dia = $request->dia;
            $dia_num = $request->dia_num;
            $mes = $request->mes;
            $cpf = $request->cpf;
            $chamado = $request->chamado;

            #   Erro caso não selecionar uma data
            if (is_null($request->data_agendamento)) {
                return redirect()->back()->with('error', 'Selecione uma data para o agendamento');
            }

            #   Validando o tempo minimo para cancelamento
            if ($diff->days >= 1) {
                $cancelando = $dados->deletar($slt_integrationids);
                $reagendando = $dados->agendar($data, $slt_integrationids, $tec_integrationid, $observacao);
            } else {
                return redirect()->back()->with('error', 'A data do reagendamento precisa ser pelo menos 24 horas depois de hoje.');
            }
            
            if (!empty($reagendando[0]->trf_id)) {
                return redirect()->route('confirmado', compact('dia', 'dia_num', 'mes', 'cpf', 'chamado'));
            } else {
                return redirect()->back()->with('error', 'Encontramos um problema ao reagendar sua montagem. Entre em contato com o nossa Central de Atendimento');
            }

        } catch (\Exception $e) {
            return view('landing_page.error');
        }

    }

    public function confirmado(Request $request) {
        try{
            $dia = $request->dia;
            $dia_num = $request->dia_num;
            $mes = $request->mes;
            $cpf = $request->cpf;
            $chamado = $request->chamado;
            $slt_favorecido = $request->session()->get("dados")[0]->slt_favorecido;

            return view('landing_page.confirmado', compact('dia', 'mes', 'dia_num', 'cpf', 'chamado', 'slt_favorecido'));
        } catch (\Exception $e) {
            return view('landing_page.error');
        }
    }
}
