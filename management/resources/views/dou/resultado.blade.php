@extends('adminlte::page')

@section('title', 'Gerenciador - Painel')

@section('content_header')
    <h1>Cadastro do DOU</h1>
@stop

@section('content')
@if($mensagem === "Sucesso!")
    <div class="alert alert-success">
        <strong>Pronto!</strong> Os dados foram extraídos com êxito.
    </div>
@else
    <div class="alert alert-warning">
        <strong>Erro!</strong> Houve problemas na extração dos dados.
    </div>
@endif

<?php $i=0;

     $occ = array(
            10 => "ALTERAÇÃO RAZÃO SOCIAL", //ALTERAÇÃO RAZÃO SOCIAL
            20 => "AUTORIZAÇÃO DE COMPRA DE ARMAS", //AUTORIZAÇÃO DE COMPRA DE ARMAS
            21 => "PENA DE MULTA", //PENA DE MULTA
            22 => "ARQUIVO DE PROCESSO", //ARQUIVO DE PROCESSO
            23 => "PENA DE ADVERTÊNCIA", //PENA DE ADVERTÊNCIA
            27 => "AUTORIZAÇÃO ATIVIDADE PRINCIPAL", //AUTORIZAÇÃO ATIVIDADE PRINCIPAL
            28 => "AUTORIZAÇÃO ATIVIDADE SECUNDÁRIA", //AUTORIZAÇÃO ATIVIDADE SECUNDÁRIA
            29 => "CANCELAMENTO ATIVIDADE PRINCIPAL", //CANCELAMENTO ATIVIDADE PRINCIPAL
            32 => "REVISÃO DO ALVARÁ DE FUNCIONAMENTO", //REVISÃO DO ALVARÁ DE FUNC.
            42 => "CANCELAMENTO ATIVIDADE SECUNDÁRIA", //CANCELAMENTO ATIVIDADE SECUNDÁRIA
            );

?>
<div>

@foreach ($portarias as $p)

    <div class="row">
            <!-- left column -->
            <div class="col-xs-12">
                <!-- general form elements -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Portaria {{$i+1}}</h3>
                    </div>

                        <div class="box-body">
                            <label for="">Data do DOU:</label>
                            <input type="text" name="control1" class="form-control" value="{{$portarias[$i]['DataDOU']}}" disabled>
                            <br>
                            
                            <label for="">Número da Portaria: </label>
                            <input type="text" name="control2" class="form-control" value="{{$portarias[$i]['NumeroPortaria']}}" disabled>
                            <br>
                            
                            <label for="">Data da Portaria: </label>
                            <input type="text" name="control3" class="form-control" value="{{$portarias[$i]['DataPortaria']}}" disabled>
                            <br>
                            
                            <label for="">CNPJ da empresa: </label>
                            <input type="text" name="control4" class="form-control" value="{{$portarias[$i]['CNPJ']}}" disabled>
                            <br>
                            
                            @foreach($occ as $key => $value)
                                @if($key == $portarias[$i]['Ocorrencia'])
                                <label for="">Ocorrência: </label>
                                <input type="text" name="control5" class="form-control" value="{{$value}}" disabled>
                                <br>
                                @endif
                            @endforeach
                            
                            <label for="">Acompanhamento: </label>
                            <textarea class="form-control" rows="7" name="control6" disabled>{{$portarias[$i]['Acompanhamento']}}</textarea>
                            <br>
                            
                            @if(!empty($portarias[$i]['NovaRazao']))
                            <label for="">Nova Razão Social: </label>
                            <input type="text" class="form-control" name="control7" value="{{$portarias[$i]['NovaRazao']}}" disabled>
                            <br>
                            @endif
                            
                            @if(!empty($portarias[$i]['Atividades']))
                            <label for="">Atividades: </label>
                            @foreach($portarias[$i]['Atividades'] as $atv)
                                @if($atv == 4)
                                    <input type="text" class="form-control" name="control8" value="Segurança Patrimonial" disabled>
                                <br>
                                @elseif($atv == 2)
                                    <input type="text" class="form-control" name="control9" value="Curso de Formação" disabled>
                                <br>
                                @elseif($atv == 1)
                                    <input type="text" class="form-control" name="control10" value="Transporte de Valores" disabled>
                                <br>                                
                                @elseif($atv == 8)
                                    <input type="text" class="form-control" name="control11" value="Escolta Armada" disabled>
                                <br>     
                                @elseif($atv == 9)
                                    <input type="text" class="form-control" name="control12" value="Segurança Pessoal" disabled>
                                <br>   
                                @endif
                            @endforeach
                            @endif
                        </div>
                </div>
            </div>
    </div>
    <br>
    <?php $i++ ?>
@endforeach
<form role="form" id="form" method="POST" name="form" action="{{url('dou/cadastrar')}}">
{{csrf_field()}}
<input type="hidden" id="portarias" name="portarias" value="{{json_encode($portarias)}}">
<a href="{{ URL::previous() }}" class="button btn btn-primary btn-lg btn-block" type="button">Voltar</a>
<button class="btn btn-success btn-lg btn-block" type="submit" name="save" id="save">Prosseguir com o cadastro</button>
<br>
</form>
    <br><br>
</div>
@stop