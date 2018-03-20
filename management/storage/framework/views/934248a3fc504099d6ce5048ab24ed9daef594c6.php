<?php $__env->startSection('title', 'Gerenciador - Painel'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Envio de CAGED</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
        <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                    </div>
                    <form role="form" id="form" method="POST" action="<?php echo e(url('')); ?>">
                        <?php echo e(csrf_field()); ?>

                        <div class="box-body">
                            <pre><?php echo e(var_dump($empresas)); ?></pre>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>