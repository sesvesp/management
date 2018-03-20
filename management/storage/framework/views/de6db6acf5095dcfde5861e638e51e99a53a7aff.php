<?php $__env->startSection('title', 'Gerenciador - Painel'); ?>

<?php $__env->startSection('content_header'); ?>
    <div class="alert alert-success">
        <strong>Pronto!</strong> Os dados foram cadastrados com êxito.
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

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
                            <textarea id="pessoasData" name="pessoasData" class="form-control" rows="20"><?php echo e($query); ?></textarea>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>