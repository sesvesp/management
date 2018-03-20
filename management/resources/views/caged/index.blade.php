@extends('adminlte::page')

@section('title', 'Gerenciador - Painel')

@section('content_header')
    <h1>Envio de CAGED</h1>
@stop

@section('content')
        <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                    </div>
                    <form role="form" id="form" method="POST" action="{{url('')}}">
                        {{csrf_field()}}
                        <div class="box-body">
                            <pre>{{var_dump($empresas)}}</pre>
                        </div>

                        
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="save" id="save">Prosseguir com envio</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop