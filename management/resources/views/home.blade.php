@extends('adminlte::page')

@section('title', 'Gerenciador - Painel')

@section('content_header')
<h1>Painel</h1>
@stop

@section('content')
<div class="row">
    <div align="center" class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Números de empresas</h3>
            </div>
            <div class="box-body">
    <div class="col-md-6">
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="ion ion-ios-people"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Empresas Associadas</span>
                <span class="info-box-number">{{$NumeroEmpresasAssociadas}}</span>

                <div class="progress">
                    <div class="progress-bar" style="width: {{intval($NumeroEmpresasAssociadas / ($NumeroEmpresasNaoAssociadas+$NumeroEmpresasAssociadas) * 100)}}%"></div>
                </div>
                <span class="progress-description">
                    {{intval($NumeroEmpresasAssociadas / ($NumeroEmpresasNaoAssociadas+$NumeroEmpresasAssociadas) * 100)}}% das empresas do estado de São Paulo
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="info-box bg-light-blue">
            <span class="info-box-icon"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Empresas Não Associadas</span>
                <span class="info-box-number">{{$NumeroEmpresasNaoAssociadas}}</span>

                <div class="progress">
                    <div class="progress-bar" style="width: {{intval($NumeroEmpresasNaoAssociadas / ($NumeroEmpresasNaoAssociadas+$NumeroEmpresasAssociadas) * 100)}}%"></div>
                </div>
                <span class="progress-description">
                    {{intval($NumeroEmpresasNaoAssociadas / ($NumeroEmpresasNaoAssociadas+$NumeroEmpresasAssociadas) * 100)}}% das empresas do estado de São Paulo
                </span>
            </div>
        </div>
    </div>
            </div>
</div>

<div class="row">
    <div class="col-md-6" align="center">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Efetivos (SP)</h3>
            </div>
            <div class="box-body">
                <div>
                    <div style="width:100%;">
                        <div align="center">
                            {!! $efetivosNaoAssociadosChart->render() !!}
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6" align="center">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Penas de Multa (SP)</h3>
            </div>
            <div class="box-body">
                <div>
                    <div style="width:100%;">
                        <div align="center">
                            Valores das multas no último ano: <br>
                            {!! $multasChart->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row" align="center">
    <div class="col-md-7">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Empresas por Atividade</h3>
            </div>
            <div class="box-body">
                <div style="width:100%;">
                    {!! $servicosChart->render() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">CRS</h3>
            </div>
            <div class="box-body">
                <div align="left">
                    {!! $crsChart->render() !!} 
                </div>
                <div align="right">
                    <span class="label label-primary"><b>Associados com CRS: </b> {{intval($Crs/($Crs+$noCrs)*100)}}%</span><br>
                    <span class="label label-primary"><b>Associados sem CRS: </b> {{intval($noCrs/($Crs+$noCrs)*100)}}%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" align="center">
    <div class="col-md-7">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Últimas Ocorrências</h3>
            </div>
            <div class="box-body">
                <div class="box-body no-padding" name="acompDiv" id="acompDiv">
                    <table class="table table-condensed">
                        <tbody><tr>
                                <th style="width: 10px"></th>
                                <th style="width: 40%">Empresa</th>
                                <th>Ocorrência</th>
                                <th style="width: 50px"></th>
                                <th style="width: 120px"></th>
                            </tr>
                            <?php $i=1 ?>
                            @foreach($atividades as $occ)
                            <tr>
                                <td><span class="badge bg-primary">{{$i}}</span></td>
                                <td>{{str_limit($occ["nome"],45,"...")}}</td>
                                <td>{{$occ["codigo"]}}</td>
                                <td><button name="{{$occ["acompcodigo"]}}" id="{{$occ["acompcodigo"]}}" type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal{{$occ["acompcodigo"]}}"><i class="fa fa-eye"></i></button></td>
                                <td align="right"><small style="color: gray"><i class="fa fa-clock-o"></i> </small> {{\Carbon\Carbon::parse($occ["data"])->diffForHumans()}}</td>
                            </tr>
                            <?php $i++?>
                            @endforeach
                        </tbody></table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">ISO 9001</h3>
            </div>
            <div class="box-body">
                <div align="left">
                    {!! $isoChart->render() !!} 
                </div>
                <div align="right">
                    <span class="label label-primary"><b>Associados com Certificação ISO 9001: </b> {{intval($Iso/($Iso+$noIso)*100)}}%</span><br>
                    <span class="label label-primary"><b>Associados sem Certificação ISO 9001: </b> {{intval($noIso/($Iso+$noIso)*100)}}%</span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12" align="center">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Regionais de SP no geral</h3>
            </div>
            <div class="box-body">
                <div class="col-md-6">
                    <div class="col-md-3" align="center">
                        <div align="right">
                            <br>
                            <span class="label label-danger"><b>ABC:</b> {{intval($empresas[0] / array_sum($empresas) * 100)}}%</span><br>
                            <span class="label label-danger"><b>Bauru: </b> {{intval($empresas[1] / array_sum($empresas) * 100)}}%</span><br>
                            <span class="label label-danger"><b>Campinas: </b> {{intval($empresas[2] / array_sum($empresas) * 100)}}%</span><br>
                            <span class="label label-danger"><b>Santos: </b> {{intval($empresas[3] / array_sum($empresas) * 100)}}%</span><br>
                            <span class="label label-danger"><b>São Carlos: </b> {{intval($empresas[4] / array_sum($empresas) * 100)}}%</span><br>
                            <span class="label label-danger"><b>São José dos Campos: </b> {{intval($empresas[5] / array_sum($empresas) * 100)}}%</span><br>
                            <span class="label label-danger"><b>São Paulo: </b> {{intval($empresas[6] / array_sum($empresas) * 100)}}%</span><br>
                        </div>
                    </div>
                    <div style="width:75%;" class="col-md-3">
                        <div >
                            {!! $empresasChart->render() !!}
                        </div>
                        <br>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="width:75%;" class="col-md-3">
                        <div >
                            {!! $vigilantesChart->render() !!}
                        </div>
                    </div>
                    <div class="col-md-3" align="center">
                        <div align="right">
                            <br>
                            <span class="label label-danger"><b>ABC:</b> {{intval($vigilantes[0] / array_sum($vigilantes) * 100)}}%</span><br>
                            <span class="label label-danger"><b>Bauru: </b> {{intval($vigilantes[1] / array_sum($vigilantes) * 100)}}%</span><br>
                            <span class="label label-danger"><b>Campinas: </b> {{intval($vigilantes[2] / array_sum($vigilantes) * 100)}}%</span><br>
                            <span class="label label-danger"><b>Santos: </b> {{intval($vigilantes[3] / array_sum($vigilantes) * 100)}}%</span><br>
                            <span class="label label-danger"><b>São Carlos: </b> {{intval($vigilantes[4] / array_sum($vigilantes) * 100)}}%</span><br>
                            <span class="label label-danger"><b>São José dos Campos: </b> {{intval($vigilantes[5] / array_sum($vigilantes) * 100)}}%</span><br>
                            <span class="label label-danger"><b>São Paulo: </b> {{intval($vigilantes[6] / array_sum($vigilantes) * 100)}}%</span><br>
                        </div>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12" align="center">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Zonas de São Paulo no geral</h3>
            </div>
            <div class="box-body">
                <div class="col-md-6">
                    <div class="col-md-3" align="right">
                        <div alight="left">
                            <br><br>
                            <span class="label label-danger"><b>Centro:</b> {{intval($empresasZ[0] / array_sum($empresasZ) * 100)}}%</span><br>
                            <span class="label label-danger"><b>Zona Leste: </b> {{intval($empresasZ[1] / array_sum($empresasZ) * 100)}}%</span><br>
                            <span class="label label-danger"><b>Zona Norte: </b> {{intval($empresasZ[2] / array_sum($empresasZ) * 100)}}%</span><br>
                            <span class="label label-danger"><b>Zona Oeste: </b> {{intval($empresasZ[3] / array_sum($empresasZ) * 100)}}%</span><br>
                        </div>
                    </div>
                    <div style="width:75%;" class="col-md-3">
                        <div>{!! $zonasEmpresasChart->render() !!}</div>
                        <br>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="width:75%;" class="col-md-3">
                        <div >{!! $zonasVigilantesChart->render() !!}</div>
                    </div>
                    <div class="col-md-3" align="right">
                        <div align="right">
                            <br><br>
                            <span class="label label-danger"><b>Centro: </b> {{intval($vigilantesZ[0] / array_sum($vigilantesZ) * 100)}}%</span><br>
                            <span class="label label-danger"><b>Zona Leste: </b> {{intval($vigilantesZ[1] / array_sum($vigilantesZ) * 100)}}%</span><br>
                            <span class="label label-danger"><b>Zona Norte: </b> {{intval($vigilantesZ[2] / array_sum($vigilantesZ) * 100)}}%</span><br>
                            <span class="label label-danger"><b>Zona Oeste: </b> {{intval($vigilantesZ[3] / array_sum($vigilantesZ) * 100)}}%</span><br>
                        </div>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </div>


    @foreach($atividades as $occ)
    <div class="modal fade" id="modal{{$occ["acompcodigo"]}}" tabindex="-1" role="dialog" aria-labelledby="modal{{$occ["acompcodigo"]}}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal{{$occ["acompcodigo"]}}">Ocorrência</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{$occ["acompanhamento"]}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach



    @stop





    @section('js')



    @stop

