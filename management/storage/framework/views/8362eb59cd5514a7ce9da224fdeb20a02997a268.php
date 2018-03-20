<?php $__env->startSection('title', 'Gerenciador - Painel'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Painel</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
                <h3 class="box-title">Penas de Multa</h3>
            </div>
            <div class="box-body">
                <div>
                    <div style="width:100%;">
                        <div align="center">
                            Valores das multas no último ano (Brasil): <br>
                            <?php echo $multasChart->render(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-12" align="center">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Regionais de SP</h3>
            </div>
            <div class="box-body">
                <div class="col-md-6">
                    <div class="col-md-3" align="center">
                        <div align="right">
                            <br>
                            <b>ABC:</b> <?php echo e(intval($empresas[0] / array_sum($empresas) * 100)); ?>%<br>
                            <b>Bauru: </b> <?php echo e(intval($empresas[1] / array_sum($empresas) * 100)); ?>%<br>
                            <b>Campinas: </b> <?php echo e(intval($empresas[2] / array_sum($empresas) * 100)); ?>%<br>
                            <b>Santos: </b> <?php echo e(intval($empresas[3] / array_sum($empresas) * 100)); ?>%<br>
                            <b>São Carlos: </b> <?php echo e(intval($empresas[4] / array_sum($empresas) * 100)); ?>%<br>
                            <b>São José dos Campos: </b> <?php echo e(intval($empresas[5] / array_sum($empresas) * 100)); ?>%<br>
                            <b>São Paulo: </b> <?php echo e(intval($empresas[6] / array_sum($empresas) * 100)); ?>%<br>
                        </div>
                    </div>
                    <div style="width:75%;" class="col-md-3">
                        <h4> Empresas: </h4>
                        <?php echo $empresasChart->render(); ?>

                        <br>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="width:75%;" class="col-md-3">
                        <h4> Vigilantes: </h4>
                        <?php echo $vigilantesChart->render(); ?>

                    </div>
                    <div class="col-md-3" align="center">
                        <div align="right">
                            <br>
                            <b>ABC:</b> <?php echo e(intval($vigilantes[0] / array_sum($vigilantes) * 100)); ?>%<br>
                            <b>Bauru: </b> <?php echo e(intval($vigilantes[1] / array_sum($vigilantes) * 100)); ?>%<br>
                            <b>Campinas: </b> <?php echo e(intval($vigilantes[2] / array_sum($vigilantes) * 100)); ?>%<br>
                            <b>Santos: </b> <?php echo e(intval($vigilantes[3] / array_sum($vigilantes) * 100)); ?>%<br>
                            <b>São Carlos: </b> <?php echo e(intval($vigilantes[4] / array_sum($vigilantes) * 100)); ?>%<br>
                            <b>São José dos Campos: </b> <?php echo e(intval($vigilantes[5] / array_sum($vigilantes) * 100)); ?>%<br>
                            <b>São Paulo: </b> <?php echo e(intval($vigilantes[6] / array_sum($vigilantes) * 100)); ?>%<br>
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
                <h3 class="box-title">Zonas de São Paulo</h3>
            </div>
            <div class="box-body">
                <div class="col-md-6">
                    <div class="col-md-3" align="right">
                        <div alight="left">
                            <br><br>
                            <b>Centro:</b> <?php echo e(intval($empresasZ[0] / array_sum($empresasZ) * 100)); ?>%<br>
                            <b>Zona Leste: </b> <?php echo e(intval($empresasZ[1] / array_sum($empresasZ) * 100)); ?>%<br>
                            <b>Zona Norte: </b> <?php echo e(intval($empresasZ[2] / array_sum($empresasZ) * 100)); ?>%<br>
                            <b>Zona Oeste: </b> <?php echo e(intval($empresasZ[3] / array_sum($empresasZ) * 100)); ?>%<br>
                        </div>
                    </div>
                    <div style="width:75%;" class="col-md-3">
                        <h4> Empresas: </h4>
                        <?php echo $zonasEmpresasChart->render(); ?>

                        <br>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="width:75%;" class="col-md-3">
                        <h4> Vigilantes: </h4>
                        <?php echo $zonasVigilantesChart->render(); ?>

                    </div>
                    <div class="col-md-3" align="right">
                        <div align="right">
                            <br><br>
                            <b>Centro: </b> <?php echo e(intval($vigilantesZ[0] / array_sum($vigilantesZ) * 100)); ?>%<br>
                            <b>Zona Leste: </b> <?php echo e(intval($vigilantesZ[1] / array_sum($vigilantesZ) * 100)); ?>%<br>
                            <b>Zona Norte: </b> <?php echo e(intval($vigilantesZ[2] / array_sum($vigilantesZ) * 100)); ?>%<br>
                            <b>Zona Oeste: </b> <?php echo e(intval($vigilantesZ[3] / array_sum($vigilantesZ) * 100)); ?>%<br>
                        </div>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8" align="center">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Serviços de Segurança</h3>
            </div>
            <div class="box-body">
                <div style="width:75%;">
                    <?php echo $servicosChart->render(); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4" align="center">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">CRS</h3>
            </div>
            <div class="box-body">
                <div>
                    <?php echo $crsChart->render(); ?>

                    <br><br>
                    <b>Empresas com CRS:</b> <?php echo e(intval($Crs/($Crs+$noCrs)*100)); ?>%
                    <br>
                    <b>Empresas sem CRS:</b> <?php echo e(intval($noCrs/($Crs+$noCrs)*100)); ?>%
                    <br><br><br><br>
                </div>
            </div>
        </div>
    </div>
</div>













    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('js'); ?>
    <script>
        $(function () {
            $(".dial").knob({
                heigth: 90,
                width: 90,
                readOnly: true,
                format: function (value) {
                    return value + '%';
                }
            });
        });
    </script>
    <?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>