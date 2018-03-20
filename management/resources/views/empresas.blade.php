@extends('adminlte::page')

@section('title', 'Gerenciador - Painel')

@section('content_header')
    <h1>Cadastro de Empresas</h1>
@stop

@section('content')

    <script>
        $('#myModal').modal(options)

    </script>


    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Dados cadastrais</h3>
                    </div>
                    <form role="form" id="form" method="POST" action="{{url('empresas')}}">
                        {{csrf_field()}}
                        <div class="box-body">
                            <p class="help-block">Copie os dados da consulta feita no site da <a href="http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/Cnpjreva_Solicitacao.asp">Receita Federal</a> e cole no campo abaixo:</p>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Dados da empresa:</label>
                                <textarea id="pessoasData" name="pessoasData" class="form-control" rows="7" placeholder="Cole aqui ..." required></textarea>
                            </div>
                        </div>

                        <div class="box-body">
                            <p class="help-block">Copie os dados do '<i>Quadro de Sócios e Administradores - QSA</i>' e cole no campo abaixo:</p>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Dados do QSA:</label>
                                <textarea id="pessoasQSA" name="pessoasQSA" class="form-control" rows="7" placeholder="Cole aqui ..."></textarea>
                            </div>
                        </div>

                        <div class="box-body">
                            <p class="help-block">Copie os dados do DOU e cole no campo abaixo (Opicional):</p>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Autorização de atividade principal :</label>
                                <textarea id="pessoasAlvara" name="pessoasAlvara" class="form-control" rows="7" placeholder="Cole aqui ..."></textarea>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="save" id="save">Cadastrar</button> <button type="submit" class="btn btn-secondary" id="check" name="check">Verificar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>




    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@stop