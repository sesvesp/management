<?php $__env->startSection('title', 'Gerenciador - Painel'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Compras de armas</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>



        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                    </div>
                    <br><br>
                    <br><br>
                    <!-- <pre><?php echo e(var_dump($query)); ?></pre> -->
                </div>
            </div>
        </div>




    <!-- Modal -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>