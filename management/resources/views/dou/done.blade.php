@extends('adminlte::page')

@section('title', 'Gerenciador - Painel')

@section('content_header')
    <div class="alert alert-success">
        <strong>Pronto!</strong> Os dados foram cadastrados com êxito.
    </div>
@stop

@section('content')

    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Banco de dados</h3>
                    </div>

                    <div class="box-body">
                        <p class="help-block">Execute o codigo abaixo no banco de dados do antigo sistema:</p>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Insert</label>
                            <textarea id="pessoasData" name="pessoasData" class="form-control" rows="20">{{$query}}</textarea>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@stop