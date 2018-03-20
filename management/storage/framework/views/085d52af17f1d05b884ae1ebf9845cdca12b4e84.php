<?php $__env->startSection('title', 'Gerenciador - Painel'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Cadastro do DOU</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if($mensagem === "Sucesso!"): ?>
    <div class="alert alert-success">
        <strong>Pronto!</strong> Os dados foram extraídos com êxito.
    </div>
<?php else: ?>
    <div class="alert alert-warning">
        <strong>Erro!</strong> Houve problemas na extração dos dados.
    </div>
<?php endif; ?>

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

<?php $__currentLoopData = $portarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <div class="row">
            <!-- left column -->
            <div class="col-xs-12">
                <!-- general form elements -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Portaria <?php echo e($i+1); ?></h3>
                    </div>

                        <div class="box-body">
                            <label for="">Data do DOU:</label>
                            <input type="text" name="control1" class="form-control" value="<?php echo e($portarias[$i]['DataDOU']); ?>" disabled>
                            <br>
                            
                            <label for="">Número da Portaria: </label>
                            <input type="text" name="control2" class="form-control" value="<?php echo e($portarias[$i]['NumeroPortaria']); ?>" disabled>
                            <br>
                            
                            <label for="">Data da Portaria: </label>
                            <input type="text" name="control3" class="form-control" value="<?php echo e($portarias[$i]['DataPortaria']); ?>" disabled>
                            <br>
                            
                            <label for="">CNPJ da empresa: </label>
                            <input type="text" name="control4" class="form-control" value="<?php echo e($portarias[$i]['CNPJ']); ?>" disabled>
                            <br>
                            
                            <?php $__currentLoopData = $occ; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($key == $portarias[$i]['Ocorrencia']): ?>
                                <label for="">Ocorrência: </label>
                                <input type="text" name="control5" class="form-control" value="<?php echo e($value); ?>" disabled>
                                <br>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            <label for="">Acompanhamento: </label>
                            <textarea class="form-control" rows="7" name="control6" disabled><?php echo e($portarias[$i]['Acompanhamento']); ?></textarea>
                            <br>
                            
                            <?php if(!empty($portarias[$i]['NovaRazao'])): ?>
                            <label for="">Nova Razão Social: </label>
                            <input type="text" class="form-control" name="control7" value="<?php echo e($portarias[$i]['NovaRazao']); ?>" disabled>
                            <br>
                            <?php endif; ?>
                            
                            <?php if(!empty($portarias[$i]['Atividades'])): ?>
                            <label for="">Atividades: </label>
                            <?php $__currentLoopData = $portarias[$i]['Atividades']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($atv == 4): ?>
                                    <input type="text" class="form-control" name="control8" value="Segurança Patrimonial" disabled>
                                <br>
                                <?php elseif($atv == 2): ?>
                                    <input type="text" class="form-control" name="control9" value="Curso de Formação" disabled>
                                <br>
                                <?php elseif($atv == 1): ?>
                                    <input type="text" class="form-control" name="control10" value="Transporte de Valores" disabled>
                                <br>                                
                                <?php elseif($atv == 8): ?>
                                    <input type="text" class="form-control" name="control11" value="Escolta Armada" disabled>
                                <br>     
                                <?php elseif($atv == 9): ?>
                                    <input type="text" class="form-control" name="control12" value="Segurança Pessoal" disabled>
                                <br>   
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                </div>
            </div>
    </div>
    <br>
    <?php $i++ ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<form role="form" id="form" method="POST" name="form" action="<?php echo e(url('dou/cadastrar')); ?>">
<?php echo e(csrf_field()); ?>

<input type="hidden" id="portarias" name="portarias" value="<?php echo e(json_encode($portarias)); ?>">
<a href="<?php echo e(URL::previous()); ?>" class="button btn btn-primary btn-lg btn-block" type="button">Voltar</a>
<button class="btn btn-success btn-lg btn-block" type="submit" name="save" id="save">Prosseguir com o cadastro</button>
<br>
</form>
    <br><br>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>