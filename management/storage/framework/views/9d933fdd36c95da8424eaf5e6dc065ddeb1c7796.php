<?php $__env->startSection('title', 'Gerenciador - Painel'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Painel</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
                <span class="info-box-number"><?php echo e($NumeroEmpresasAssociadas); ?></span>

                <div class="progress">
                    <div class="progress-bar" style="width: <?php echo e(intval($NumeroEmpresasAssociadas / ($NumeroEmpresasNaoAssociadas+$NumeroEmpresasAssociadas) * 100)); ?>%"></div>
                </div>
                <span class="progress-description">
                    <?php echo e(intval($NumeroEmpresasAssociadas / ($NumeroEmpresasNaoAssociadas+$NumeroEmpresasAssociadas) * 100)); ?>% das empresas do estado de São Paulo
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="info-box bg-light-blue">
            <span class="info-box-icon"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Empresas Não Associadas</span>
                <span class="info-box-number"><?php echo e($NumeroEmpresasNaoAssociadas); ?></span>

                <div class="progress">
                    <div class="progress-bar" style="width: <?php echo e(intval($NumeroEmpresasNaoAssociadas / ($NumeroEmpresasNaoAssociadas+$NumeroEmpresasAssociadas) * 100)); ?>%"></div>
                </div>
                <span class="progress-description">
                    <?php echo e(intval($NumeroEmpresasNaoAssociadas / ($NumeroEmpresasNaoAssociadas+$NumeroEmpresasAssociadas) * 100)); ?>% das empresas do estado de São Paulo
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
                            <?php echo $efetivosNaoAssociadosChart->render(); ?>

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
                            <?php echo $multasChart->render(); ?>

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
                    <?php echo $servicosChart->render(); ?>

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
                    <?php echo $crsChart->render(); ?> 
                </div>
                <div align="right">
                    <span class="label label-primary"><b>Associados com CRS: </b> <?php echo e(intval($Crs/($Crs+$noCrs)*100)); ?>%</span><br>
                    <span class="label label-primary"><b>Associados sem CRS: </b> <?php echo e(intval($noCrs/($Crs+$noCrs)*100)); ?>%</span>
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
                                <th style="width: 37%">Empresa</th>
                                <th>Ocorrência</th>
                                <th style="width: 50px"></th>
                                <th style="width: 120px"></th>
                            </tr>
                            <?php $i=1 ?>
                            <?php $__currentLoopData = $atividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $occ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><span class="badge bg-primary"><?php echo e($i); ?></span></td>
                                <td><?php echo e(str_limit($occ["nome"],45,"...")); ?></td>
                                <td><?php echo e($occ["codigo"]); ?></td>
                                <td><button name="<?php echo e($occ["acompcodigo"]); ?>" id="<?php echo e($occ["acompcodigo"]); ?>" type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal<?php echo e($occ["acompcodigo"]); ?>"><i class="fa fa-eye"></i></button></td>
                                <td align="right"><small style="color: gray"><i class="fa fa-clock-o"></i> </small> <?php echo e(\Carbon\Carbon::parse($occ["data"])->diffForHumans()); ?></td>
                            </tr>
                            <?php $i++?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php echo $isoChart->render(); ?> 
                </div>
                <div align="right">
                    <span class="label label-primary"><b>Associados com Certificação ISO 9001: </b> <?php echo e(intval($Iso/($Iso+$noIso)*100)); ?>%</span><br>
                    <span class="label label-primary"><b>Associados sem Certificação ISO 9001: </b> <?php echo e(intval($noIso/($Iso+$noIso)*100)); ?>%</span>
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
                            <span class="label label-danger"><b>ABC:</b> <?php echo e(intval($empresas[0] / array_sum($empresas) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>Bauru: </b> <?php echo e(intval($empresas[1] / array_sum($empresas) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>Campinas: </b> <?php echo e(intval($empresas[2] / array_sum($empresas) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>Santos: </b> <?php echo e(intval($empresas[3] / array_sum($empresas) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>São Carlos: </b> <?php echo e(intval($empresas[4] / array_sum($empresas) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>São José dos Campos: </b> <?php echo e(intval($empresas[5] / array_sum($empresas) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>São Paulo: </b> <?php echo e(intval($empresas[6] / array_sum($empresas) * 100)); ?>%</span><br>
                        </div>
                    </div>
                    <div style="width:75%;" class="col-md-3">
                        <div >
                            <?php echo $empresasChart->render(); ?>

                        </div>
                        <br>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="width:75%;" class="col-md-3">
                        <div >
                            <?php echo $vigilantesChart->render(); ?>

                        </div>
                    </div>
                    <div class="col-md-3" align="center">
                        <div align="right">
                            <br>
                            <span class="label label-danger"><b>ABC:</b> <?php echo e(intval($vigilantes[0] / array_sum($vigilantes) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>Bauru: </b> <?php echo e(intval($vigilantes[1] / array_sum($vigilantes) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>Campinas: </b> <?php echo e(intval($vigilantes[2] / array_sum($vigilantes) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>Santos: </b> <?php echo e(intval($vigilantes[3] / array_sum($vigilantes) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>São Carlos: </b> <?php echo e(intval($vigilantes[4] / array_sum($vigilantes) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>São José dos Campos: </b> <?php echo e(intval($vigilantes[5] / array_sum($vigilantes) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>São Paulo: </b> <?php echo e(intval($vigilantes[6] / array_sum($vigilantes) * 100)); ?>%</span><br>
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
                            <span class="label label-danger"><b>Centro:</b> <?php echo e(intval($empresasZ[0] / array_sum($empresasZ) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>Zona Leste: </b> <?php echo e(intval($empresasZ[1] / array_sum($empresasZ) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>Zona Norte: </b> <?php echo e(intval($empresasZ[2] / array_sum($empresasZ) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>Zona Oeste: </b> <?php echo e(intval($empresasZ[3] / array_sum($empresasZ) * 100)); ?>%</span><br>
                        </div>
                    </div>
                    <div style="width:75%;" class="col-md-3">
                        <div><?php echo $zonasEmpresasChart->render(); ?></div>
                        <br>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="width:75%;" class="col-md-3">
                        <div ><?php echo $zonasVigilantesChart->render(); ?></div>
                    </div>
                    <div class="col-md-3" align="right">
                        <div align="right">
                            <br><br>
                            <span class="label label-danger"><b>Centro: </b> <?php echo e(intval($vigilantesZ[0] / array_sum($vigilantesZ) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>Zona Leste: </b> <?php echo e(intval($vigilantesZ[1] / array_sum($vigilantesZ) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>Zona Norte: </b> <?php echo e(intval($vigilantesZ[2] / array_sum($vigilantesZ) * 100)); ?>%</span><br>
                            <span class="label label-danger"><b>Zona Oeste: </b> <?php echo e(intval($vigilantesZ[3] / array_sum($vigilantesZ) * 100)); ?>%</span><br>
                        </div>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </div>


    <?php $__currentLoopData = $atividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $occ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="modal<?php echo e($occ["acompcodigo"]); ?>" tabindex="-1" role="dialog" aria-labelledby="modal<?php echo e($occ["acompcodigo"]); ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal<?php echo e($occ["acompcodigo"]); ?>">Ocorrência</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo e($occ["acompanhamento"]); ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



    <?php $__env->stopSection(); ?>





    <?php $__env->startSection('js'); ?>



    <?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>