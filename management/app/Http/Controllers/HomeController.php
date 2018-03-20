<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Acompanhamento;
use Illuminate\Support\Facades\DB;
use App\PessoaRSesvesp;
use App\CNPJPessoa;
use Carbon\Carbon;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     
    public function __construct() {
        $this->middleware('auth');
    }

    *
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    function getBetween($content, $start, $end) {
        $r = explode($start, $content);
        if (isset($r[1])) {
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return '';
    }

    public function index() {
        $conn = DB::connection('rsesvesp');
        $emp = $conn->select('
                select count(pessoascodigo) Empresas,
                sum(pessoasempregados) Vigilantes,
                regionaldescricao Regional
                from (select pessoascodigo,pessoasempregados,regionaldescricao
                from pessoas
                inner join regionalcidade on pessoasenderecocidade=regionalcidadecidade 
                inner join regional on regionalcidade.regionalcodigo=regional.regionalcodigo
                where pessoasenderecouf="SP" and pessoas.pessoassituacao="ATIVA" group by pessoascodigo, pessoasempregados, regionaldescricao) a
                group by regionaldescricao
                  ');
        $regionais = array();
        $empresas = array();
        $vigilantes = array();
        foreach ($emp as $key) {
            array_push($regionais, $key->Regional);
            array_push($empresas, $key->Empresas);
            array_push($vigilantes, $key->Vigilantes);
        }
        $table = DB::connection('rsesvesp')->unprepared(DB::raw('
                CREATE TEMPORARY TABLE ceprange (
                    id INT(10) not null,
                    min INT(11),
                    max INT(11),
                    zona VARCHAR(125)
                );
                INSERT INTO ceprange (id,min,max,zona) VALUES (1,01000000,01599999,"CENTRO");
                INSERT INTO ceprange (id,min,max,zona) VALUES (2,02000000,02999999,"ZONA NORTE");
                INSERT INTO ceprange (id,min,max,zona) VALUES (3,03000000,03999999,"ZONA LESTE");
                INSERT INTO ceprange (id,min,max,zona) VALUES (4,08000000,08499999,"ZONA LESTE");
                INSERT INTO ceprange (id,min,max,zona) VALUES (5,05000000,05899999,"ZONA OESTE");                
                INSERT INTO ceprange (id,min,max,zona) VALUES (604000000,04999999,"ZONA SUL");
                '));
        if ($table) {
            $cep = DB::connection('rsesvesp')->select(DB::raw('
                select 
                ceprange.zona Zona, 
                count(pessoas.pessoascodigo) Empresas,
                sum(pessoas.pessoasempregados) Vigilantes
                from pessoas 
                inner join ceprange on 
                pessoas.pessoasenderecocep >= ceprange.min
                and 
                pessoas.pessoasenderecocep <= ceprange.max 
                where pessoas.pessoasenderecocidade="SÃO PAULO" and pessoas.pessoassituacao="ATIVA"
                group by ceprange.zona
        '));
        }
        $zonas = array();
        $empresasZ = array();
        $vigilantesZ = array();
        foreach ($cep as $key) {
            array_push($zonas, $key->Zona);
            array_push($empresasZ, $key->Empresas);
            array_push($vigilantesZ, $key->Vigilantes);
        }
        $empresasChart = app()->chartjs
                ->name('empresasChart')
                ->type('pie')
                ->size(['width' => 400, 'height' => 200])
                ->labels($regionais)
                ->datasets([
                    [
                        'backgroundColor' => ['#F16464','#FF8F8F','#FFB9B9','#CCCCCC','#CADDEE','#97B7D4','#6891B5'],
                        'hoverBackgroundColor' => ['#F16464','#FF8F8F','#FFB9B9','#CCCCCC','#CADDEE','#97B7D4','#6891B5'],
                        'data' => $empresas
                    ]
                ])
                ->optionsRaw("{
            legend: {
                display:true,
                position:'right'
            },
            title: {
                display: true,
                position: 'top',
                fontSize: 14,
                text: 'Empresas',
            }
        }");
        $vigilantesChart = app()->chartjs
                ->name('vigilantesChart')
                ->type('pie')
                ->size(['width' => 400, 'height' => 200])
                ->labels($regionais)
                ->datasets([
                    [
                        'backgroundColor' => ['#F16464','#FF8F8F','#FFB9B9','#CCCCCC','#CADDEE','#97B7D4','#6891B5'],
                        'hoverBackgroundColor' => ['#F16464','#FF8F8F','#FFB9B9','#CCCCCC','#CADDEE','#97B7D4','#6891B5'],
                        'data' => $vigilantes
                    ]
                ])
                ->optionsRaw("{
            legend: {
                display:true,
                position:'left'
            },
            title: {
                display: true,
                position: 'top',
                fontSize: 14,
                text: 'Vigilantes',
            }
        }");
        $zonasEmpresasChart = app()->chartjs
                ->name('zonasEmpresasChart')
                ->type('doughnut')
                ->size(['width' => 400, 'height' => 200])
                ->labels($zonas)
                ->datasets([
                    [
                        'backgroundColor' => ['#F16464','#FF8F8F','#97B7D4','#6891B5'],
                        'hoverBackgroundColor' => ['#F16464','#FF8F8F','#97B7D4','#6891B5'],
                        'data' => $empresasZ
                    ]
                ])
                ->optionsRaw("{
            legend: {
                display:true,
                position:'right'
            },
            title: {
                display: true,
                position: 'top',
                fontSize: 14,
                text: 'Empresas',
            }
        }");
        $zonasVigilantesChart = app()->chartjs
                ->name('$zonasVigilantesChart')
                ->type('doughnut')
                ->size(['width' => 400, 'height' => 200])
                ->labels($zonas)
                ->datasets([
                    [
                        'backgroundColor' => ['#F16464','#FF8F8F','#97B7D4','#6891B5'],
                        'hoverBackgroundColor' => ['#F16464','#FF8F8F','#97B7D4','#6891B5'],
                        'data' => $vigilantesZ
                    ]
                ])
                ->optionsRaw("{
            legend: {
                display:true,
                position:'left'
            },
            title: {
                display: true,
                position: 'top',
                fontSize: 14,
                text: 'Vigilantes',
            }
        }");


        //EFETIVOS
        $conn = DB::connection('mysql');
        $last = DB::table('Efetivos')->get();

        $conn = DB::connection('rsesvesp');
        $efetivos = $conn->select("
                select sum(pessoasempregados) Efetivos, count(pessoascodigo) Associadas
                from pessoas
                where pessoas.pessoassituacao='ATIVA' and
                pessoasenderecouf='SP' and pessoasnumsocio is not null and (pessoassociodesfilia is null or pessoassociodesfilia='' or pessoassociodesfilia='0000-00-00' or pessoassociodesfilia='1000-01-01')
                ");
        $efetivos = collect($efetivos);
        $efetivos = json_decode($efetivos, true);

        $updated = false;
        foreach ($last as $val) {
            if (strtotime($val->Data) == strtotime(today())) {
                $updated = true;
                DB::table('Efetivos')->where('Id', $val->Id)->update(['Hora' => Carbon::now()->toTimeString(), 'Efetivos' => $efetivos[0]["Efetivos"]]);
            }
        }

        $NumeroEmpresasAssociadas = $efetivos[0]["Associadas"];

        if (!$updated) {
            /* $conn = DB::connection('rsesvesp');
              $efetivos = $conn->select("
              select sum(pessoasempregados) Efetivos
              from pessoas
              where pessoas.pessoassituacao='ATIVA' and
              pessoasenderecouf='SP' and pessoasnumsocio is not null and (pessoassociodesfilia is null or pessoassociodesfilia='' or pessoassociodesfilia='0000-00-00' or pessoassociodesfilia='1000-01-01')
              ");
              $efetivos = collect($efetivos);
              $efetivos = json_decode($efetivos, true);
             */

            DB::table('Efetivos')->insert(['Efetivos' => $efetivos[0]["Efetivos"], 'Data' => today(), 'Hora' => Carbon::now()->toTimeString()]);
        }

        $efetivos = array();
        $datas = array();
        $valuesChart = DB::table('Efetivos')->orderBy('Data', 'asc')->paginate(30);
        foreach ($valuesChart as $val) {
            array_push($efetivos, $val->Efetivos);
            array_push($datas, date("d/m/Y", strtotime($val->Data)));
        }

        $efetivosChart = app()->chartjs
                ->name('efetivosChart')
                ->type('line')
                ->size(['width' => 500, 'height' => 150])
                ->labels($datas)
                ->datasets([
                    [
                        "label" => "Vigilantes de empresas associadas",
                        'backgroundColor' => "rgba(182, 26, 26, 0.31)",
                        'borderColor' => "rgba(182, 26, 26, 0.7)",
                        "pointBorderColor" => "rgba(182, 26, 26, 0.7)",
                        "pointBackgroundColor" => "rgba(182, 26, 26, 0.7)",
                        "pointHoverBackgroundColor" => "rgba(182, 26, 26, 0.7)",
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => $efetivos,
                    ]
                ])
                ->options([]);


        $conn = DB::connection('mysql');
        $last = DB::table('efetivos_nao_associadas')->get();

        $conn = DB::connection('rsesvesp');
        $efetivosNaoAssociadas = $conn->select("
                    select sum(pessoasempregados) Efetivos, count(pessoascodigo) NaoAssociadas
                    from pessoas
                    where pessoasenderecouf='SP'
                    and
                    (((pessoasnumsocio is null or pessoasnumsocio='' or pessoasnumsocio='0') and (pessoassociodesfilia is null or pessoassociodesfilia='' or pessoassociodesfilia='0000-00-00' or pessoassociodesfilia='1000-00-00' or pessoassociodesfilia='1000-01-01'))
                    or
                    (pessoasnumsocio is not null and (pessoassociodesfilia is not null and pessoassociodesfilia!='' and pessoassociodesfilia!='0000-00-00' and pessoassociodesfilia!='1000-01-01'))
                    )
                    and
                    pessoas.pessoassituacao='ATIVA'
");
        $efetivosNaoAssociadas = collect($efetivosNaoAssociadas);
        $efetivosNaoAssociadas = json_decode($efetivosNaoAssociadas, true);

        $updated = false;
        foreach ($last as $val) {
            if (strtotime($val->Data) == strtotime(today())) {
                $updated = true;
                DB::table('efetivos_nao_associadas')->where('Id', $val->Id)->update(['Hora' => Carbon::now()->toTimeString(), 'Efetivos' => $efetivosNaoAssociadas[0]["Efetivos"]]);
            }
        }

        if (!$updated) {

            DB::table('efetivos_nao_associadas')->insert(['Efetivos' => $efetivosNaoAssociadas[0]["Efetivos"], 'Data' => today(), 'Hora' => Carbon::now()->toTimeString()]);
        }

        $NaoAssociadas = $efetivosNaoAssociadas;
        
        $efetivosNaoAssociadas = array();
        $datasNaoAssociadas = array();
        $valuesChart = DB::table('efetivos_nao_associadas')->orderBy('Data', 'asc')->paginate(30);
        foreach ($valuesChart as $val) {
            array_push($efetivosNaoAssociadas, $val->Efetivos);
            array_push($datasNaoAssociadas, date("d/m/Y", strtotime($val->Data)));
        }

        $NumeroEmpresasNaoAssociadas = $NaoAssociadas[0]["NaoAssociadas"];


        $efetivosNaoAssociadosChart = app()->chartjs
                ->name('efetivosNaoAssociadosChart')
                ->type('line')
                ->size(['width' => 500, 'height' => 150])
                ->labels($datasNaoAssociadas)
                ->datasets([
                    [
                        "label" => "Vigilantes de empresas associadas",
                        'backgroundColor' => "rgba(182, 26, 26, 0.31)",
                        'borderColor' => "rgba(182, 26, 26, 0.0)",
                        "pointBorderColor" => "rgba(182, 26, 26, 0.7)",
                        "pointBackgroundColor" => "rgba(182, 26, 26, 0.7)",
                        "pointHoverBackgroundColor" => "rgba(182, 26, 26, 0.7)",
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => $efetivos,
                    ],
                    [
                        "label" => "Vigilantes de empresas não associadas",
                        'backgroundColor' => "rgba(41, 92, 138, 0.31)",
                        'borderColor' => "rgba(41, 92, 138, 0.0)",
                        "pointBorderColor" => "rgba(41, 92, 138, 0.7)",
                        "pointBackgroundColor" => "rgba(41, 92, 138, 0.7)",
                        "pointHoverBackgroundColor" => "rgba(41, 92, 138, 0.7)",
                        "pointHoverBorderColor" => "rgba(41, 92, 138,1)",
                        'data' => $efetivosNaoAssociadas,
                        'hidden' => true,
                    ]
                ])
                ->options(["
                    
                "]);



        //MULTAS
        $ano = date('Y-m-d', strtotime(Carbon::now()->subYears(1)));
        $conn = DB::connection('rsesvesp');
        $acps = $conn->table('acpcrm')->select('pessoascodigo', 'acpcrmcodigo', 'acpcrmdata', 'acpcrmcomplemento')->where('acpcrmdata', '>=', $ano)->where('occcrmcodigo', '=', '21')->get();
        $conn = DB::connection('mysql');
        $conn->table('temp_multas')->delete();
        $multas_qtde = array();
        $multas_data = array();
        foreach ($acps as $val) {
            $valor;
            $complemento = str_replace(".", "", $val->acpcrmcomplemento);
            preg_match("/(equivalente a [0-9]{1,10})/i", $complemento, $valor);
            //echo var_dump($valor) . " . . . " . $val->acpcrmcodigo . " . . . " . "$val->acpcrmdata" . "<br><br>";
            if (isset($valor[0])) {
                //array_push($multas_qtde,preg_replace("/[^0-9]{1,10}/","",$valor[0]));
                //array_push($multas_data,$val->acpcrmdata);
                $conn->table('temp_multas')->insert(['PessoasCodigo' => $val->pessoascodigo, 'Data' => $val->acpcrmdata, 'Valor' => preg_replace("/[^0-9]{1,10}/", "", $valor[0])]);
            }
        }

        $query = $conn->table('temp_multas')->selectRaw('Data, sum(valor) as Valor')->groupBy('data')->orderBy('data', 'asc')->get();

        foreach ($query as $val2) {
            array_push($multas_qtde, $val2->Valor);
            array_push($multas_data, date("d/m/Y", strtotime($val2->Data)));
        }

        $conn->table('temp_multas')->delete();
        
        
        
        //MULTAS SP
        $conn = DB::connection('rsesvesp');
        $multassp = $conn->select("
                select acpcrmcomplemento, acpcrm.pessoascodigo, acpcrmcodigo, acpcrmdata
                from acpcrm inner join pessoas on acpcrm.pessoascodigo=pessoas.pessoascodigo
                where pessoas.pessoassituacao='ATIVA' and
                pessoasenderecouf='SP' and acpcrmdata >= '$ano' and occcrmcodigo=21
                ");
        //$multassp = collect($multassp);
        //$multassp = json_decode($multassp, true);
        
        $conn = DB::connection('mysql');
        $conn->table('temp_multas')->delete();
        $multassp_qtde = array();
        $multassp_data = array();
        foreach ($multassp as $val) {
            $valor;
            $complemento = str_replace(".", "", $val->acpcrmcomplemento);
            preg_match("/(equivalente a [0-9]{1,10})/i", $complemento, $valor);
            //echo var_dump($valor) . " . . . " . $val->acpcrmcodigo . " . . . " . "$val->acpcrmdata" . "<br><br>";
            if (isset($valor[0])) {
                //array_push($multas_qtde,preg_replace("/[^0-9]{1,10}/","",$valor[0]));
                //array_push($multas_data,$val->acpcrmdata);
                $conn->table('temp_multas')->insert(['PessoasCodigo' => $val->pessoascodigo, 'Data' => $val->acpcrmdata, 'Valor' => preg_replace("/[^0-9]{1,10}/", "", $valor[0])]);
            }
        }

        $query = $conn->table('temp_multas')->selectRaw('Data, sum(valor) as Valor')->groupBy('data')->orderBy('data', 'asc')->get();

        foreach ($query as $val2) {
            array_push($multassp_qtde, $val2->Valor);
            array_push($multassp_data, date("d/m/Y", strtotime($val2->Data)));
        }

        $conn->table('temp_multas')->delete();
        
        
        
        
      
        
        
        $multasChart = app()->chartjs
                ->name('multasChart')
                ->type('line')
                ->size(['width' => 500, 'height' => 150])
                ->labels($multassp_data)
                ->datasets([
                     [
                        "label" => "Valores de multas",
                        'backgroundColor' => "rgba(182, 26, 26, 0.0)",
                        'borderColor' => "rgba(182, 26, 26, 0.7)",
                        "pointBorderColor" => "rgba(182, 26, 26, 0.7)",
                        "pointBackgroundColor" => "rgba(182, 26, 26, 0.7)",
                        "pointHoverBackgroundColor" => "rgba(182, 26, 26, 0.7)",
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'xAxisID' => "",
                        'data' => $multassp_qtde,
                    ],
                ])
                ->optionsRaw("{
            legend: {
                display:false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display:true
                    }  
                }]
            }
        }");

      
        
        
        //GRÁFICO OCORRÊNCIAS
        $occ = array(
            11 => "HISTÓRICO EFETIVO",
            20 => "AUTORIZAÇÃO DE COMPRA DE ARMAS",
            21 => "PENA DE MULTA",
            23 => "PENA DE ADVERTÊNCIA",
            27 => "AUTORIZAÇÃO ATIVIDADE PRINCIPAL",
            28 => "AUTORIZAÇÃO ATIVIDADE SECUNDÁRIA",
            29 => "CANCELAMENTO ATIVIDADE PRINCIPAL",
            32 => "REVISÃO DO ALVARÁ DE FUNCIONAMENTO",
            42 => "CANCELAMENTO ATIVIDADE SECUNDÁRIA",
            59 => "CERTIFICADO CRS",
            62 => "CERTIFICADO ISO",
        );

        $conn->table('temp_ocorrencias')->delete();

        foreach ($occ as $key => $value) {
            $conn = DB::connection('rsesvesp');
            $q = $conn->table('acpcrm')->join('pessoas', 'acpcrm.pessoascodigo', '=', 'pessoas.pessoascodigo')->selectRaw('count(acpcrmcodigo) as Ocorrencias, year(acpcrmdata) ano, month(acpcrmdata) Mes')->where('pessoasenderecouf','=','SP')->where('occcrmcodigo', '=', $key)->where('acpcrmdata', '>=', $ano)->groupBy('ano', 'mes')->get();
            $conn = DB::connection('mysql');
            foreach ($q as $val) {
                $conn->table('temp_ocorrencias')->insert(['OccCodigo' => $key, 'Descricao' => $value, 'Ocorrencias' => $val->Ocorrencias, 'Ano' => $val->ano, 'Mes' => $val->Mes]);
            }
            foreach ($q as $val) {
                for ($i = 1; $i <= 12; $i++) {
                    $q = $conn->table('temp_ocorrencias')->select('id')->where('Ano', '=', $val->ano)->where('Mes', '=', $i)->where('occcodigo', '=', $key)->get();
                    if ($q->isEmpty()) {
                        $conn->table('temp_ocorrencias')->insert(['OccCodigo' => $key, 'Descricao' => $value, 'Ocorrencias' => 0, 'Ano' => $val->ano, 'Mes' => $i]);
                    }
                }
            }
        }

        $conn->table('temp_ocorrencias')->where('Ano', '=', Carbon::now()->year)->where('Mes', '>', Carbon::now()->month)->delete();
        $conn->table('temp_ocorrencias')->where('Ano', '<', Carbon::now()->year)->where('Mes', '<', Carbon::now()->month)->delete();
        $conn = DB::connection('mysql');
        $q = $conn->table('temp_ocorrencias')->select('Ocorrencias', 'Ano', 'Mes', 'Descricao', 'OccCodigo')->groupBy('Ano', 'Mes', 'Ocorrencias', 'Descricao', 'OccCodigo')->orderBy('Ano', 'asc')->orderBy('Mes', 'asc')->get();

        $occ_mes = array();
        $occs11 = array();
        $occs20 = array();
        $occs21 = array();
        $occs23 = array();
        $occs27 = array();
        $occs28 = array();
        $occs29 = array();
        $occs32 = array();
        $occs42 = array();
        $occs59 = array();
        $occs62 = array();
        $s = 0;
        $remove = 12 + Carbon::now()->month;
        foreach ($q as $val) {
            if ($val->OccCodigo == 11) {
                array_push($occ_mes, $val->Ano . "-" . $val->Mes);
            }

            switch ($val->OccCodigo) {
                case 11:
                    array_push($occs11, $val->Ocorrencias);
                    break;
                case 20:
                    array_push($occs20, $val->Ocorrencias);
                    break;
                case 21:
                    array_push($occs21, $val->Ocorrencias);
                    break;
                case 23:
                    array_push($occs23, $val->Ocorrencias);
                    break;
                case 27:
                    array_push($occs27, $val->Ocorrencias);
                    break;
                case 28:
                    array_push($occs28, $val->Ocorrencias);
                    break;
                case 29:
                    array_push($occs29, $val->Ocorrencias);
                    break;
                case 32:
                    array_push($occs32, $val->Ocorrencias);
                    break;
                case 42:
                    array_push($occs42, $val->Ocorrencias);
                    break;
                case 59:
                    array_push($occs59, $val->Ocorrencias);
                    break;
                case 62:
                    array_push($occs62, $val->Ocorrencias);
                    break;
            }
        }

        $colors = ['rgba(196, 61, 0, 0.7)', 'rgba(248, 0, 12, 0.7)', 'rgba(157, 0, 89, 0.7)', 'rgba(85, 2, 131, 0.7)', 'rgba(36, 5, 135, 0.7)', 'rgba(6, 31, 133, 0.7)', 'rgba(5, 103, 161, 0.7)', 'rgba(1, 57, 90, 0.7)', 'rgba(0, 125, 101, 0.7)', 'rgba(0, 152, 19, 0.7)', 'rgba(89, 177, 0, 0.7)'];
        $ocorrenciasChart = app()->chartjs
                ->name('$ocorrenciasChart')
                ->type('line')
                ->size(['width' => 500, 'height' => 150])
                ->labels($occ_mes)
                ->datasets([
                    [
                        "label" => "Atualização de efetivos",
                        'backgroundColor' => "rgba(0, 0, 0, 0.0)",
                        'borderColor' => $colors[0],
                        "pointBorderColor" => $colors[0],
                        "pointBackgroundColor" => $colors[0],
                        "pointHoverBackgroundColor" => $colors[0],
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => $occs11,
                    ],
                    [
                        "label" => "Compras de armas",
                        'backgroundColor' => "rgba(182, 26, 26, 0.0)",
                        'borderColor' => $colors[1],
                        "pointBorderColor" => $colors[1],
                        "pointBackgroundColor" => $colors[1],
                        "pointHoverBackgroundColor" => $colors[1],
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => $occs20,
                    ],
                    [
                        "label" => "Penas de multa",
                        'backgroundColor' => "rgba(182, 26, 26, 0.0)",
                        'borderColor' => $colors[2],
                        "pointBorderColor" => $colors[2],
                        "pointBackgroundColor" => $colors[2],
                        "pointHoverBackgroundColor" => $colors[2],
                        "pointHoverBorderColor" => $colors[2],
                        'data' => $occs21,
                    ],
                    /*[
                        "label" => "Penas de advertência",
                        'backgroundColor' => "rgba(182, 26, 26, 0.0)",
                        'borderColor' => $colors[3],
                        "pointBorderColor" => $colors[3],
                        "pointBackgroundColor" => $colors[3],
                        "pointHoverBackgroundColor" => $colors[3],
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => $occs23,
                    ],*/
                    [
                        "label" => "Autorizações para atividades primárias",
                        'backgroundColor' => "rgba(182, 26, 26, 0.0)",
                        'borderColor' => $colors[4],
                        "pointBorderColor" => $colors[4],
                        "pointBackgroundColor" => $colors[4],
                        "pointHoverBackgroundColor" => $colors[4],
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => $occs27,
                    ],
                    /*[
                        "label" => "Autorizações para atividades secundárias",
                        'backgroundColor' => "rgba(182, 26, 26, 0.0)",
                        'borderColor' => $colors[5],
                        "pointBorderColor" => $colors[5],
                        "pointBackgroundColor" => $colors[5],
                        "pointHoverBackgroundColor" => $colors[5],
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => $occs28,
                    ],*/
                    [
                        "label" => "Cancelamentos de atividades principais",
                        'backgroundColor' => "rgba(182, 26, 26, 0.0)",
                        'borderColor' => $colors[6],
                        "pointBorderColor" => $colors[6],
                        "pointBackgroundColor" => $colors[6],
                        "pointHoverBackgroundColor" => $colors[6],
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => $occs29,
                    ],
                    [
                        "label" => "Revisões do alvará de funcionamento",
                        'backgroundColor' => "rgba(182, 26, 26, 0.0)",
                        'borderColor' => $colors[7],
                        "pointBorderColor" => $colors[7],
                        "pointBackgroundColor" => $colors[7],
                        "pointHoverBackgroundColor" => $colors[7],
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => $occs32,
                    ],
                    /*[
                        "label" => "Cancelamentos de atividades secundárias",
                        'backgroundColor' => "rgba(182, 26, 26, 0.0)",
                        'borderColor' => $colors[8],
                        "pointBorderColor" => $colors[8],
                        "pointBackgroundColor" => $colors[8],
                        "pointHoverBackgroundColor" => $colors[8],
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => $occs42,
                    ],*/
                    [
                        "label" => "Renovações do CRS",
                        'backgroundColor' => "rgba(182, 26, 26, 0.0)",
                        'borderColor' => $colors[9],
                        "pointBorderColor" => $colors[9],
                        "pointBackgroundColor" => $colors[9],
                        "pointHoverBackgroundColor" => $colors[9],
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => $occs59,
                    ],
                    /*[
                        "label" => "Atualizações da ISO",
                        'backgroundColor' => "rgba(182, 26, 26, 0.0)",
                        'borderColor' => $colors[10],
                        "pointBorderColor" => $colors[10],
                        "pointBackgroundColor" => $colors[10],
                        "pointHoverBackgroundColor" => $colors[10],
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => $occs62,
                    ],*/
                ])
                ->options([]);

        
        //SERVIÇOS
        $patrimonialBr = array();
        $patrimonialSp = array();
        $formacaoBr = array();
        $formacaoSp = array();
        $escoltaBr = array();
        $escoltaSp = array();
        $pessoalBr = array();
        $pessoalSp = array();
        $transporteBr = array();
        $transporteSp = array();
        
        $conn = DB::connection('rsesvesp');
        $patrimonialBr = $conn->table('pessoas')->join('portaria','portaria.subpessoascodigo','pessoas.pessoascodigo')->where('classificacaocodigo','=',4)->where('pessoasenderecouf','<>','SP')->where('pessoassituacao','=','ATIVA')->count();
        $patrimonialSp = $conn->table('pessoas')->join('portaria','portaria.subpessoascodigo','pessoas.pessoascodigo')->where('classificacaocodigo','=',4)->where('pessoasenderecouf','=','SP')->where('pessoassituacao','=','ATIVA')->count();
        $formacaoBr = $conn->table('pessoas')->join('portaria','portaria.subpessoascodigo','pessoas.pessoascodigo')->where('classificacaocodigo','=',2)->where('pessoasenderecouf','<>','SP')->where('pessoassituacao','=','ATIVA')->count();
        $formacaoSp = $conn->table('pessoas')->join('portaria','portaria.subpessoascodigo','pessoas.pessoascodigo')->where('classificacaocodigo','=',2)->where('pessoasenderecouf','=','SP')->where('pessoassituacao','=','ATIVA')->count();
        $escoltaBr = $conn->table('pessoas')->join('portaria','portaria.subpessoascodigo','pessoas.pessoascodigo')->where('classificacaocodigo','=',8)->where('pessoasenderecouf','<>','SP')->where('pessoassituacao','=','ATIVA')->count();
        $escoltaSp = $conn->table('pessoas')->join('portaria','portaria.subpessoascodigo','pessoas.pessoascodigo')->where('classificacaocodigo','=',8)->where('pessoasenderecouf','=','SP')->where('pessoassituacao','=','ATIVA')->count();
        $pessoalBr = $conn->table('pessoas')->join('portaria','portaria.subpessoascodigo','pessoas.pessoascodigo')->where('classificacaocodigo','=',9)->where('pessoasenderecouf','<>','SP')->where('pessoassituacao','=','ATIVA')->count();
        $pessoalSp = $conn->table('pessoas')->join('portaria','portaria.subpessoascodigo','pessoas.pessoascodigo')->where('classificacaocodigo','=',9)->where('pessoasenderecouf','=','SP')->where('pessoassituacao','=','ATIVA')->count();
        $transporteBr = $conn->table('pessoas')->join('portaria','portaria.subpessoascodigo','pessoas.pessoascodigo')->where('classificacaocodigo','=',1)->where('pessoasenderecouf','<>','SP')->where('pessoassituacao','=','ATIVA')->count();
        $transporteSp = $conn->table('pessoas')->join('portaria','portaria.subpessoascodigo','pessoas.pessoascodigo')->where('classificacaocodigo','=',1)->where('pessoasenderecouf','=','SP')->where('pessoassituacao','=','ATIVA')->count();

        $servicosChart = app()->chartjs
         ->name('servicosChart')
         ->type('bar')
         ->size(['width' => 500, 'height' => 150])
         ->labels(['Segurança Patrimonial', 'Curso de Formação','Escolta Armada','Segurança Pessoal','Transporte de Valores'])
         ->datasets([
             [
                 "label" => "Empresas em outras UF",
                 'backgroundColor' => ['rgba(182, 26, 26, 0.6)', 'rgba(182, 26, 26, 0.6)', 'rgba(182, 26, 26, 0.6)', 'rgba(182, 26, 26, 0.6)', 'rgba(182, 26, 26, 0.6)'],
                 'data' => [$patrimonialBr, $formacaoBr,$escoltaBr,$pessoalBr,$transporteBr]
             ],
             [
                 "label" => "Empresas em SP",
                 'backgroundColor' => ['rgba(41, 92, 138, 0.6)', 'rgba(41, 92, 138, 0.6)', 'rgba(41, 92, 138, 0.6)', 'rgba(41, 92, 138, 0.6)', 'rgba(41, 92, 138, 0.6)'],
                 'data' => [$patrimonialSp, $formacaoSp,$escoltaSp,$pessoalSp,$transporteSp]
             ]
         ])
         ->options([]);

        //CRS
        
        
        $Crs = $conn->table('pessoas')->where('pessoascrsvencimento','>=',date('Y-m-d', strtotime(Carbon::now()) ))->whereRaw("pessoasnumsocio is not null and (pessoassociodesfilia is null or pessoassociodesfilia='' or pessoassociodesfilia='0000-00-00' or pessoassociodesfilia='1000-01-01')")->count();
        $noCrs = $conn->table('pessoas')->where('pessoassituacao','=','ATIVA')->whereRaw("pessoasenderecouf = 'SP' and (pessoascrsvencimento is null or pessoascrsvencimento < '".date('Y-m-d', strtotime(Carbon::now()) )."' or pessoascrsvencimento = '1000-01-01' or pessoascrsvencimento = '0000-00-00') and pessoasnumsocio is not null and (pessoassociodesfilia is null or pessoassociodesfilia='' or pessoassociodesfilia='0000-00-00' or pessoassociodesfilia='1000-01-01')")->count();
        $crsChart = app()->chartjs
         ->name('crsChart')
         ->type('pie')
         ->size(['width' => 400, 'height' => 147])
         ->labels(['Associados com CRS','Associados sem CRS'])
         ->datasets([
             [
                 "label" => "Empresas com CRS",
                 'backgroundColor' => ['rgba(182, 26, 26, 0.6)','rgba(41, 92, 138, 0.6)'],
                 'data' => [$Crs,$noCrs]
             ],
         ])
         ->options([]);

       $Iso = $conn->table('pessoas')->where('pessoasisovalidade','>=',date('Y-m-d', strtotime(Carbon::now()) ))->whereRaw("pessoasnumsocio is not null and (pessoassociodesfilia is null or pessoassociodesfilia='' or pessoassociodesfilia='0000-00-00' or pessoassociodesfilia='1000-01-01')")->count();
        $noIso = $conn->table('pessoas')->where('pessoassituacao','=','ATIVA')->whereRaw("pessoasenderecouf = 'SP' and (pessoasisovalidade is null or pessoasisovalidade < '".date('Y-m-d', strtotime(Carbon::now()) )."' or pessoascrsvencimento = '1000-01-01' or pessoascrsvencimento = '0000-00-00') and pessoasnumsocio is not null and (pessoassociodesfilia is null or pessoassociodesfilia='' or pessoassociodesfilia='0000-00-00' or pessoassociodesfilia='1000-01-01')")->count();
        $isoChart = app()->chartjs
         ->name('isoChart')
         ->type('pie')
         ->size(['width' => 400, 'height' => 142])
         ->labels(['Associados com Certificação ISO 9001','Associados sem Certificação ISO 9001'])
         ->datasets([
             [
                 'backgroundColor' => ['rgba(182, 26, 26, 0.6)','rgba(41, 92, 138, 0.6)'],
                 'data' => [$Iso,$noIso]
             ],
         ])
         ->options([]);

        
        $atividades = $conn = DB::connection('rsesvesp');
        $atividades = $conn->select("
                select pessoas.pessoasnome nome, acpcrm.occcrmcodigo codigo, acpcrm.acpcrmdata data, acpcrmcomplemento acompanhamento, acpcrmcodigo acompcodigo
                from acpcrm inner join pessoas on acpcrm.pessoascodigo=pessoas.pessoascodigo
                where pessoas.pessoassituacao='ATIVA' and pessoasnumsocio is not null and (pessoassociodesfilia is null or pessoassociodesfilia='' or pessoassociodesfilia='0000-00-00' or pessoassociodesfilia='1000-01-01') and
                pessoasenderecouf='SP' and acpcrmdata >= '$ano' and occcrmcodigo in(11,20,28,29,32,42,59,62) order by acpcrmdata desc limit 7
                ");
        $atividades = collect($atividades);
        $atividades = json_decode($atividades, true);

        Carbon::setLocale('pt_BR');
        foreach($atividades as &$atv){
            switch($atv["codigo"]){
                case 11:
                    $atv["codigo"] = "atualizou o número de efetivos.";
                    break;
                case 20:
                    $atv["codigo"] = "obteve nova autorização para adquirir armas.";
                    break;
                case 21:
                    $atv["codigo"] = "foi penalizada com pena de multa.";
                    break;
                case 23:
                    $atv["codigo"] = "foi penalizada com pena de advertência.";
                    break;
                case 28:
                    $atv["codigo"] = "foi autorizada a prestar serviços de atividade secundária.";
                    break;
                case 32:
                    $atv["codigo"] = "teve revista sua autorização de funcionamento.";
                    break;
                case 42:
                    $atv["codigo"] = "teve cancelada sua autorização para prestar serviços de atividade secundária.";
                    break;
                case 59:
                    $atv["codigo"] = "renovou seu Certificado CRS.";
                    break;
                case 59:
                    $atv["codigo"] = "renovou sua Certificação ISO.";
                    break;
            }
        }
        
        
        return view('home', compact('atividades','isoChart','noIso','Iso','NumeroEmpresasNaoAssociadas','NumeroEmpresasAssociadas','Crs','noCrs','crsChart','servicosChart', 'multasChart', 'empresas', 'vigilantes', 'empresasZ', 'vigilantesZ', 'empresasChart', 'vigilantesChart', 'zonasEmpresasChart', 'zonasVigilantesChart', 'emp', 'regionais', 'efetivosChart', 'efetivosNaoAssociadosChart', 'efetivos', 'datas', 'efetivosDia', 'NumeroEmpresasAssociadas', 'NumeroEmpresasNaoAssociadas'));
    }

}
